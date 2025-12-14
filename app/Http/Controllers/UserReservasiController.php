<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservasi;

class UserReservasiController extends Controller
{
    public function index()
    {
        return view('reservasi'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'jumlah_orang' => 'required|integer|min:1',
            'catatan' => 'nullable',
        ]);

        Reservasi::create([
            'user_id'       => Auth::id(),
            'tanggal'       => $request->tanggal,
            'jam'           => $request->jam,
            'jumlah_orang'  => $request->jumlah_orang,
            'catatan'       => $request->catatan,
        ]);

        return back()->with('success', 'Reservasi berhasil dikirim!');
    }
}
