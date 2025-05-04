<x-app-layout>
    <div class="p-6">
        <h2 class="text-3xl font-bold mb-6 text-center">Edit Data Barang</h2>

        <form action="{{ route('barangs.update', $barang->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium">Nama Barang</label>
                <input type="text" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <div>
                <label class="block font-medium">Gambar Barang</label>
                <input type="file" name="gambar" class="w-full border-gray-300 rounded mt-1">
                @if($barang->gambar)
                    <p class="mt-2">Gambar saat ini: <img src="{{ asset('storage/' . $barang->gambar) }}" class="w-20 h-24 object-cover mt-1 rounded" /></p>
                @endif
            </div>

            <!-- Supplier -->
            <div>
                <label class="block font-medium">Supplier</label>
                <div class="flex space-x-2">
                    <select name="supplier_id" class="w-full border-gray-300 rounded mt-1 me-2">
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('suppliers.create', ['redirect' => 'barangs.create']) }}" class="btn btn-primary text-white px-4 py-2 rounded">+</a>
                </div>
            </div>

            <!-- Kategori -->
            <div>
                <label class="block font-medium">Kategori</label>
                <div class="flex space-x-2">
                    <select name="kategori_id" class="w-full border-gray-300 rounded mt-1 me-2">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('kategoris.create', ['redirect' => 'barangs.create']) }}" class="btn btn-primary text-white px-4 py-2 rounded ">+</a>
                </div>
            </div>

             <!-- Satuan -->
             <div>
                <label class="block font-medium">Satuan</label>
                <div class="flex space-x-2">
                    <select name="satuan_id" class="w-full border-gray-300 rounded mt-1 me-2">
                        <option value="">-- Pilih Satuan --</option>
                        @foreach($satuans as $satuan)
                            <option value="{{ $satuan->id }}">{{ $satuan->nama_satuan }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('satuans.create', ['redirect' => 'barangs.create']) }}" class="btn btn-primary text-white px-4 py-2 rounded">+</a>
                </div>
            </div>

            <!-- Harga -->
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                <div>
                    <label class="block font-medium">Harga Beli</label>
                    <input type="number" name="harga_beli" value="{{ old('harga_beli', $barang->harga_beli) }}" class="w-full border-gray-300 rounded mt-1">
                </div>

                <div>
                    <label class="block font-medium">Harga Grosir 1</label>
                    <input type="number" name="harga_grosir_1" value="{{ old('harga_grosir_1', $barang->harga_grosir_1) }}" class="w-full border-gray-300 rounded mt-1">
                </div>
                <div>
                    <label class="block font-medium">Harga Grosir 2</label>
                    <input type="number" name="harga_grosir_2" value="{{ old('harga_grosir_2', $barang->harga_grosir_2) }}" class="w-full border-gray-300 rounded mt-1">
                </div>
                <div>
                    <label class="block font-medium">Harga Grosir 3</label>
                    <input type="number" name="harga_grosir_3" value="{{ old('harga_grosir_3', $barang->harga_grosir_3) }}" class="w-full border-gray-300 rounded mt-1">
                </div>
                <div>
                    <label class="block font-medium">Harga Grosir 4</label>
                    <input type="number" name="harga_grosir_4" value="{{ old('harga_grosir_4', $barang->harga_grosir_4) }}" class="w-full border-gray-300 rounded mt-1">
                </div>
            </div>

            <div>
                <label class="block font-medium">Isi Stok</label>
                <input type="number" name="isi_stok" value="{{ old('isi_stok', $barang->isi_stok) }}" class="w-full border-gray-300 rounded mt-1">
            </div>

            <div class="flex space-x-4 mt-6">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-black font-bold py-2 px-6 rounded">
                    Update
                </button>
                <a href="{{ route('barangs.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
