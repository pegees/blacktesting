<x-app-layout>
    <div class="p-6">
        <h2 class="text-5xl font-bold mb-6 text-center">Tambah Data Pelanggan</h2>

        <!-- Form untuk menambah pelanggan -->
        <form action="{{ route('pelanggans.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nama Pelanggan -->
            <div>
                <label class="block font-medium">Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <!-- Alamat -->
            <div>
                <label class="block font-medium">Alamat</label>
                <textarea name="alamat" class="w-full border-gray-300 rounded mt-1"></textarea>
            </div>

            <!-- No Telp -->
            <div>
                <label class="block font-medium">No Telp</label>
                <input type="text" name="no_telp" class="w-full border-gray-300 rounded mt-1">
            </div>

            <!-- Tipe Pelanggan -->
            <div>
                <label class="block font-medium">Tipe Pelanggan</label>
                <select name="tipe_pelanggan" class="w-full border-gray-300 rounded mt-1" required>
                    <option value="baru">Baru</option>
                    <option value="reguler">Reguler</option>
                </select>
            </div>

            <!-- Email -->
            <div>
                <label class="block font-medium">Email</label>
                <input type="email" name="email" class="w-full border-gray-300 rounded mt-1">
            </div>

            <!-- Status -->
            <div>
                <label class="block font-medium">Status</label>
                <select name="status" class="w-full border-gray-300 rounded mt-1" required>
                    <option value="aktif">Aktif</option>
                    <option value="tidak_aktif">Tidak Aktif</option>
                </select>
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block font-medium">Keterangan</label>
                <textarea name="keterangan" class="w-full border-gray-300 rounded mt-1"></textarea>
            </div>

            <!-- Tombol Simpan dan Batal -->
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                    Simpan
                </button>
                <a href="{{ route('pelanggans.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>



