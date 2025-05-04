<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto px-4">
        <div class="flex items-center gap-4 mb-4">
            <form action="{{ route('transaksi.index') }}" method="GET" class="flex gap-4 w-full">
            <!-- search -->
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Transaksi..." class="border px-3 py-2 rounded w-1/3">
            <!-- button cari dan tanggal -->
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="border px-3 py-2 rounded">
                <button type="submit" class="btn btn-primary text-white px-4 py-2 rounded">Cari</button>
            <!-- button transaksi baru -->
            </form>
            <a href="{{ route('transaksi.create') }}" class="col-md-2 btn btn-primary text-white justify font-bold py-2 px-4 rounded">
                + Transaksi Baru
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
                        <th class="px-4 py-2">Pelanggan</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Ket</th>
                        <th class="px-4 py-2">Timestamp</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse ($transaksis as $transaksi)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $transaksi->no_transaksi }}</td>
                            <td class="px-4 py-2">{{ $transaksi->tanggal }}</td>
                            <td class="px-4 py-2">{{ $transaksi->tempo }}</td>
                            <td class="px-4 py-2">{{ ucfirst($transaksi->status) }}</td>
                            <td class="px-4 py-2">{{ $transaksi->pelanggan->nama_pelanggan }}</td>
                            <td class="px-4 py-2">{{ number_format($transaksi->total, 0, ',', '.')}}</td>
                            <td class="px-4 py-2">{{ $transaksi->keterangan }}</td>
                            <td class="px-4 py-2">{{ $transaksi->created_at->format('Y-m-d H:i') }}</td>
                            <td class="flex justify-center space-x-2 mt-2">
                                <!-- button lihat -->
                                <a href="{{ route('transaksi.show', $transaksi->id) }}" class="btn btn-info text-white px-3 py-1 rounded me-2">Lihat</a>
                                <!-- button hapus -->
                                <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger text-white px-3 py-1 rounded me-2">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-4 text-gray-500">Tidak ada data transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
