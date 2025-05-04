<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi')->unique();
            $table->date('tanggal');
            $table->date('tempo');
            $table->foreignId('pelanggan_id')->constrained()->onDelete('cascade');
            $table->decimal('total', 15, 2)->default(0);
            $table->enum('status', ['tunai', 'kredit']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksis');
    }

};
