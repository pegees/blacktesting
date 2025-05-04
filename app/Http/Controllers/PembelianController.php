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
            ->get();

        return view('pembelian.index', compact('pembelians', 'tanggal'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $barangs = Barang::all();
        $no_transaksi = 'PB' . time(); // bisa disesuaikan

        return view('pembelian.create', compact('suppliers', 'barangs', 'no_transaksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'status' => 'required|in:tunai,kredit',
            'keterangan' => 'nullable|string',
            'barang_id' => 'required|array',
            'barang_id.*' => 'required|exists:barangs,id',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Generate no_transaksi yang unik
            $no_transaksi = $this->generateNoTransaksi();

            $pembelian = Pembelian::create([
                'no_transaksi' => $no_transaksi,
                'tanggal' => now(),
                'tempo' => now(), // sesuaikan kalau butuh tempo kredit
                'status' => $request->status,
                'supplier_id' => $request->supplier_id,
                'keterangan' => $request->keterangan,
                'total' => 0,
                'bayar' => $request->bayar ?? 0,
            ]);

            $total = 0;

            foreach ($request->barang_id as $i => $barang_id) {
                $barang = Barang::findOrFail($barang_id);
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
            $no = 'PB' . time() . rand(100, 999);
        } while (Pembelian::where('no_transaksi', $no)->exists());

        return $no;
    }

    public function show($id)
    {
        $pembelian = Pembelian::with('details.barang')->findOrFail($id);
        return view('pembelian.show', compact('pembelian'));
    }


    public function destroy($id)
    {
        try {
            $pembelian = Pembelian::findOrFail($id);

            // Hapus detail pembelian terkait
            foreach ($pembelian->details as $detail) {
                // Kembalikan stok
                $barang = $detail->barang;
                $barang->sisa_stok -= $detail->qty;
                $barang->save();

                $detail->delete();
            }

            $pembelian->delete();

            return redirect()->route('pembelian.index')->with('success', 'Transaksi berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }

    

}
