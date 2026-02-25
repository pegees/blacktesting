<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\DetailPembelian;

use App\Models\Barang;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->tanggal;
        $pembelians = Pembelian::when($tanggal, function ($query, $tanggal) {
                return $query->whereDate('tanggal', $tanggal);
            })
            ->with('supplier')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('pembelian.index', compact('pembelians', 'tanggal'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $barangs = Barang::all();

        return view('pembelian.create', compact('suppliers', 'barangs'));
    }

    public function store(Request $request)
    {
        // Strip thousand separator dots from bayar field
        if ($request->has('bayar')) {
            $request->merge(['bayar' => str_replace('.', '', $request->input('bayar'))]);
        }

        $barangCount = is_array($request->barang_id) ? count($request->barang_id) : 0;

        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'status' => 'required|in:tunai,kredit',
            'keterangan' => 'nullable|string|max:1000',
            'barang_id' => 'required|array|min:1',
            'barang_id.*' => 'required|exists:barangs,id',
            'qty' => "required|array|size:{$barangCount}",
            'qty.*' => 'required|integer|min:1',
            'bayar' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $no_transaksi = $this->generateNoTransaksi();

            $pembelian = Pembelian::create([
                'no_transaksi' => $no_transaksi,
                'tanggal' => now(),
                'tempo' => $request->status === 'kredit' ? now()->addDays(30) : now(),
                'status' => $request->status,
                'supplier_id' => $request->supplier_id,
                'keterangan' => $request->keterangan,
                'total' => 0,
                'bayar' => $request->bayar ?? 0,
            ]);

            $total = 0;

            foreach ($request->barang_id as $i => $barang_id) {
                // BUG 13 FIX: Use lockForUpdate() to prevent stock race condition
                $barang = Barang::lockForUpdate()->findOrFail($barang_id);
                $qty = $request->qty[$i];
                $harga_beli = $barang->harga_beli;
                $jumlah = $qty * $harga_beli;

                DetailPembelian::create([
                    'pembelian_id' => $pembelian->id,
                    'barang_id' => $barang_id,
                    'qty' => $qty,
                    'harga_beli' => $harga_beli,
                    'jumlah' => $jumlah,
                ]);

                $barang->sisa_stok += $qty;
                $barang->save();

                $total += $jumlah;
            }

            $pembelian->update(['total' => $total]);

            DB::commit();

            return redirect()->route('pembelian.index')->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    private function generateNoTransaksi()
    {
        do {
            $no = 'PB-' . now()->format('Ymd') . '-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (Pembelian::where('no_transaksi', $no)->exists());

        return $no;
    }

    public function show($id)
    {
        $pembelian = Pembelian::with(['supplier', 'details.barang'])->findOrFail($id);
        return view('pembelian.show', compact('pembelian'));
    }


    public function destroy($id)
    {
        // BUG 4 FIX: Wrap destroy in DB transaction
        DB::beginTransaction();

        try {
            $pembelian = Pembelian::with('details.barang')->findOrFail($id);

            foreach ($pembelian->details as $detail) {
                $barang = $detail->barang;
                if ($barang) {
                    $barang->sisa_stok = max(0, $barang->sisa_stok - $detail->qty);
                    $barang->save();
                }
            }

            $pembelian->details()->delete();
            $pembelian->delete();

            DB::commit();

            return redirect()->route('pembelian.index')->with('success', 'Transaksi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}
