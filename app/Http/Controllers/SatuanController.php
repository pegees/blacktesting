<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SatuanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $satuans = Satuan::when($search, function ($query, $search) {
                        $query->where('nama_satuan', 'like', '%' . $search . '%');
                    })
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
        $validated = $request->validate([
            'nama_satuan' => 'required|string|max:255|unique:satuans',
        ]);

        $satuan = Satuan::create($validated);

        if ($request->ajax()) {
            return response()->json(['id' => $satuan->id, 'nama_satuan' => $satuan->nama_satuan]);
        }

        return redirect()->route('satuans.index')->with('success', 'Satuan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $satuan = Satuan::findOrFail($id);

        $validated = $request->validate([
            'nama_satuan' => ['required', 'string', 'max:255', Rule::unique('satuans')->ignore($satuan->id)],
        ]);

        $satuan->update($validated);

        return redirect()->route('satuans.index')->with('success', 'Satuan berhasil diupdate.');
    }

    public function destroy($id)
    {
        $satuan = Satuan::findOrFail($id);

        if ($satuan->barangs()->exists()) {
            return redirect()->route('satuans.index')->with('error', 'Satuan tidak bisa dihapus karena masih digunakan oleh barang.');
        }

        $satuan->delete();

        return redirect()->route('satuans.index')->with('success', 'Satuan berhasil dihapus.');
    }
}
