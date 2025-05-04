<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $satuans = Satuan::where('nama_satuan', 'like', "%$search%")
                             ->paginate(10);

        return view('satuan.index', compact('satuans'));
    }

    public function create()
    {
        return view('satuan.create');
    }

    public function edit($id)
{
    $satuan = Satuan::findOrFail($id);
    return view('satuan.edit', compact('satuan'));
}
    public function store(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:255|unique:satuans',
        ]);

        Satuan::create($request->all());

        return redirect()->route('satuans.index')->with('success', 'Satuan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_satuan' => 'required|string|max:255|unique:satuans,nama_satuan,' . $id,
        ]);

        // Cari satuan berdasarkan ID
        $satuan = Satuan::findOrFail($id);

        // Update data satuan
        $satuan->update([
            'nama_satuan' => $request->nama_satuan,
        ]);

        // Redirect setelah update
        return redirect()->route('satuans.index')->with('success', 'Satuan berhasil diupdate.');
    }

    public function destroy($id)
    {
        // Cari satuan berdasarkan ID
        $satuan = Satuan::findOrFail($id);

        // Hapus satuan
        $satuan->delete();

        // Redirect setelah berhasil dihapus
        return redirect()->route('satuans.index')->with('success', 'Satuan berhasil dihapus.');
    }


}

