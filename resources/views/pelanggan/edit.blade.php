<x-app-layout>
    <div class="p-6">
        <h2 class="text-6xl font-bold mb-6 text-center">Edit Data Pelanggan</h2>

        <!-- Form untuk edit pelanggan -->
        <form action="{{ route('pelanggans.update', $pelanggan->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Pelanggan -->
            <div>
                <label class="block font-medium">Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <!-- Alamat -->
            <div>
                <label class="block font-medium">Alamat</label>
                <textarea name="alamat" class="w-full border-gray-300 rounded mt-1">{{ old('alamat', $pelanggan->alamat) }}</textarea>
            </div>

            <!-- No Telp -->
            <div>
                <label class="block font-medium">No Telp</label>
                <input type="text" name="no_telp" value="{{ old('no_telp', $pelanggan->no_telp) }}" class="w-full border-gray-300 rounded mt-1">
            </div>

            <!-- Tipe Pelanggan -->
            <div>
                <label class="block font-medium">Tipe Pelanggan</label>
                <select name="tipe_pelanggan" class="w-full border-gray-300 rounded mt-1" required>
                    <option value="baru" {{ old('tipe_pelanggan', $pelanggan->tipe_pelanggan) == 'baru' ? 'selected' : '' }}>Baru</option>
                    <option value="reguler" {{ old('tipe_pelanggan', $pelanggan->tipe_pelanggan) == 'reguler' ? 'selected' : '' }}>Reguler</option>
                </select>
            </div>

            <!-- Email -->
            <div>
                <label class="block font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email', $pelanggan->email) }}" class="w-full border-gray-300 rounded mt-1">
            </div>

            <!-- Status -->
            <div>
                <label class="block font-medium">Status</label>
                <select name="status" class="w-full border-gray-300 rounded mt-1" required>
                    <option value="aktif" {{ old('status', $pelanggan->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status', $pelanggan->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block font-medium">Keterangan</label>
                <textarea name="keterangan" class="w-full border-gray-300 rounded mt-1">{{ old('keterangan', $pelanggan->keterangan) }}</textarea>
            </div>

            <!-- Tombol Update dan Batal -->
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                    Update
                </button>
                <a href="{{ route('pelanggans.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>

