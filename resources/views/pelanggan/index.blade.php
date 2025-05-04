<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between mb-4">
            <form action="{{ route('pelanggans.index') }}" method="GET" class="flex space-x-2 justify-end">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pelanggan..." class="border p-2 rounded w-1/3 me-2">
                <!-- button search -->
                <button type="submit" class="col-md-0 btn btn-primary text-white px-4 py-2 rounded ">Cari</button>
            </form>
                
                <!-- button tambah pelanggan -->
                <a href="{{ route('pelanggans.create') }}" class="col-md-2 btn btn-primary text-white justify font-bold py-2 px-4 rounded">
                    + Tambah Pelanggan
                </a>
        </div>

        <div class="mt-4 bg-white shadow rounded-lg p-6">
            <table class="table-auto w-full text-center">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>No Telp</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Ket</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Menampilkan data pelanggan -->
                    @foreach($pelanggans as $pelanggan)
                        <tr class="border-t text-center">
                            <td>{{ $pelanggan->nama_pelanggan }}</td>
                            <td>{{ $pelanggan->email }}</td>
                            <td>{{ $pelanggan->alamat}}</td>
                            <td>{{ $pelanggan->no_telp }}</td>
                            <td>{{ ucfirst($pelanggan->tipe_pelanggan) }}</td>
                            <td>{{ ucfirst($pelanggan->status) }}</td>
                            <td>{{ $pelanggan->keterangan}}</td>

                            <td class="flex justify-center space-x-2 mt-2">
                                <!-- Link untuk edit pelanggan -->
                                <a href="{{ route('pelanggans.edit', $pelanggan->id) }}" class="btn btn-primary text-white px-3 py-1 rounded me-2">Edit</a>
                                
                                <!-- Link untuk lihat detail pelanggan -->
                                <a href="{{ route('pelanggans.show', $pelanggan->id) }}" class="btn btn-info text-white px-3 py-1 rounded me-2">Lihat</a>

                                <!-- Form untuk hapus pelanggan -->
                                <form action="{{ route('pelanggans.destroy', $pelanggan->id) }}" method="POST" onsubmit="return confirm('Yakin hapus pelanggan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger text-white px-3 py-1 rounded me-2">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                <!-- Pagination -->
                {{ $pelanggans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>



