<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'image',
    ];


    /**
     * Relasi ke model Order (jika nanti kamu mau buat transaksi / pesanan)
     * Satu menu bisa muncul di banyak order detail.
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'menu_id');
    }
}
