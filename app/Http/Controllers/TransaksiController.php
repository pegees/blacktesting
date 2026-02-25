<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\TransaksiDetail;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        // BUG 2 FIX: Added pagination instead of ->get()
        $transaksis = Transaksi::with('pelanggan')->latest()->paginate(15);
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $barangs = Barang::where('sisa_stok', '>', 0)->get();
        $pelanggans = Pelanggan::where('status', 'aktif')->get();

        return view('transaksi.create', compact('barangs', 'pelanggans'));
    }

    public function store(Request $request)
    {
        // Strip thousand separator dots from harga_jual array
        if (is_array($request->harga_jual)) {
            $request->merge(['harga_jual' => array_map(fn($v) => str_replace('.', '', $v), $request->harga_jual)]);
        }

        $barangCount = is_array($request->barang_id) ? count($request->barang_id) : 0;

        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'status' => 'required|in:tunai,kredit',
            'barang_id' => 'required|array|min:1',
            'barang_id.*' => 'required|distinct|exists:barangs,id',
            'qty' => "required|array|size:{$barangCount}",
            'qty.*' => 'required|integer|min:1',
            'harga_jual' => "required|array|size:{$barangCount}",
            'harga_jual.*' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();

        try {
            // BUG 1 FIX: Generate unique no_transaksi with collision prevention
            $no_transaksi = $this->generateNoTransaksi();

            $transaksi = Transaksi::create([
                'no_transaksi' => $no_transaksi,
                'tanggal' => now(),
                'tempo' => $request->status === 'kredit' ? now()->addDays(30) : now(),
                'pelanggan_id' => $request->pelanggan_id,
                // BUG 10 FIX: Use request status instead of hardcoded 'tunai'
                'status' => $request->status,
                'total' => 0,
            ]);

            $total = 0;

            foreach ($request->barang_id as $index => $barangId) {
                $qty = $request->qty[$index];

                // BUG 3 FIX: Use lockForUpdate() to prevent race condition on stock
                $barang = Barang::lockForUpdate()->findOrFail($barangId);

                if ($barang->sisa_stok < $qty) {
                    throw new \Exception('Stok barang ' . $barang->nama_barang . ' tidak mencukupi. Sisa stok: ' . $barang->sisa_stok);
                }

                $subtotal = $qty * $request->harga_jual[$index];

                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $barangId,
                    'qty' => $qty,
                    'harga_jual' => $request->harga_jual[$index],
                    'subtotal' => $subtotal,
                ]);

                $barang->sisa_stok -= $qty;
                $barang->save();

                $total += $subtotal;
            }

            $transaksi->update(['total' => $total]);

            DB::commit();

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    private function generateNoTransaksi()
    {
        do {
            $no = 'TRX-' . now()->format('Ymd') . '-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (Transaksi::where('no_transaksi', $no)->exists());

        return $no;
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'details.barang'])->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }


    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $transaksi = Transaksi::with('details.barang')->findOrFail($id);

            foreach ($transaksi->details as $detail) {
                $barang = $detail->barang;
                if ($barang) {
                    $barang->sisa_stok += $detail->qty;
                    $barang->save();
                }
            }

            $transaksi->details()->delete();
            $transaksi->delete();

            DB::commit();

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('transaksi.index')->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}
