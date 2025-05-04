<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        
    <div class="flex justify-between mb-4">
            <form action="{{ route('kategoris.index') }}" method="GET" class="flex space-x-2 justify-end">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..." class="border p-2 rounded w-1/3 me-2">
                <!-- button search -->
                <button type="submit" class="col-md-0 btn btn-primary text-white px-4 py-2 rounded ">Cari</button>
            </form>
                
                <!-- button tambah kategori-->
                <a href="{{ route('kategoris.create') }}" class="col-md-2 btn btn-primary text-white justify font-bold py-2 px-4 rounded">
                    + Daftar Kategori
                </a>
        </div>

        <div class="mt-4 bg-white shadow rounded-lg p-6">
            <table class="table-auto w-full text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            <tbody>
        </div>
                @foreach ($kategoris as $index => $kategori)
                    <tr class="border-t text-center">
                        <td>{{ $kategoris->firstItem() + $index }}</td> <!-- Nomor urut -->
                        <td>{{ $kategori->nama_kategori }}</td>

                        <td class="flex justify-center space-x-2 mt-2">
                            <!-- Link untuk edit kategori -->
                            <a href="{{ route('kategoris.edit', $kategori->id) }}" class="btn btn-primary text-white px-3 py-1 rounded me-2">Edit</a>

                            <!-- Form untuk hapus pelanggan -->
                            <form action="{{ route('kategoris.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Yakin hapus pelanggan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger text-white px-3 py-1 rounded me-2">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $kategoris->links() }}
        </div>
    </div>
</x-app-layout>

