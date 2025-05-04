<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        
    <div class="flex justify-between mb-4">
            <form action="{{ route('satuans.index') }}" method="GET" class="flex space-x-2 justify-end">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari satuan..." class="border p-2 rounded w-1/3 me-2">
                <!-- button search -->
                <button type="submit" class="col-md-0 btn btn-primary text-white px-4 py-2 rounded ">Cari</button>
            </form>
                
                <!-- button tambah satuan-->
                <a href="{{ route('satuans.create') }}" class="col-md-2 btn btn-primary text-white justify font-bold py-2 px-4 rounded">
                    + Daftar Satuan
                </a>
        </div>

        <div class="mt-4 bg-white shadow rounded-lg p-6">
            <table class="table-auto w-full text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Satuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            <tbody>
        </div>
                @foreach ($satuans as $index => $satuan)
                    <tr class="border-t text-center">
                        <td>{{ $satuans->firstItem() + $index }}</td> <!-- Nomor urut -->
                        <td>{{ $satuan->nama_satuan }}</td>

                        <td class="flex justify-center space-x-2 mt-2">
                            <!-- Link untuk edit satuan -->
                            <a href="{{ route('satuans.edit', $satuan->id) }}" class="btn btn-primary text-white px-3 py-1 rounded me-2">Edit</a>

                            <!-- Form untuk hapus satuan -->
                            <form action="{{ route('satuans.destroy', $satuan->id) }}" method="POST" onsubmit="return confirm('Yakin hapus satuan ini?')">
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
            {{ $satuans->links() }}
        </div>
    </div>
</x-app-layout>