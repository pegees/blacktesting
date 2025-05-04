<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between mb-4">
            <form action="{{ route('suppliers.index') }}" method="GET" class="flex space-x-2 justify-end">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari supplier..." class="border p-2 rounded w-1/3 me-2">
                <!-- button search -->
                <button type="submit" class="col-md-0 btn btn-primary text-white px-4 py-2 rounded ">Cari</button>
            </form>
                
                <!-- button tambah supplier -->
                <a href="{{ route('suppliers.create') }}" class="col-md-2 btn btn-primary text-white justify font-bold py-2 px-4 rounded">
                    + Tambah Supplier
                </a>
        </div>
        

        <div class="mt-4 bg-white shadow rounded-lg p-6">
            <table class="table-auto w-full text-center">
                <thead>
                    <tr>
                        <th>Nama Supplier</th>
                        <th>Email</th>
                        <th>No Telp</th>
                        <th>Alamat</th>
                        <th>Keterangan</th>
                        <th>Tipe</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($suppliers as $supplier)
                    <tr class="border-t text-center">
                        <td>{{ $supplier->nama_supplier }}</td>
                        <td>{{ $supplier->email }}</td>
                        <td>{{ $supplier->no_telp }}</td>
                        <td>{{ $supplier->alamat }}</td>
                        <td>{{ $supplier->keterangan }}</td>
                        <td>{{ $supplier->tipe_supplier }}</td>
                        
                        <td class="flex justify-center space-x-2">
                            <!-- button edit -->
                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="col-md-0 btn btn-primary text-white me-2">Edit</a>
                            <!-- button lihat -->
                            <a href="{{ route('suppliers.show', $supplier->id) }}" class="col-md-0 btn btn-info text-white me-2">Lihat</a>
                            <!-- button hapus -->
                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="col-md-0 btn btn-danger text-white">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
