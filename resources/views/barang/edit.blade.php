<x-app-layout>
    <div class="p-6">
        <h2 class="text-3xl font-bold mb-6 text-center">Edit Data Barang</h2>

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded shadow">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    <strong class="text-lg">Validasi Gagal!</strong>
                </div>
                <p class="mb-2">Data yang Anda masukkan memiliki kesalahan berikut:</p>
                <ul class="list-disc list-inside ml-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('barangs.update', $barang->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6" novalidate>
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium">Nama Barang <span class="text-red-500">*</span></label>
                <input type="text" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" class="w-full border-gray-300 rounded mt-1 @error('nama_barang') border-red-500 @enderror">
                @error('nama_barang')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Gambar Barang</label>
                <input type="file" name="gambar" class="w-full border-gray-300 rounded mt-1 @error('gambar') border-red-500 @enderror">
                @error('gambar')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                @if($barang->gambar)
                    <p class="mt-2">Gambar saat ini: <img src="{{ asset('storage/' . $barang->gambar) }}" class="w-20 h-24 object-cover mt-1 rounded" /></p>
                @endif
            </div>

            <!-- Supplier -->
            <div>
                <label class="block font-medium">Supplier</label>
                <div class="flex gap-2 mt-1">
                    <select name="supplier_id" id="supplier_id" class="w-full border-gray-300 rounded" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id', $barang->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->nama_supplier }}</option>
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
                            <option value="{{ $kategori->id }}" {{ old('kategori_id', $barang->kategori_id) == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
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
                            <option value="{{ $satuan->id }}" {{ old('satuan_id', $barang->satuan_id) == $satuan->id ? 'selected' : '' }}>{{ $satuan->nama_satuan }}</option>
                        @endforeach
                    </select>
                    <button type="button" onclick="openModal('satuanModal')" class="bg-green-500 hover:bg-green-600 text-white font-bold px-3 rounded whitespace-nowrap">+ Baru</button>
                </div>
            </div>

            <!-- Harga -->
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                <div>
                    <label class="block font-medium">Harga Beli <span class="text-red-500">*</span></label>
                    <input type="text" inputmode="numeric" name="harga_beli" value="{{ old('harga_beli', $barang->harga_beli) }}" class="w-full border-gray-300 rounded mt-1 format-rupiah @error('harga_beli') border-red-500 @enderror">
                    @error('harga_beli')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-medium">Harga Grosir 1 <span class="text-red-500">*</span></label>
                    <input type="text" inputmode="numeric" name="harga_grosir_1" value="{{ old('harga_grosir_1', $barang->harga_grosir_1) }}" class="w-full border-gray-300 rounded mt-1 format-rupiah @error('harga_grosir_1') border-red-500 @enderror">
                    @error('harga_grosir_1')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block font-medium">Harga Grosir 2 <span class="text-red-500">*</span></label>
                    <input type="text" inputmode="numeric" name="harga_grosir_2" value="{{ old('harga_grosir_2', $barang->harga_grosir_2) }}" class="w-full border-gray-300 rounded mt-1 format-rupiah @error('harga_grosir_2') border-red-500 @enderror">
                    @error('harga_grosir_2')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block font-medium">Harga Grosir 3 <span class="text-red-500">*</span></label>
                    <input type="text" inputmode="numeric" name="harga_grosir_3" value="{{ old('harga_grosir_3', $barang->harga_grosir_3) }}" class="w-full border-gray-300 rounded mt-1 format-rupiah @error('harga_grosir_3') border-red-500 @enderror">
                    @error('harga_grosir_3')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block font-medium">Harga Grosir 4 <span class="text-red-500">*</span></label>
                    <input type="text" inputmode="numeric" name="harga_grosir_4" value="{{ old('harga_grosir_4', $barang->harga_grosir_4) }}" class="w-full border-gray-300 rounded mt-1 format-rupiah @error('harga_grosir_4') border-red-500 @enderror">
                    @error('harga_grosir_4')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block font-medium">Isi Stok <span class="text-red-500">*</span></label>
                <input type="number" name="isi_stok" value="{{ old('isi_stok', $barang->isi_stok) }}" class="w-full border-gray-300 rounded mt-1 @error('isi_stok') border-red-500 @enderror">
                @error('isi_stok')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-4 mt-6">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded">
                    Update
                </button>
                <a href="{{ route('barangs.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
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
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                body: JSON.stringify({ nama_kategori: nama })
            })
            .then(res => { if (!res.ok) return res.json().then(err => { throw err; }); return res.json(); })
            .then(data => {
                const select = document.getElementById('kategori_id');
                const option = new Option(data.nama_kategori, data.id, true, true);
                select.appendChild(option);
                document.getElementById('new_kategori').value = '';
                closeModal('kategoriModal');
            })
            .catch(err => { errorEl.textContent = err.errors?.nama_kategori?.[0] || 'Gagal menyimpan kategori.'; errorEl.classList.remove('hidden'); });
        }

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
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                body: JSON.stringify({ nama_satuan: nama })
            })
            .then(res => { if (!res.ok) return res.json().then(err => { throw err; }); return res.json(); })
            .then(data => {
                const select = document.getElementById('satuan_id');
                const option = new Option(data.nama_satuan, data.id, true, true);
                select.appendChild(option);
                document.getElementById('new_satuan').value = '';
                closeModal('satuanModal');
            })
            .catch(err => { errorEl.textContent = err.errors?.nama_satuan?.[0] || 'Gagal menyimpan satuan.'; errorEl.classList.remove('hidden'); });
        }

        // Format rupiah dengan titik sebagai pemisah ribuan
        function formatRupiah(angka) {
            let number_string = angka.toString().replace(/[^0-9]/g, '');
            if (!number_string) return '';
            let sisa = number_string.length % 3;
            let rupiah = number_string.substr(0, sisa);
            let ribuan = number_string.substr(sisa).match(/\d{3}/gi);
            if (ribuan) {
                rupiah += (sisa ? '.' : '') + ribuan.join('.');
            }
            return rupiah;
        }

        // Auto-format on input
        document.querySelectorAll('.format-rupiah').forEach(function(input) {
            if (input.value) input.value = formatRupiah(input.value);
            input.addEventListener('input', function() {
                this.value = formatRupiah(this.value);
            });
        });

        // Strip dots before form submit
        document.querySelector('form').addEventListener('submit', function() {
            this.querySelectorAll('.format-rupiah').forEach(function(input) {
                input.value = input.value.replace(/\./g, '');
            });
        });

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
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                body: JSON.stringify({ nama_supplier: nama, no_telp: telp || null, tipe_supplier: tipe })
            })
            .then(res => { if (!res.ok) return res.json().then(err => { throw err; }); return res.json(); })
            .then(data => {
                const select = document.getElementById('supplier_id');
                const option = new Option(data.nama_supplier, data.id, true, true);
                select.appendChild(option);
                document.getElementById('new_supplier_nama').value = '';
                document.getElementById('new_supplier_telp').value = '';
                closeModal('supplierModal');
            })
            .catch(err => { errorEl.textContent = err.errors?.nama_supplier?.[0] || 'Gagal menyimpan supplier.'; errorEl.classList.remove('hidden'); });
        }
    </script>
</x-app-layout>
