<x-app-layout>
    <div class="p-6">
        <h2 class="text-5xl font-bold mb-6 text-center">Tambah Barang</h2>

        <!-- Form untuk menambah barang -->
        <form action="{{ route('barangs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Nama Barang -->
            <div>
                <label class="block font-medium">Nama Barang</label>
                <input type="text" name="nama_barang" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <!-- Gambar Barang -->
            <div>
                <label class="block font-medium">Gambar Barang</label>
                <input type="file" name="gambar" class="w-full border-gray-300 rounded mt-1">
            </div>

            <!-- Supplier -->
            <div>
                <label class="block font-medium">Supplier</label>
                <div class="flex gap-2 mt-1">
                    <select name="supplier_id" id="supplier_id" class="w-full border-gray-300 rounded" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                        @endforeach
                    </select>
                    <button type="button" onclick="openModal('supplierModal')" class="bg-green-500 hover:bg-green-600 text-white font-bold px-3 rounded whitespace-nowrap">+ Baru</button>
                </div>
            </div>

            <!-- Kategori -->
            <div>
                <label class="block font-medium">Kategori</label>
                <div class="flex gap-2 mt-1">
                    <select name="kategori_id" id="kategori_id" class="w-full border-gray-300 rounded" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                    <button type="button" onclick="openModal('kategoriModal')" class="bg-green-500 hover:bg-green-600 text-white font-bold px-3 rounded whitespace-nowrap">+ Baru</button>
                </div>
            </div>

            <!-- Satuan -->
            <div>
                <label class="block font-medium">Satuan</label>
                <div class="flex gap-2 mt-1">
                    <select name="satuan_id" id="satuan_id" class="w-full border-gray-300 rounded" required>
                        <option value="">-- Pilih Satuan --</option>
                        @foreach($satuans as $satuan)
                            <option value="{{ $satuan->id }}">{{ $satuan->nama_satuan }}</option>
                        @endforeach
                    </select>
                    <button type="button" onclick="openModal('satuanModal')" class="bg-green-500 hover:bg-green-600 text-white font-bold px-3 rounded whitespace-nowrap">+ Baru</button>
                </div>
            </div>

            <!-- Harga Beli -->
            <div>
                <label class="block font-medium">Harga Beli</label>
                <input type="number" name="harga_beli" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <!-- Harga Grosir 1 -->
            <div>
                <label class="block font-medium">Harga Grosir 1</label>
                <input type="number" name="harga_grosir_1" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <!-- Harga Grosir 2 -->
            <div>
                <label class="block font-medium">Harga Grosir 2</label>
                <input type="number" name="harga_grosir_2" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <!-- Harga Grosir 3 -->
            <div>
                <label class="block font-medium">Harga Grosir 3</label>
                <input type="number" name="harga_grosir_3" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <!-- Harga Grosir 4 -->
            <div>
                <label class="block font-medium">Harga Grosir 4</label>
                <input type="number" name="harga_grosir_4" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <!-- Isi Stok -->
            <div>
                <label class="block font-medium">Isi Stok</label>
                <input type="number" name="isi_stok" id="isi_stok" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <!-- Sisa Stok (otomatis dihitung) -->
            <div>
                <label class="block font-medium">Sisa Stok</label>
                <input type="number" name="sisa_stok" id="sisa_stok" class="w-full border-gray-300 rounded mt-1" readonly>
            </div>

            <!-- Tombol Simpan dan Batal -->
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                    Simpan
                </button>
                <a href="{{ route('barangs.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Modal Tambah Kategori -->
    <div id="kategoriModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Tambah Kategori Baru</h3>
                <button type="button" onclick="closeModal('kategoriModal')" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <div>
                <label class="block font-medium mb-1">Nama Kategori</label>
                <input type="text" id="new_kategori" class="w-full border-gray-300 rounded" placeholder="Masukkan nama kategori">
                <p id="kategoriError" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal('kategoriModal')" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded">Batal</button>
                <button type="button" onclick="simpanKategori()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Satuan -->
    <div id="satuanModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Tambah Satuan Baru</h3>
                <button type="button" onclick="closeModal('satuanModal')" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <div>
                <label class="block font-medium mb-1">Nama Satuan</label>
                <input type="text" id="new_satuan" class="w-full border-gray-300 rounded" placeholder="Masukkan nama satuan">
                <p id="satuanError" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal('satuanModal')" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded">Batal</button>
                <button type="button" onclick="simpanSatuan()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Supplier -->
    <div id="supplierModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Tambah Supplier Baru</h3>
                <button type="button" onclick="closeModal('supplierModal')" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <div class="space-y-3">
                <div>
                    <label class="block font-medium mb-1">Nama Supplier <span class="text-red-500">*</span></label>
                    <input type="text" id="new_supplier_nama" class="w-full border-gray-300 rounded" placeholder="Masukkan nama supplier">
                </div>
                <div>
                    <label class="block font-medium mb-1">No. Telp</label>
                    <input type="text" id="new_supplier_telp" class="w-full border-gray-300 rounded" placeholder="Masukkan no telp">
                </div>
                <div>
                    <label class="block font-medium mb-1">Tipe Supplier <span class="text-red-500">*</span></label>
                    <select id="new_supplier_tipe" class="w-full border-gray-300 rounded">
                        <option value="baru">Baru</option>
                        <option value="reguler">Reguler</option>
                    </select>
                </div>
                <p id="supplierError" class="text-red-500 text-sm hidden"></p>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal('supplierModal')" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded">Batal</button>
                <button type="button" onclick="simpanSupplier()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
            </div>
        </div>
    </div>

    <script>
        // Sisa stok otomatis
        const isiStokInput = document.getElementById('isi_stok');
        const sisaStokInput = document.getElementById('sisa_stok');
        isiStokInput.addEventListener('input', function () {
            sisaStokInput.value = parseFloat(isiStokInput.value) || 0;
        });

        // Modal helpers
        function openModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        const csrfToken = '{{ csrf_token() }}';

        // Simpan Kategori via AJAX
        function simpanKategori() {
            const nama = document.getElementById('new_kategori').value.trim();
            const errorEl = document.getElementById('kategoriError');
            errorEl.classList.add('hidden');

            if (!nama) {
                errorEl.textContent = 'Nama kategori harus diisi.';
                errorEl.classList.remove('hidden');
                return;
            }

            fetch('{{ route("kategoris.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ nama_kategori: nama })
            })
            .then(res => {
                if (!res.ok) return res.json().then(err => { throw err; });
                return res.json();
            })
            .then(data => {
                const select = document.getElementById('kategori_id');
                const option = new Option(data.nama_kategori, data.id, true, true);
                select.appendChild(option);
                document.getElementById('new_kategori').value = '';
                closeModal('kategoriModal');
            })
            .catch(err => {
                const msg = err.errors?.nama_kategori?.[0] || err.message || 'Gagal menyimpan kategori.';
                errorEl.textContent = msg;
                errorEl.classList.remove('hidden');
            });
        }

        // Simpan Satuan via AJAX
        function simpanSatuan() {
            const nama = document.getElementById('new_satuan').value.trim();
            const errorEl = document.getElementById('satuanError');
            errorEl.classList.add('hidden');

            if (!nama) {
                errorEl.textContent = 'Nama satuan harus diisi.';
                errorEl.classList.remove('hidden');
                return;
            }

            fetch('{{ route("satuans.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ nama_satuan: nama })
            })
            .then(res => {
                if (!res.ok) return res.json().then(err => { throw err; });
                return res.json();
            })
            .then(data => {
                const select = document.getElementById('satuan_id');
                const option = new Option(data.nama_satuan, data.id, true, true);
                select.appendChild(option);
                document.getElementById('new_satuan').value = '';
                closeModal('satuanModal');
            })
            .catch(err => {
                const msg = err.errors?.nama_satuan?.[0] || err.message || 'Gagal menyimpan satuan.';
                errorEl.textContent = msg;
                errorEl.classList.remove('hidden');
            });
        }

        // Simpan Supplier via AJAX
        function simpanSupplier() {
            const nama = document.getElementById('new_supplier_nama').value.trim();
            const telp = document.getElementById('new_supplier_telp').value.trim();
            const tipe = document.getElementById('new_supplier_tipe').value;
            const errorEl = document.getElementById('supplierError');
            errorEl.classList.add('hidden');

            if (!nama) {
                errorEl.textContent = 'Nama supplier harus diisi.';
                errorEl.classList.remove('hidden');
                return;
            }

            fetch('{{ route("suppliers.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    nama_supplier: nama,
                    no_telp: telp || null,
                    tipe_supplier: tipe,
                })
            })
            .then(res => {
                if (!res.ok) return res.json().then(err => { throw err; });
                return res.json();
            })
            .then(data => {
                const select = document.getElementById('supplier_id');
                const option = new Option(data.nama_supplier, data.id, true, true);
                select.appendChild(option);
                document.getElementById('new_supplier_nama').value = '';
                document.getElementById('new_supplier_telp').value = '';
                closeModal('supplierModal');
            })
            .catch(err => {
                const msg = err.errors?.nama_supplier?.[0] || err.message || 'Gagal menyimpan supplier.';
                errorEl.textContent = msg;
                errorEl.classList.remove('hidden');
            });
        }
    </script>
</x-app-layout>
