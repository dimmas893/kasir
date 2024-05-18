<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Barang;
use App\Traits\HasFormatRupiah;

class TransaksiSementara extends Model
{
    use HasFactory;
    use HasFormatRupiah;

    protected $fillable = [
        'kode_transaksi',
        'barang_id',
        'harga',
        'jumlah',
        'diskon',
        'total',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
