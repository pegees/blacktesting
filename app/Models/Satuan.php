<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;

    // Tentukan kolom yang bisa diisi
    protected $fillable = ['nama_satuan'];

    // Kalau tabelnya sudah otomatis sesuai nama model plural (satuans), maka gak perlu mendeklarasikan $table
}

