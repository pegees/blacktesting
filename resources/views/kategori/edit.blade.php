<x-app-layout>
    <div class="p-6">
        <h2 class="text-6xl font-bold mb-6 text-center">Edit Kategori</h2>

        <form action="{{ route('kategoris.update', $kategori->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nama_kategori" class="block text-sm font-medium">Nama Kategori</label>
                <input type="text" name="nama_kategori" id="nama_kategori" class="w-full border-gray-300 rounded mt-1" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
            </div>

            <!-- Tombol Update dan Batal -->
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                    Update
                </button>
                <a href="{{ route('kategoris.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
