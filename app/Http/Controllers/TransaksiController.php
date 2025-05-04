<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\TransaksiDetail;
use App\Models\Transaksi;
use Illuminate\Http\Request;

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
            'pelanggan_id' => 'required',
            'barang_id.*' => 'required',
            'qty.*' => 'required|numeric|min:1',
            'harga_jual.*' => 'required|numeric|min:0',
        ]);

        // Simpan transaksi utama
        $transaksi = Transaksi::create([
            'no_transaksi' => 'TRX-' . time(),
            'tanggal' => now(),
            'tempo' => now()->addDays(30),
            'pelanggan_id' => $request->pelanggan_id,
            'status' => 'tunai',
            'total' => 0 // sementara total 0, akan diupdate setelah detail
        ]);

        $total = 0;
        $barangStokCek = [];

        // Cek stok barang
        foreach ($request->barang_id as $index => $barangId) {
            $qty = $request->qty[$index];

            // Ambil barang berdasarkan ID
            $barang = Barang::find($barangId);
            
            // Jika barang tidak ditemukan atau stoknya tidak cukup
            if (!$barang || $barang->sisa_stok < $qty) {
                return redirect()->back()->with('error', 'Stok barang ' . $barang->nama_barang . ' tidak mencukupi.');
            }

            // Simpan detail transaksi
            $subtotal = $qty * $request->harga_jual[$index];

            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'barang_id' => $barangId,
                'qty' => $qty,
                'harga_jual' => $request->harga_jual[$index],
                'subtotal' => $subtotal,
            ]);

            // Kurangi stok barang
            $barang->sisa_stok -= $qty;
            $barang->save();

            $total += $subtotal;
        }

        // Update total transaksi
        $transaksi->update(['total' => $total]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat!');
    }


    public function show($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'details.barang'])->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }


    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Hapus semua detail terkait (jika ada relasi)
        $transaksi->details()->delete();

        // Hapus transaksi utama
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus!');
    }

}

