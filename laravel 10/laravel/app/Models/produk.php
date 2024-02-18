<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    use HasFactory;
    protected $fillable = [
        'namaproduk',
        'harga',
        'stok',
        ''
        // ... tambahkan kolom lain sesuai kebutuhan
    ];
    public $timestamps = false;
}
