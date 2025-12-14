<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    /**
     * Proses pembayaran user
     */
    public function bayar(Request $request)
    {
        $pemesanan = Pemesanan::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        $pembayaran = Pembayaran::create([
            'pemesanan_id' => $pemesanan->id,
            'metode' => $request->metode,
            'jumlah' => $pemesanan->total_harga,
            'status' => 'paid',
            'tanggal_pembayaran' => now(),
        ]);

        $pemesanan->update([
            'status' => 'completed'
        ]);

        return redirect()->route('home')->with('success', 'Pembayaran Berhasil!');
    }

    /**
     * Tampilkan halaman pembayaran + generate QR code otomatis
     */
    public function paymentPage($id)
    {
        $pemesanan = Pemesanan::with(['orderDetail.menu'])->findOrFail($id);

        // Generate QR code jika belum ada
        if (!$pemesanan->qrcode) {

            // Folder di storage/app/public/qrcode
            $folderPath = storage_path('app/public/qrcode');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true);
            }

            $fileName = 'qrcode-' . $pemesanan->id . '.svg';
            $filePath = $folderPath . '/' . $fileName;

            QrCode::format('svg')
            ->size(300)
            ->margin(1)
            ->generate(route('user.payment', $pemesanan->id), $filePath);


            // Simpan ke DB (harus relative, TANPA "storage/")
            $pemesanan->qrcode = 'qrcode/' . $fileName;
            $pemesanan->save();
        }


        $qr = $pemesanan->qrcode;

        return view('payment', compact('pemesanan', 'qr'));
    }


    public function paymentSuccess($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        return view('payment_success', compact('pemesanan'));
    }

    /**
     * Update status pembayaran
     */
    public function paymentUpdate($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        $pemesanan->status = 'completed';
        $pemesanan->save();

        return redirect()->route('user.payment.success', $id);
    }
}
