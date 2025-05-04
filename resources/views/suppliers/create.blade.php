<x-app-layout>
    <div class="p-6">
        <h2 class="text-6xl font-bold mb-6 text-center">Tambah Data Supplier</h2>

        <form action="{{ route('suppliers.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block font-medium">Nama Supplier</label>
                <input type="text" name="nama_supplier" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <div>
                <label class="block font-medium">No Telp</label>
                <input type="text" name="no_telp" class="w-full border-gray-300 rounded mt-1">
                <small class="text-gray-500">Opsional</small>
            </div>

            <div>
                <label class="block font-medium">Alamat</label>
                <textarea name="alamat" class="w-full border-gray-300 rounded mt-1"></textarea>
                <small class="text-gray-500">Opsional</small>
            </div>

            <div>
                <label class="block font-medium">Keterangan</label>
                <textarea name="keterangan" class="w-full border-gray-300 rounded mt-1"></textarea>
                <small class="text-gray-500">Opsional</small>
            </div>

            <div>
                <label class="block font-medium">Tipe Supplier</label>
                <select name="tipe_supplier" class="w-full border-gray-300 rounded mt-1" required>
                    <option value="baru">Baru</option>
                    <option value="reguler">Reguler</option>
                </select>
            </div>

            <div>
                <label class="block font-medium">Email</label>
                <input type="email" name="email" class="w-full border-gray-300 rounded mt-1">
                <small class="text-gray-500">Opsional</small>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                    Simpan
                </button>
                <a href="{{ route('suppliers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>

