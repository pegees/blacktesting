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

        @if($barangHabisStok->count())
            <div id="stok-alert" class="mb-4 p-4 bg-red-500 border-l-4 border-red-800 text-white rounded-lg shadow-lg">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center mb-2">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            <strong class="text-lg">PERINGATAN STOK HABIS!</strong>
                        </div>
                        <p class="mb-1">Barang berikut memiliki sisa stok = 0 dan perlu segera dilakukan pembelian/restok:</p>
                        <ul class="list-disc list-inside mt-2 ml-2">
                            @foreach($barangHabisStok as $namaBarang)
                                <li class="font-semibold">{{ $namaBarang }}</li>
                            @endforeach
                        </ul>
                        <p class="mt-2 text-sm text-red-100">Total {{ $barangHabisStok->count() }} barang habis stok.</p>
                    </div>
                    <button onclick="document.getElementById('stok-alert').remove()"
                            class="text-white hover:text-gray-200 font-bold text-xl leading-none ml-4">
                        &times;
                    </button>
                </div>
            </div>
        @endif



        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg shadow">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <div>
                        <strong class="text-lg">Berhasil!</strong>
                        <p class="mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-lg shadow">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    <div>
                        <strong class="text-lg">Gagal!</strong>
                        <p class="mt-1">{{ session('error') }}</p>
                    </div>
                </div>
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
                        <td>{{ $barangs->firstItem() + $index }}</td>
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
                                <span class="inline-block bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">STOK HABIS</span>
                            @elseif($barang->sisa_stok <= 5)
                                <span class="inline-block bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $barang->sisa_stok }} <small>(rendah)</small></span>
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

            <!-- Pagination -->
            <div class="mt-4">
                {{ $barangs->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
