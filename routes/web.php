<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\UserReservasiController;
use App\Http\Middleware\IsAdmin;
use App\Models\Menu;
use App\Models\Pemesanan;


// Route::get('/', function () {
//     return view('home');
// })->name('home');

Route::get('/', [MenuController::class, 'home'])->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');

Route::get('/menus', function () {
    $menus = Menu::where('available', true)->get();
    return view('menus', compact('menus'));
})->name('menuss');

Route::post('/signup', [UserController::class, 'register'])->name('signup.register');
Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');


Route::prefix('/user')->name('user.')->group(function() {
    // Dashboard User
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

    Route::post('/pesanan/tambah/{menu_id}', [PemesananController::class, 'tambahPesanan'])->name('pesanan.tambah');
    Route::get('/keranjang', [OrderDetailController::class, 'keranjang'])->name('keranjang');
    Route::post('/checkout', [OrderDetailController::class, 'checkout'])->name('checkout');
    Route::delete('/pesanan/batalkan/{id}', [OrderDetailController::class, 'batalkan'])->name('pesanan.batalkan');
    Route::get('/ringkasan/{id}', [PemesananController::class, 'ringkasan'])->name('ringkasan');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/pembayaran/{id}', [PembayaranController::class, 'paymentPage'])->name('payment');
    Route::patch('/pembayaran/{id}/update', [PembayaranController::class, 'paymentUpdate'])->name('payment.update');
    Route::get('/payment/success/{id}', [PembayaranController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/histori', [PemesananController::class, 'histori'])->name('histori');
    Route::delete('/histori/{id}', [PemesananController::class, 'hapusHistori'])->name('histori.hapus');
    Route::get('/histori/{id}/pdf', [PemesananController::class, 'downloadPDF'])->name('histori.pdf');
    Route::post('/reservasi/store', [UserReservasiController::class, 'store'])->name('reservasi.store');
    Route::get('/historireservasi', [UserReservasiController::class, 'histori'])->name('historireservasi');
    Route::get('/reservasi', [UserReservasiController::class, 'index'])->name('reservasi');










});


Route::middleware(IsAdmin::class)
    ->prefix('/admin')
    ->name('admin.')
    ->group(function () {



        // Dashboard Admin
        Route::get('/dashboard', function () {
            $menus = Menu::all();
            $pemesanans = Pemesanan::with(['user', 'orderDetail.menu'])->get();
            return view('admin.dashboard', compact('menus', 'pemesanans'));
        })->name('dashboard');

        Route::get('/chart', [PemesananController::class, 'chart'])->name('chart');

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('destroy');
            Route::get('/trash', [UserController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [UserController::class, 'restore'])->name('restore');
            Route::delete('/delete-permanent/{id}', [UserController::class, 'deletePermanent'])->name('deletePermanent');
            Route::get('/export', [UserController::class, 'exportExcel'])->name('export');
        });

        Route::prefix('reservasis')->name('reservasis.')->group(function () {
            Route::get('/', [UserController::class, 'adminReservasiIndex'])->name('index');
            Route::delete('/{index}', [UserController::class, 'deleteReservasi'])->name('delete');
        });


        Route::prefix('/menus')->name('menus.')->group(function () {
            Route::get('/', [MenuController::class, 'index'])->name('index');
            Route::get('/create', [MenuController::class, 'create'])->name('create');
            Route::post('/store', [MenuController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [MenuController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [MenuController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [MenuController::class, 'destroy'])->name('destroy');
            Route::get('/trash', [MenuController::class, 'trash'])->name('trash');
            Route::patch('/restore/{id}', [MenuController::class, 'restore'])->name('restore');
            Route::delete('/delete-permanent/{id}', [MenuController::class, 'deletePermanent'])->name('deletePermanent');
            Route::get('/export', [MenuController::class, 'exportExcel'])->name('export');
            Route::patch('/deactivate/{id}', [MenuController::class, 'deactivate'])->name('deactivate');
            Route::patch('/activate/{id}', [MenuController::class, 'activate'])->name('activate');
        });

        Route::prefix('pemesanans')->name('pemesanans.')->group(function () {
            Route::get('/', [PemesananController::class, 'index'])->name('index');
            Route::delete('/delete/{id}', [PemesananController::class, 'destroy'])->name('destroy');
        });
    });
