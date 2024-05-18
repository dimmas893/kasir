<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Traits\HasFormatRupiah;

class Transaksi extends Model
{
    use HasFactory;
    use HasFormatRupiah;

    protected $fillable = [
        'kode_transaksi',
        'total',
        'bayar',
        'kembali',
        'kode_kasir',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
