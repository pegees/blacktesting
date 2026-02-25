<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $kategoris = Kategori::when($search, function ($query, $search) {
                        $query->where('nama_kategori', 'like', '%' . $search . '%');
                    })
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
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris',
        ]);

        Kategori::create($validated);

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $id,
        ]);

        $kategori = Kategori::findOrFail($id);

        $kategori->update($validated);

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        if ($kategori->barangs()->exists()) {
            return redirect()->route('kategoris.index')->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh barang.');
        }

        $kategori->delete();

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
