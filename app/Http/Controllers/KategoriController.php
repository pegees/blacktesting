<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $kategoris = Kategori::where('nama_kategori', 'like', "%$search%")
                             ->paginate(10);

        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function edit($id)
{
    $kategori = Kategori::findOrFail($id);
    return view('kategori.edit', compact('kategori'));
}
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris',
        ]);

        Kategori::create($request->all());

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $id,
        ]);

        // Cari kategori berdasarkan ID
        $kategori = Kategori::findOrFail($id);

        // Update data kategori
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        // Redirect setelah update
        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy($id)
    {
        // Cari kategori berdasarkan ID
        $kategori = Kategori::findOrFail($id);

        // Hapus kategori
        $kategori->delete();

        // Redirect setelah berhasil dihapus
        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil dihapus.');
    }


}

