<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
use App\Models\Satuan;
use App\Models\Supplier;
use App\Models\TransaksiSementara;
use App\Models\TransaksiDetail;
use App\Traits\HasFormatRupiah;

class Barang extends Model
{
    use HasFactory;
    use HasFormatRupiah;

    protected $fillable = [
        'kode',
        'nama',
        'kategori_id',
        'harga_beli',
        'harga_jual',
        'satuan_id',
        'stok',
    ];

    protected $guarded = [];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function TransaksiSementara()
    {
        return $this->hasMany(TransaksiSementara::class);
    }

    public function TransaksiDetail()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
