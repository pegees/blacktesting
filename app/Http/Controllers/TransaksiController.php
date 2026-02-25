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
        $transaksis = Transaksi::with('pelanggan')->latest()->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $lastTransaction = Transaksi::latest()->first();
        $no_transaksi = 'TRX-' . str_pad(($lastTransaction ? (substr($lastTransaction->no_transaksi, 4) + 1) : 1), 5, '0', STR_PAD_LEFT);

        $barangs = Barang::all();
        $pelanggans = Pelanggan::all();

        return view('transaksi.create', compact('no_transaksi', 'barangs', 'pelanggans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'barang_id' => 'required|array|min:1',
            'barang_id.*' => 'required|exists:barangs,id',
            'qty' => 'required|array|min:1',
            'qty.*' => 'required|integer|min:1',
            'harga_jual' => 'required|array|min:1',
            'harga_jual.*' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();

        try {
            $transaksi = Transaksi::create([
                'no_transaksi' => 'TRX-' . time(),
                'tanggal' => now(),
                'tempo' => now()->addDays(30),
                'pelanggan_id' => $request->pelanggan_id,
                'status' => 'tunai',
                'total' => 0,
            ]);

            $total = 0;

            foreach ($request->barang_id as $index => $barangId) {
                $qty = $request->qty[$index];

                $barang = Barang::findOrFail($barangId);

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
