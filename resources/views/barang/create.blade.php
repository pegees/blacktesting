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
                <select name="supplier_id" class="w-full border-gray-300 rounded mt-1" required>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Kategori -->
            <div>
                <label class="block font-medium">Kategori</label>
                <select name="kategori_id" class="w-full border-gray-300 rounded mt-1" required>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Satuan -->
            <div>
                <label class="block font-medium">Satuan</label>
                <select name="satuan_id" class="w-full border-gray-300 rounded mt-1" required>
                    @foreach($satuans as $satuan)
                        <option value="{{ $satuan->id }}">{{ $satuan->nama_satuan }}</option>
                    @endforeach
                </select>
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

    <script>
        // Event Listener untuk menghitung sisa stok secara otomatis
        const isiStokInput = document.getElementById('isi_stok');
        const sisaStokInput = document.getElementById('sisa_stok');

        // Jika ada nilai isi_stok, maka sisa_stok di set sama dengan isi_stok
        isiStokInput.addEventListener('input', function () {
            const isiStok = parseFloat(isiStokInput.value) || 0;
            sisaStokInput.value = isiStok; // Set sisa_stok sama dengan isi_stok
        });
    </script>
</x-app-layout>

