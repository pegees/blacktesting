<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h2 class="text-6xl font-bold text-gray-800 mb-8 border-b pb-2">Detail Transaksi Pembelian</h2>

        <div class="bg-white rounded-lg shadow-lg p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-500 text-sm">No Transaksi</p>
                <p class="text-lg text-gray-800">{{ $pembelian->no_transaksi }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Supplier</p>
                <p class="text-lg text-gray-800">{{ $pembelian->supplier->nama_supplier }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Total Pembelian</p>
                <!-- Mengubah format angka dengan titik sebagai pemisah ribuan dan tanpa desimal -->
                <p class="text-lg text-gray-800">{{ number_format($pembelian->total, 0, ',', '.') }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Status</p>
                <p class="text-lg text-gray-800">{{ ucfirst($pembelian->status) }}</p>
            </div>
        </div>

        <h3 class="text-3xl font-bold text-gray-800 mt-6 mb-4">Detail Barang</h3>
        <div class="bg-white rounded-lg shadow-lg p-6">
            <table class="w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Nama Barang</th>
                        <th class="px-4 py-2 text-left">Harga Beli</th>
                        <th class="px-4 py-2 text-left">Qty</th>
                        <th class="px-4 py-2 text-left">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembelian->details as $detail)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $detail->barang->nama_barang }}</td>
                            <!-- Mengubah format harga beli -->
                            <td class="px-4 py-2">{{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">{{ $detail->qty }}</td>
                            <!-- Mengubah format jumlah -->
                            <td class="px-4 py-2">{{ number_format($detail->harga_beli * $detail->qty, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('pembelian.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                Kembali
            </a>
        </div>
    </div>
</x-app-layout>
