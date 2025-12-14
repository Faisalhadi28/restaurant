<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    // Nama tabel (pastikan sama dengan yang di database)
    protected $table = 'pemesanan';

    protected $casts = [
        'tanggal_pesanan' => 'datetime',
    ];

    // Kolom yang boleh diisi mass assignment
    protected $fillable = [
        'user_id',
        'total_harga',
        'status',
        'tanggal_pesanan',
        'qrcode',
    ];

    /**
     * Relasi ke model User
     * Satu pemesanan dimiliki oleh satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class, 'pemesanan_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

}
