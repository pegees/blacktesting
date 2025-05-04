<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Detail Transaksi</h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white p-4 rounded shadow">
            <p><strong>No Transaksi:</strong> {{ $transaksi->no_transaksi }}</p>
            <p><strong>Pelanggan:</strong> {{ $transaksi->pelanggan->nama_pelanggan }}</p>
            <p><strong>Tanggal:</strong> {{ $transaksi->tanggal }}</p>
            <p><strong>Total:</strong> Rp {{ number_format($transaksi->total, 0, ',', '.') }}</p>
            <p><strong>Status:</strong> {{ $transaksi->status }}</p>
            <hr class="my-3">
            <h3 class="text-lg font-bold mb-2">Detail Barang</h3>
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-200">
                        <th>Barang</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi->details as $d)
                        <tr>
                            <td>{{ $d->barang->nama_barang }}</td>
                            <td>{{ $d->qty }}</td>
                            <td>{{ number_format($d->harga_jual, 0, ',', '.') }}</td>
                            <td>{{ number_format($d->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex justify-end">
            <a href="{{ route('transaksi.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                Kembali
            </a>
        </div>
    </div>
    
</x-app-layout>
