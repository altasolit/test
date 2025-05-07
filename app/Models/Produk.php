<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Kategori;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';
    
    protected $fillable = ['nama_produk', 'deskripsi', 'harga', 'stok', 'nama_file', 'kategori_id'];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }
}
