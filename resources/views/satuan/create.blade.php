<x-app-layout>
    <div class="p-6">
        <h2 class="text-6xl font-bold mb-6 text-center">Tambah Satuan</h2>

        <form action="{{ route('satuans.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nama_satuan" class="block text-sm font-medium">Nama Satuan</label>
                <input type="text" name="nama_satuan" id="nama_satuan" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <!-- Tombol Simpan dan Batal -->
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                    Simpan
                </button>
                <a href="{{ route('satuans.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>