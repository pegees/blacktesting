<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <h2 class="text-2xl font-bold mb-6 text-center">Tambah Transaksi Pembelian</h2>

        <form action="{{ route('pembelian.store') }}" method="POST">
            @csrf

            <!-- Informasi Utama -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block mb-1 font-medium">Total Pembelian</label>
                    <input type="text" id="total" name="total" class="w-full bg-white border px-3 py-2 rounded bg-gray-100" readonly value="0">
                </div>
                <div>
                    <label class="block mb-1 font-medium">No Transaksi</label>
                    <input type="text" name="no_transaksi" class="w-full border px-3 py-2 rounded bg-gray-100 bg-white" readonly value="{{ $no_transaksi }}">
                </div>
                <div>
                    <label class="block mb-1 font-medium">Timestamp</label>
                    <input type="text" class="w-full border px-3 py-2 rounded bg-gray-100 bg-white" readonly value="{{ now() }}">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block mb-1 font-medium">Status</label>
                    <select name="status" class="w-full border px-3 py-2 rounded">
                        <option value="tunai">Tunai</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-1 font-medium">Keterangan</label>
                    <input type="text" name="keterangan" class="w-full border px-3 py-2 rounded">
                </div>
                <div>
                    <label class="block mb-1 font-medium">Supplier</label>
                    <select name="supplier_id" class="w-full border px-3 py-2 rounded">
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Detail Barang -->
            <div class="bg-gray-50 border p-4 rounded mb-6">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="font-semibold text-lg">Detail Barang</h3>
                    <button type="button" id="add-barang" >+ Tambah Barang</button>
                </div>

                <div id="barang-list" class="space-y-2">
                    <div class="grid grid-cols-5 gap-2 items-center barang-item">
                        <select name="barang_id[]" class="barang-dropdown border px-2 py-1 rounded">
                            <option value="">-- Pilih Barang --</option>
                            @foreach ($barangs as $barang)
                                <option value="{{ $barang->id }}" data-harga="{{ $barang->harga_beli }}">{{ $barang->nama_barang }}</option>
                            @endforeach
                        </select>
                        <!-- harga beli -->
                        <input type="text" name="harga_beli[]" class="harga-beli border px-2 py-1 rounded bg-gray-100 bg-white" readonly>
                        <!-- qty -->
                        <input type="number" name="qty[]" class="qty border px-2 py-1 rounded" min="1" value="1">
                        <!-- jumlah -->
                        <input type="text" name="jumlah[]" class="jumlah border px-2 py-1 rounded bg-gray-100 bg-white" readonly>
                        <!-- hapus -->
                        <button type="button" class="remove-barang text-red-600 ">Hapus</button>
                    </div>
                </div>
            </div>

            <!-- Total & Bayar -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block mb-1 font-medium">Bayar</label>
                    <input type="number" name="bayar" class="w-full border px-3 py-2 rounded" value="0">
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('pembelian.index') }}" class="bg-red-500 text-white px-4 py-2 rounded ">Cancel</a>
                <button type="submit" class="bg-green-600 text-black px-6 py-2 rounded hover:bg-green-700">Save</button>
            </div>
        </form>
    </div>

    {{-- Script --}}
    <script>
        function hitungJumlahDanTotal() {
            let total = 0;
            document.querySelectorAll('.barang-item').forEach(function(row) {
                const harga = parseFloat(row.querySelector('.harga-beli').value) || 0;
                const qty = parseInt(row.querySelector('.qty').value) || 0;
                const jumlah = harga * qty;
                row.querySelector('.jumlah').value = jumlah;
                total += jumlah;
            });
            document.getElementById('total').value = total;
        }

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('barang-dropdown')) {
                const harga = e.target.selectedOptions[0].getAttribute('data-harga');
                const row = e.target.closest('.barang-item');
                row.querySelector('.harga-beli').value = harga;
                hitungJumlahDanTotal();
            }
        });

        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('qty')) {
                hitungJumlahDanTotal();
            }
        });

        document.getElementById('add-barang').addEventListener('click', function () {
            const original = document.querySelector('.barang-item');
            const clone = original.cloneNode(true);

            clone.querySelectorAll('input').forEach(input => {
                if (!input.classList.contains('harga-beli')) {
                    input.value = input.classList.contains('qty') ? '1' : '';
                } else {
                    input.value = '';
                }
            });
            clone.querySelector('select').selectedIndex = 0;
            document.getElementById('barang-list').appendChild(clone);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-barang')) {
                const allRows = document.querySelectorAll('.barang-item');
                if (allRows.length > 1) {
                    e.target.closest('.barang-item').remove();
                    hitungJumlahDanTotal();
                }
            }
        });
    </script>
</x-app-layout>
