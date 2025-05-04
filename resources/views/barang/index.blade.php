<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between mb-4">
            <form action="{{ route('barangs.index') }}" method="GET" class="flex space-x-2 justify-end">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari barang..." class="border p-2 rounded w-1/3 me-2">
                <button type="submit" class="btn btn-primary text-white px-4 py-2 rounded">Cari</button>
            </form>

            <a href="{{ route('barangs.create') }}" class="btn btn-primary text-white font-bold py-2 px-4 rounded">
                + Tambah Barang
            </a>
        </div>

        @if($barangs->where('sisa_stok', 0)->count())
            <div id="stok-alert" class="mb-4 p-4 bg-red-500 border border-red-600 text-white rounded">
                <div class="flex justify-between items-start">
                    <div>
                        <strong>Perhatian!</strong> Barang berikut kehabisan stok:
                        <ul class="list-disc list-inside mt-2">
                            @foreach($barangs->where('sisa_stok', 0) as $barangHabis)
                                <li>{{ $barangHabis->nama_barang }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button onclick="document.getElementById('stok-alert').remove()" 
                            class="text-white hover:text-gray-200 font-bold text-xl leading-none ml-4">
                        &times;
                    </button>
                </div>
            </div>
        @endif






        @if(session('success'))
            <div class="mb-4 text-green-600 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-4 bg-white shadow rounded-lg p-6">
            <table class="table-auto w-full text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Barang</th>
                        <th>Supplier</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Harga Beli</th>
                        <th>Harga 1</th>
                        <th>Harga 2</th>
                        <th>Harga 3</th>
                        <th>Harga 4</th>
                        <th>Isi Stok</th>
                        <th>Sisa Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $index => $barang)
                    
                    <tr class="border-t text-center">
                        <td>{{ $index + 1 }}</td>
                        <td>
                        @if($barang->gambar)
                            <img src="{{ asset('storage/' . $barang->gambar) }}" alt="Gambar" class="w-15 h-16 object-cover mx-auto rounded">
                        @else
                            <span class="text-gray-400">-</span>
                        @endif

                        </td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->supplier->nama_supplier ?? '-' }}</td>
                        <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ $barang->satuan->nama_satuan ?? '-' }}</td>
                        <td>{{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                        <td>{{ number_format($barang->harga_grosir_1, 0, ',', '.') }}</td>
                        <td>{{ number_format($barang->harga_grosir_2, 0, ',', '.') }}</td>
                        <td>{{ number_format($barang->harga_grosir_3, 0, ',', '.') }}</td>
                        <td>{{ number_format($barang->harga_grosir_4, 0, ',', '.') }}</td>
                        <td>{{ $barang->isi_stok }}</td>
                        <td>
                            @if($barang->sisa_stok == 0)
                                <span class="text-red-600 font-bold">Habis</span>
                            @else
                                {{ $barang->sisa_stok }}
                            @endif
                        </td>
                        <td class="flex justify-center space-x-2">
                            <!-- button edit -->
                            <a href="{{ route('barangs.edit', $barang->id) }}" class="col-md-0 btn btn-primary text-white me-2">Edit</a>
                            <!-- button lihat -->
                            <a href="{{ route('barangs.show', $barang->id) }}" class="col-md-0 btn btn-info text-white me-2">Lihat</a>
                            <!-- button hapus -->
                            <form action="{{ route('barangs.destroy', $barang->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="col-md-0 btn btn-danger text-white">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="14" class="py-4 text-gray-500">Data barang tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
