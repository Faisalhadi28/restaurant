<?php

namespace App\Http\Controllers;
use App\Models\Pemesanan;
use App\Models\Menu;

use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function keranjang()
    {
        $pemesanan = Pemesanan::where('user_id', auth()->id())
                        ->where('status', 'pending')
                        ->with('orderDetail.menu')
                        ->first();
                        

        return view('keranjang', compact('pemesanan'));
    }


    private function hitungTotal(Pemesanan $pemesanan)
    {
        $total = $pemesanan->orderDetail->sum(function ($detail) {
            return $detail->jumlah * $detail->menu->price;
        });

        $pemesanan->update(['total_harga' => $total]);

        return $total;
    }



    public function checkout()
    {
        $userId = auth()->id();

        $pemesanan = Pemesanan::where('user_id', $userId)
            ->where('status', 'pending')
            ->with('orderDetail')
            ->first();

        if (!$pemesanan) {
            return back()->with('error', 'Keranjang kosong!');
        }

        // Hitung total harga sebelum ke ringkasan
        $this->hitungTotal($pemesanan);

        return redirect()->route('user.ringkasan', $pemesanan->id);
    }


        public function batalkan($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        // hapus detail pesanan dulu
        $pemesanan->orderDetail()->delete();

        // hapus pesanan utama
        $pemesanan->delete();

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

}
