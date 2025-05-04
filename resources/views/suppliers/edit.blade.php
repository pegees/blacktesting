<x-app-layout>
    <div class="p-6">
        <h2 class="text-6xl font-bold mb-6 text-center">Edit Data Supplier</h2>

        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium">Nama Supplier</label>
                <input type="text" name="nama_supplier" value="{{ old('nama_supplier', $supplier->nama_supplier) }}" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <div>
                <label class="block font-medium">No Telp</label>
                <input type="text" name="no_telp" value="{{ old('no_telp', $supplier->no_telp) }}" class="w-full border-gray-300 rounded mt-1">
            </div>

            <div>
                <label class="block font-medium">Alamat</label>
                <textarea name="alamat" class="w-full border-gray-300 rounded mt-1">{{ old('alamat', $supplier->alamat) }}</textarea>
            </div>

            <div>
                <label class="block font-medium">Keterangan</label>
                <textarea name="keterangan" class="w-full border-gray-300 rounded mt-1">{{ old('keterangan', $supplier->keterangan) }}</textarea>
            </div>

            <div>
                <label class="block font-medium">Tipe Supplier</label>
                <select name="tipe_supplier" class="w-full border-gray-300 rounded mt-1" required>
                    <option value="baru" {{ old('tipe_supplier', $supplier->tipe_supplier) == 'baru' ? 'selected' : '' }}>Baru</option>
                    <option value="reguler" {{ old('tipe_supplier', $supplier->tipe_supplier) == 'reguler' ? 'selected' : '' }}>Reguler</option>
                </select>
            </div>

            <div>
                <label class="block font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email', $supplier->email) }}" class="w-full border-gray-300 rounded mt-1">
                <small class="text-gray-500">Opsional</small>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-black font-bold py-2 px-4 rounded">
                    Update
                </button>
                <a href="{{ route('suppliers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>

