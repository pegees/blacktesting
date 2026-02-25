<?php

namespace App\Http\Controllers;
use App\Models\Supplier;
use App\Models\Kategori;
use App\Models\Satuan;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $barangs = Barang::with(['supplier', 'kategori', 'satuan'])
            ->when($search, function ($query, $search) {
                $query->where('nama_barang', 'like', '%' . $search . '%');
            })
            ->get();

        return view('barang.index', compact('barangs', 'search'));
    }

    public function create()
    {
        $barangList = Barang::all();
        $suppliers = Supplier::all();
        $kategoris = Kategori::all();
        $satuans = Satuan::all();

        return view('barang.create', compact('barangList','suppliers', 'kategoris', 'satuans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'supplier_id' => 'required|exists:suppliers,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'satuan_id' => 'required|exists:satuans,id',
            'harga_beli' => 'required|numeric|min:0',
            'harga_grosir_1' => 'required|numeric|min:0',
            'harga_grosir_2' => 'required|numeric|min:0',
            'harga_grosir_3' => 'required|numeric|min:0',
            'harga_grosir_4' => 'required|numeric|min:0',
            'isi_stok' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('barang', 'public');
            $validated['gambar'] = $path;
        }

        $validated['sisa_stok'] = $validated['isi_stok'];

        Barang::create($validated);

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil ditambahkan');
    }


    public function show(Barang $barang)
    {
        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $suppliers = Supplier::all();
        $kategoris = Kategori::all();
        $satuans = Satuan::all();

        return view('barang.edit', compact('barang', 'suppliers', 'kategoris', 'satuans'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'supplier_id' => 'required|exists:suppliers,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'satuan_id' => 'required|exists:satuans,id',
            'harga_beli' => 'required|numeric|min:0',
            'harga_grosir_1' => 'required|numeric|min:0',
            'harga_grosir_2' => 'required|numeric|min:0',
            'harga_grosir_3' => 'required|numeric|min:0',
            'harga_grosir_4' => 'required|numeric|min:0',
            'isi_stok' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('barang', 'public');
        }

        $barang->update($validated);

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        if ($barang->transaksiDetails()->exists() || $barang->detailPembelians()->exists()) {
            return redirect()->route('barangs.index')->with('error', 'Barang tidak bisa dihapus karena masih memiliki transaksi terkait.');
        }

        $barang->delete();
        return redirect()->route('barangs.index')->with('success', 'Barang berhasil dihapus.');
    }
}
