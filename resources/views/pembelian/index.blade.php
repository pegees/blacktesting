<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto px-4">
        <div class="flex items-center gap-4 mb-4">
            <form action="{{ route('pembelian.index') }}" method="GET" class="flex gap-4 w-full">
            <!-- search -->
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Pembelian..." class="border px-3 py-2 rounded w-1/3">
            <!-- button cari dan tanggal -->
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="border px-3 py-2 rounded">
                <button type="submit" class="btn btn-primary text-white px-4 py-2 rounded">Cari</button>
            <!-- button transaksi baru -->
            </form>
            <a href="{{ route('pembelian.create') }}" class="col-md-2 btn btn-primary text-white justify font-bold py-2 px-4 rounded">
                + Pembelian Baru
            </a>
        </div>

        <div class="mt-4 bg-white shadow rounded-lg p-6">
            <table class="table-auto w-full text-center">
                <thead>
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">No Transaksi</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Tempo</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Supplier</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Ket</th>
                        <th class="px-4 py-2">Timestamp</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse ($pembelians as $pembelian)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $pembelian->no_transaksi }}</td>
                            <td class="px-4 py-2">{{ $pembelian->tanggal }}</td>
                            <td class="px-4 py-2">{{ $pembelian->tempo }}</td>
                            <td class="px-4 py-2">{{ ucfirst($pembelian->status) }}</td>
                            <td class="px-4 py-2">{{ $pembelian->supplier->nama_supplier }}</td>
                            <td class="px-4 py-2">{{ number_format($pembelian->total, 0, ',', '.')}}</td>
                            <td class="px-4 py-2">{{ $pembelian->keterangan }}</td>
                            <td class="px-4 py-2">{{ $pembelian->created_at->format('Y-m-d H:i') }}</td>
                            <td class="flex justify-center space-x-2 mt-2">
                                <!-- button lihat -->
                                <a href="{{ route('pembelian.show', $pembelian->id) }}" class="btn btn-info text-white px-3 py-1 rounded me-2">Lihat</a>
                                <!-- button hapus -->
                                <form action="{{ route('pembelian.destroy', $pembelian->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger text-white px-3 py-1 rounded me-2">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-4 text-gray-500">Tidak ada data pembelian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
