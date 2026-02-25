<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_supplier', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('no_telp', 'like', '%' . $search . '%');
            });
        }
        $suppliers = $query->latest()->paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'no_telp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'tipe_supplier' => 'required|in:baru,reguler',
            'email' => 'nullable|email',
        ]);

        $supplier = Supplier::create($validated);

        if ($request->ajax()) {
            return response()->json(['id' => $supplier->id, 'nama_supplier' => $supplier->nama_supplier]);
        }

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'no_telp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'tipe_supplier' => 'required|in:baru,reguler',
            'email' => 'nullable|email',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($validated);
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        if ($supplier->barangs()->exists()) {
            return redirect()->route('suppliers.index')->with('error', 'Supplier tidak bisa dihapus karena masih memiliki barang terkait.');
        }

        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
    }

    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }
}
