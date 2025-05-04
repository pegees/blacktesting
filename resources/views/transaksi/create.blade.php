<x-app-layout>
    <div class="py-6 max-w-5xl mx-auto px-4">
        @if (session('error'))
            <div class="bg-red-500 text-white p-4 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800">Transaksi Baru</h2>
            </x-slot>

            <div class="mb-4">
                <label>No Transaksi</label>
                <input type="text" name="no_transaksi" value="{{ $no_transaksi }}" readonly class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block mb-1 font-medium">Timestamp</label>
                <input type="text" class="w-full border px-3 py-2 rounded bg-gray-100 bg-white" readonly value="{{ now() }}">
            </div>
            <div>
                <label class="block mb-1 font-medium">Status</label>
                <select name="status" class="w-full border px-3 py-2 rounded">
                    <option value="tunai">Tunai</option>
                </select>
            </div>
            <div class="mb-4">
                <label>Pilih Pelanggan</label>
                <select name="pelanggan_id" class="w-full border px-3 py-2 rounded" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach ($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama_pelanggan }}</option>
                    @endforeach
                </select>
            </div>

            <table class="w-full mb-4" id="barang-table">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Harga Level</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="barang_id[]" class="barang w-full border px-2 py-1 rounded" required>
                                <option value="">Pilih Barang</option>
                                @foreach ($barangs as $barang)
                                    <option value="{{ $barang->id }}"
                                        data-h1="{{ $barang->harga_grosir_1 }}"
                                        data-h2="{{ $barang->harga_grosir_2 }}"
                                        data-h3="{{ $barang->harga_grosir_3 }}"
                                        data-h4="{{ $barang->harga_grosir_4 }}">
                                        {{ $barang->nama_barang }} (Stok: {{ $barang->sisa_stok }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="level_harga[]" class="harga-level w-full border px-2 py-1 rounded" required>
                                <option value="1">Harga 1</option>
                                <option value="2">Harga 2</option>
                                <option value="3">Harga 3</option>
                                <option value="4">Harga 4</option>
                            </select>
                        </td>
                        <td><input type="number" step="any" name="harga_jual[]" class="harga w-full border px-2 py-1 rounded" required></td>
                        <td><input type="number" name="qty[]" class="qty w-full border px-2 py-1 rounded" required></td>
                        <td><input type="text" class="subtotal w-full border px-2 py-1 bg-white rounded bg-gray-100" readonly></td>
                        <td><button type="button" class="remove-row text-red-500">Hapus</button></td>
                    </tr>
                </tbody>
            </table>

            <button type="button" id="add-row" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">+ Tambah Barang</button>

            <div class="mb-4 text-right ">
                <strong>Total:</strong> <span id="total-display">0</span>
            </div>

            <a href="{{ route('transaksi.index') }}" class="bg-red-500 text-white px-4 py-2 rounded ">Cancel</a>
            <button type="submit" class="bg-green-600 text-black px-6 py-2 rounded hover:bg-green-700">Save</button>
        </form>
    </div>

    <script>
        function hitungSubtotal(row) {
            let qty = parseFloat(row.querySelector('.qty').value) || 0;
            let harga = parseFloat(row.querySelector('.harga').value) || 0;
            let subtotal = qty * harga;
            row.querySelector('.subtotal').value = subtotal.toFixed(2);
            return subtotal;
        }

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('#barang-table tbody tr').forEach(row => {
                total += hitungSubtotal(row);
            });
            document.getElementById('total-display').innerText = total.toLocaleString();
        }

        function updateHarga(row) {
            let select = row.querySelector('.barang');
            let level = row.querySelector('.harga-level').value;
            if (!select.value) return;

            let harga = select.options[select.selectedIndex].dataset['h' + level];
            row.querySelector('.harga').value = harga || 0;
            hitungSubtotal(row);
            updateTotal();
        }

        document.addEventListener('input', function (e) {
            if (e.target.classList.contains('qty') || e.target.classList.contains('harga')) {
                let row = e.target.closest('tr');
                hitungSubtotal(row);
                updateTotal();
            }
        });

        document.addEventListener('change', function (e) {
            if (e.target.classList.contains('barang') || e.target.classList.contains('harga-level')) {
                let row = e.target.closest('tr');
                updateHarga(row);
            }
        });

        document.getElementById('add-row').addEventListener('click', function () {
            let newRow = document.querySelector('#barang-table tbody tr').cloneNode(true);
            newRow.querySelectorAll('input').forEach(i => i.value = '');
            newRow.querySelector('.subtotal').value = '';
            newRow.querySelector('.barang').selectedIndex = 0;
            newRow.querySelector('.harga-level').selectedIndex = 0;
            document.querySelector('#barang-table tbody').appendChild(newRow);
            updateTotal();
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('tr').remove();
                updateTotal();
            }
        });
    </script>
</x-app-layout>
