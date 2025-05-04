<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h2 class="text-6xl font-bold text-gray-800 mb-8 border-b pb-2 text-center">Detail Data Barang</h2>

        <div class="bg-white rounded-lg shadow-lg p-6 grid grid-cols md:grid-cols-1 gap-4">
            <div class="md:col-span-2 flex ">
                @if($barang->gambar)
                    <img src="{{ asset('storage/' . $barang->gambar) }}" alt="Gambar Barang" class="w-25 rounded shadow">
                @else
                    <p class="text-gray-500 italic">Tidak ada gambar</p>
                @endif
            </div>

            <div>
                <p class="text-gray-500 text-sm">Nama Barang</p>
                <p class="text-lg text-gray-800">{{ $barang->nama_barang }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Supplier</p>
                <p class="text-lg text-gray-800">{{ $barang->supplier->nama_supplier ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Kategori</p>
                <p class="text-lg text-gray-800">{{ $barang->kategori->nama_kategori ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Satuan</p>
                <p class="text-lg text-gray-800">{{ $barang->satuan->nama_satuan ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Harga Beli</p>
                <p class="text-lg text-gray-800">Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</p>
            </div>

            @for ($i = 1; $i <= 4; $i++)
                <div>
                    <p class="text-gray-500 text-sm">Harga Grosir {{ $i }}</p>
                    <p class="text-lg text-gray-800">Rp {{ number_format($barang["harga_grosir_$i"], 0, ',', '.') }}</p>
                </div>
            @endfor

            <div>
                <p class="text-gray-500 text-sm">Isi Stok</p>
                <p class="text-lg text-gray-800">{{ $barang->isi_stok }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Sisa Stok</p>
                <span class="text-lg  {{ $barang->sisa_stok == 0 ? 'text-red-600' : 'text-gray-800' }}">
                    {{ $barang->sisa_stok }}
                </span>
                @if($barang->sisa_stok == 0)
                    <p class="text-red-600 mt-2">Stok habis!</p>
                @endif
            </div>

        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('barangs.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                Kembali
            </a>
        </div>
    </div>
</x-app-layout>
