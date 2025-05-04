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
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi')->unique();
            $table->date('tanggal')->default(now());
            $table->date('tempo')->nullable();
            $table->enum('status', ['tunai', 'kredit'])->default('tunai');
            $table->unsignedBigInteger('supplier_id');
            $table->text('keterangan')->nullable();
            $table->decimal('total', 15, 2)->default(0);
            $table->decimal('bayar', 15, 2)->default(0);
            $table->timestamps();
        
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};
