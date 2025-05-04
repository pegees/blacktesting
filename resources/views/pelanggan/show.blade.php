<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h2 class="text-6xl font-bold text-gray-800 mb-8 border-b pb-2">Detail Data Pelanggan</h2>

        <div class="bg-white rounded-lg shadow-lg p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-500 text-sm">Nama Pelanggan</p>
                <p class="text-lg text-gray-800">{{ $pelanggan->nama_pelanggan }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Email</p>
                <p class="text-lg text-gray-800">{{ $pelanggan->email ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">No Telepon</p>
                <p class="text-lg text-gray-800">{{ $pelanggan->no_telp ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Tipe Pelanggan</p>
                <span class="text-lg text-gray-800 
                    {{ $pelanggan->tipe_pelanggan === 'reguler' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                    {{ ucfirst($pelanggan->tipe_pelanggan) }}
                </span>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Status</p>
                <span class="text-lg text-gray-800 
                    {{ $pelanggan->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ ucfirst($pelanggan->status) }}
                </span>
            </div>

            <div class="md:col-span-2">
                <p class="text-gray-500 text-sm">Alamat</p>
                <p class="text-lg text-gray-800">{{ $pelanggan->alamat ?? '-' }}</p>
            </div>

            <div class="md:col-span-2">
                <p class="text-gray-500 text-sm">Keterangan</p>
                <p class="text-lg text-gray-800">{{ $pelanggan->keterangan ?? '-' }}</p>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('pelanggans.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                Kembali
            </a>
        </div>
    </div>
</x-app-layout>


