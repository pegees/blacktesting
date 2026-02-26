<?php

namespace App\Http\Controllers;
use App\Models\Supplier;
use App\Models\Kategori;
use App\Models\Satuan;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $barangs = Barang::with(['supplier', 'kategori', 'satuan'])
            ->when($search, function ($query, $search) {
                $query->where('nama_barang', 'like', '%' . $search . '%');
            })
            ->paginate(15);

        $barangHabisStok = Barang::where('sisa_stok', 0)->pluck('nama_barang');

        return view('barang.index', compact('barangs', 'search', 'barangHabisStok'));
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
        // Strip thousand separator dots from harga fields
        foreach (['harga_beli', 'harga_grosir_1', 'harga_grosir_2', 'harga_grosir_3', 'harga_grosir_4'] as $field) {
            if ($request->has($field)) {
                $request->merge([$field => str_replace('.', '', $request->input($field))]);
            }
        }

        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'supplier_id' => 'required|exists:suppliers,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'satuan_id' => 'required|exists:satuans,id',
            'harga_beli' => 'required|integer|min:0',
            'harga_grosir_1' => 'required|integer|min:0',
            'harga_grosir_2' => 'required|integer|min:0',
            'harga_grosir_3' => 'required|integer|min:0',
            'harga_grosir_4' => 'required|integer|min:0',
            'isi_stok' => 'required|integer|min:0',
        ], [
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'nama_barang.max' => 'Nama barang maksimal 255 karakter.',
            'gambar.image' => 'File harus berupa gambar (jpg, jpeg, png).',
            'gambar.mimes' => 'Format gambar harus: jpg, jpeg, atau png.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB (2048 KB).',
            'supplier_id.required' => 'Supplier wajib dipilih.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'satuan_id.required' => 'Satuan wajib dipilih.',
            'harga_beli.required' => 'Harga beli wajib diisi.',
            'harga_beli.integer' => 'Harga beli harus berupa angka bulat.',
            'harga_beli.min' => 'Harga beli tidak boleh kurang dari 0.',
            'harga_grosir_1.required' => 'Harga grosir 1 wajib diisi.',
            'harga_grosir_1.min' => 'Harga grosir 1 tidak boleh kurang dari 0.',
            'harga_grosir_2.required' => 'Harga grosir 2 wajib diisi.',
            'harga_grosir_2.min' => 'Harga grosir 2 tidak boleh kurang dari 0.',
            'harga_grosir_3.required' => 'Harga grosir 3 wajib diisi.',
            'harga_grosir_3.min' => 'Harga grosir 3 tidak boleh kurang dari 0.',
            'harga_grosir_4.required' => 'Harga grosir 4 wajib diisi.',
            'harga_grosir_4.min' => 'Harga grosir 4 tidak boleh kurang dari 0.',
            'isi_stok.required' => 'Isi stok wajib diisi.',
            'isi_stok.integer' => 'Isi stok harus berupa angka bulat.',
            'isi_stok.min' => 'Isi stok tidak boleh kurang dari 0.',
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('barang', 'public');
            $validated['gambar'] = $path;
        }

        $validated['sisa_stok'] = $validated['isi_stok'];

        $barang = Barang::create($validated);

        return redirect()->route('barangs.index')->with('success', 'Barang "' . $barang->nama_barang . '" berhasil ditambahkan dengan stok awal ' . $barang->sisa_stok . ' unit.');
    }


    public function show(Barang $barang)
    {
        $barang->load(['supplier', 'kategori', 'satuan']);
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
        // Strip thousand separator dots from harga fields
        foreach (['harga_beli', 'harga_grosir_1', 'harga_grosir_2', 'harga_grosir_3', 'harga_grosir_4'] as $field) {
            if ($request->has($field)) {
                $request->merge([$field => str_replace('.', '', $request->input($field))]);
            }
        }

        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'supplier_id' => 'required|exists:suppliers,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'satuan_id' => 'required|exists:satuans,id',
            'harga_beli' => 'required|integer|min:0',
            'harga_grosir_1' => 'required|integer|min:0',
            'harga_grosir_2' => 'required|integer|min:0',
            'harga_grosir_3' => 'required|integer|min:0',
            'harga_grosir_4' => 'required|integer|min:0',
            'isi_stok' => 'required|integer|min:0',
        ], [
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'nama_barang.max' => 'Nama barang maksimal 255 karakter.',
            'gambar.image' => 'File harus berupa gambar (jpg, jpeg, png).',
            'gambar.mimes' => 'Format gambar harus: jpg, jpeg, atau png.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB (2048 KB).',
            'supplier_id.required' => 'Supplier wajib dipilih.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'satuan_id.required' => 'Satuan wajib dipilih.',
            'harga_beli.required' => 'Harga beli wajib diisi.',
            'harga_beli.integer' => 'Harga beli harus berupa angka bulat.',
            'harga_beli.min' => 'Harga beli tidak boleh kurang dari 0.',
            'harga_grosir_1.min' => 'Harga grosir 1 tidak boleh kurang dari 0.',
            'harga_grosir_2.min' => 'Harga grosir 2 tidak boleh kurang dari 0.',
            'harga_grosir_3.min' => 'Harga grosir 3 tidak boleh kurang dari 0.',
            'harga_grosir_4.min' => 'Harga grosir 4 tidak boleh kurang dari 0.',
            'isi_stok.required' => 'Isi stok wajib diisi.',
            'isi_stok.integer' => 'Isi stok harus berupa angka bulat.',
            'isi_stok.min' => 'Isi stok tidak boleh kurang dari 0.',
        ]);

        // BUG 5 FIX: Delete old image when uploading new one
        if ($request->hasFile('gambar')) {
            if ($barang->gambar) {
                Storage::disk('public')->delete($barang->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('barang', 'public');
        }

        // BUG 7 FIX: Adjust sisa_stok when isi_stok changes
        $oldIsiStok = $barang->isi_stok;
        $newIsiStok = $validated['isi_stok'];
        if ($oldIsiStok != $newIsiStok) {
            $diff = $newIsiStok - $oldIsiStok;
            $validated['sisa_stok'] = max(0, $barang->sisa_stok + $diff);
        }

        $oldSisaStok = $barang->sisa_stok;
        $barang->update($validated);
        $barang->refresh();

        $message = 'Barang "' . $barang->nama_barang . '" berhasil diperbarui.';
        if ($oldIsiStok != $newIsiStok) {
            $message .= ' Isi stok diubah dari ' . $oldIsiStok . ' menjadi ' . $newIsiStok . ', sisa stok disesuaikan dari ' . $oldSisaStok . ' menjadi ' . $barang->sisa_stok . '.';
        }

        return redirect()->route('barangs.index')->with('success', $message);
    }

    public function destroy(Barang $barang)
    {
        if ($barang->transaksiDetails()->exists() || $barang->detailPembelians()->exists()) {
            return redirect()->route('barangs.index')->with('error', 'Gagal menghapus! Barang "' . $barang->nama_barang . '" tidak bisa dihapus karena masih memiliki transaksi penjualan atau pembelian terkait.');
        }

        // BUG 6 FIX: Delete image file when destroying barang
        if ($barang->gambar) {
            Storage::disk('public')->delete($barang->gambar);
        }

        $namaBarang = $barang->nama_barang;
        $barang->delete();
        return redirect()->route('barangs.index')->with('success', 'Barang "' . $namaBarang . '" berhasil dihapus beserta gambarnya dari sistem.');
    }
}
