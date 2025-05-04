<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id(); // sebagai nomor otomatis
            $table->string('nama_barang');
            $table->string('gambar')->nullable();
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained()->onDelete('cascade');
            $table->foreignId('satuan_id')->constrained()->onDelete('cascade');
            $table->integer('harga_beli');
            $table->integer('harga_grosir_1');
            $table->integer('harga_grosir_2');
            $table->integer('harga_grosir_3');
            $table->integer('harga_grosir_4');
            $table->integer('isi_stok');
            $table->integer('sisa_stok')->default(0); // akan dihitung dari transaksi
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
