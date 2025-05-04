<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['no_transaksi', 'tanggal', 'tempo', 'pelanggan_id', 'total', 'status'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id');
    }
}
