<?php

namespace App\Http\Controllers;

use App\Models\pemesanan;
use App\Models\Menu;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PemesananController extends Controller
{



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemesanans = Pemesanan::with(['user', 'orderDetail.menu'])
            ->orderBy('tanggal_pesanan', 'desc')
            ->get();

        return view('admin.pemesanan.index', compact('pemesanans'));
    }



    public function ringkasan($id)
    {
        // Ambil pesanan berdasarkan ID
        $pemesanan = Pemesanan::with('orderDetail.menu')->findOrFail($id);

        return view('ringkasan', compact('pemesanan'));
    }


    public function hitungTotal()
    {
        $total = $this->orderDetail->sum(function ($detail) {
            return $detail->jumlah * $detail->price;
        });

        // simpan hasil ke database
        $this->update(['total_harga' => $total]);

        return $total;
    }



    public function tambahPesanan(Request $request, $menu_id)
    {
     $user = auth()->user();

        // 1. Cek apakah user punya pesanan yang pending
        $pesanan = Pemesanan::where('user_id', $user->id)
                          ->where('status', 'pending')
                          ->first();

        // 2. Kalau belum ada, buat pesanan baru
        if (!$pesanan) {
            $pesanan = Pemesanan::create([
                'user_id' => $user->id,
                'tanggal_pesanan' => now(),
                'total_harga' => 0,
                'status' => 'pending'
            ]);
        }

        // 3. Ambil menu yang dipilih user
        $menu = Menu::findOrFail($menu_id);

        // 4. Cek apakah menu ini sudah ada di DETAIL
        $detail = OrderDetail::where('pemesanan_id', $pesanan->id)
                        ->where('menu_id', $menu_id)
                        ->first();

        if ($detail) {
            // Kalau sudah ada → update jumlah
            $detail->jumlah += 1;
            $detail->subtotal = $detail->jumlah * $menu->price;
            $detail->save();
        } else {
            // Kalau belum → buat detail baru
            OrderDetail::create([
                'pemesanan_id' => $pesanan->id,
                'menu_id' => $menu_id,
                'jumlah' => 1,
                'subtotal' => $menu->price * 1
            ]);
        }

        // 5. Update total harga pesanan
        $pesanan->total_harga = OrderDetail::where('pemesanan_id', $pesanan->id)->sum('subtotal');
        $pesanan->save();

        return back()->with('success', 'Menu berhasil ditambahkan! Silahkan Cek Di Halaman Pemesanan');   // Logika untuk menambahkan pesanan berdasarkan menu_id
    }

    public function histori()
    {
        $pemesanans = Pemesanan::with(['orderDetail.menu'])
            ->where('user_id', auth()->id())
            ->where('status', 'completed')
            ->orderBy('tanggal_pesanan', 'desc')
            ->get();

        return view('histori', compact('pemesanans'));
    }

    public function hapusHistori($id)
    {
        $pemesanan = Pemesanan::where('id', $id)
            ->where('user_id', auth()->id()) // memastikan hanya pemilik yang bisa hapus
            ->where('status', 'completed')   // hanya histori yang selesai boleh dihapus
            ->firstOrFail();

        // hapus detail dulu
        OrderDetail::where('pemesanan_id', $pemesanan->id)->delete();

        // hapus pesanan
        $pemesanan->delete();

        return back()->with('success', 'Histori berhasil dihapus!');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pemesanan = Pemesanan::create([
            'user_id' => auth()->id(),
            'status' => 'pending'
        ]);

        $total = 0;

        foreach ($request->menus as $menuId => $jumlah) {
            if ($jumlah > 0) {
                $menu = Menu::find($menuId);

                $subtotal = $menu->price * $jumlah;
                $total += $subtotal;

                OrderDetail::create([
                    'pemesanan_id' => $pemesanan->id,
                    'menu_id' => $menuId,
                    'jumlah' => $jumlah,
                    'subtotal' => $subtotal,
                ]);
            }
        }

        // UPDATE TOTAL KE DATABASE
        $pemesanan->update([
            'total_harga' => $total
        ]);

        return redirect()->route('pemesanan.show', $pemesanan->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(pemesanan $pemesanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pemesanan $pemesanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pemesanan $pemesanan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        // hapus order detail dulu
        OrderDetail::where('pemesanan_id', $pemesanan->id)->delete();

        // hapus pemesanan utama
        $pemesanan->delete();

        return back()->with('success', 'Pemesanan berhasil dihapus!');
    }

    public function downloadPDF($id)
    {
        $pemesanan = Pemesanan::with('orderDetail.menu')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        $pdf = Pdf::loadView('export_pdf', compact('pemesanan'))
                ->setPaper('A4', 'portrait');

        return $pdf->download("pesanan-{$pemesanan->id}.pdf");
    }


    public function chart()
    {
        // ================================
        // 1. PENJUALAN 7 HARI TERAKHIR
        // ================================
        $penjualan = \DB::table('pemesanan')
        ->selectRaw('DATE(tanggal_pesanan) as tanggal, SUM(total_harga) as total')
        ->whereNotNull('tanggal_pesanan')
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'DESC')
        ->limit(7)
        ->get()
        ->reverse();


        $penjualan_labels = $penjualan->pluck('tanggal');
        $penjualan_data   = $penjualan->pluck('total');

        // ================================
        // 2. MENU TERLARIS
        // ================================
        $menu = \DB::table('details')
        ->join('menus', 'menus.id', '=', 'details.menu_id')
        ->selectRaw('menus.name as nama_menu, SUM(details.jumlah) as total')
        ->groupBy('menus.name')
        ->orderBy('total', 'DESC')
        ->limit(5)
        ->get();



        $menu_labels = $menu->pluck('nama_menu');
        $menu_data   = $menu->pluck('total');

        return response()->json([
            'penjualan' => [
                'labels' => $penjualan_labels,
                'data'   => $penjualan_data
            ],
            'menu' => [
                'labels' => $menu_labels,
                'data'   => $menu_data
            ],
        ]);
    }




}
