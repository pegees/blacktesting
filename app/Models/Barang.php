<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'gambar',
        'supplier_id',
        'kategori_id',
        'satuan_id',
        'harga_beli',
        'harga_grosir_1',
        'harga_grosir_2',
        'harga_grosir_3',
        'harga_grosir_4',
        'isi_stok',
        'sisa_stok',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }
}
