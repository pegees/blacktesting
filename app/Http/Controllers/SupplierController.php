<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // Menampilkan semua supplier
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_supplier', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('no_telp', 'like', '%' . $search . '%');
        }
        $suppliers = $query->latest()->paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }



    // Menampilkan form untuk menambah supplier baru
    public function create()
    {
        return view('suppliers.create');
    }

    // Menyimpan supplier baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'no_telp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'tipe_supplier' => 'required|in:baru,reguler',
            'email' => 'nullable|email',
        ]);

        Supplier::create($request->all());
        return redirect()->route('suppliers.index');
    }

    // Menampilkan form untuk mengedit supplier
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('suppliers.edit', compact('supplier'));
    }

    // Mengupdate supplier
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'no_telp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'tipe_supplier' => 'required|in:baru,reguler',
            'email' => 'nullable|email',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());
        return redirect()->route('suppliers.index');
    }

    // Menghapus supplier
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return redirect()->route('suppliers.index');
    }

    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
}
}

