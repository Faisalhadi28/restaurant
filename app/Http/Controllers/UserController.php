<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use App\Models\Menu;
use App\Models\Reservasi;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|min:3',
            'last_name'  => 'required|min:3',
            'email'      => 'required|email:dns',
            'password'   => 'required'
        ]);

        $createData = User::create([
            'name'     => $request->first_name . " " . $request->last_name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user'
        ]);

        if ($createData) {
            return redirect()->route('login')->with('success', 'Berhasil membuat akun, silahkan login');
        } else {
            return redirect()->back()->with('error', 'Gagal! silahkan coba lagi');
        }
    }


    public function loginAuth(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $data = $request->only('email', 'password');

        if (Auth::attempt($data)) {

            $name = Auth::user()->name;

            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('success', "Berhasil Login! Selamat Datang, $name");
            }

            return redirect()->route('home')
                ->with('success', "Berhasil Login! Selamat Datang, $name");
        }

        return back()->with('failed', 'Email atau Password salah!');
    }



    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('logout', 'Anda sudah logout! Silakan login kembali untuk akses lengkap');
    }


    public function adminReservasiIndex()
    {
        $reservasis = Reservasi::with('user')
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->get();

        return view('admin.reservasi.index', compact('reservasis'));
    }

    public function deleteReservasi($id)
    {
        Reservasi::findOrFail($id)->delete();
        return back()->with('success', 'Reservasi berhasil dihapus!');
    }



    public function profile()
    {
        return view('profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'username' => 'required|min:3',
            'password' => 'nullable|min:5'
        ]);

        $user = Auth::user();
        $user->name = $request->username;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }


    public function index()
    {
        $users = User::whereIn('role', ['admin', 'user'])->get();
        return view('admin.user.index', compact('users'));
    }


    public function pemesanan()
    {
        $pemesanans = Pemesanan::with(['user', 'orderDetail.menu'])->get();
        return view('admin.pemesanan.index', compact('pemesanans'));
    }


    public function create()
    {
        return view('admin.user.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|min:3',
            'email'      => 'required|email:dns|unique:users,email',
            'password'   => 'required|min:6',
            'role'       => 'required|in:admin,user'
        ]);

        $createData = User::create([
            'name'     => $request->first_name . " " . $request->last_name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role
        ]);

        if ($createData) {
            return redirect()->route('admin.users.index')->with('success', 'Berhasil menambah data user');
        } else {
            return redirect()->back()->with('error', 'Gagal! silahkan coba lagi');
        }
    }

    public function edit(string $id)
    {
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_name' => 'required|string|min:3',
            'email'      => 'required|email:dns|unique:users,email,' . $id,
            'role'       => 'required|in:admin,user'
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->first_name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->password) {
            $request->validate(['password' => 'nullable|min:6']);
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return redirect()->route('admin.users.index')->with('success', 'Berhasil update data user');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Berhasil menghapus Data User');
    }

    public function trash()
    {
        $userTrash = User::onlyTrashed()->get();
        return view('admin.user.trash', compact('userTrash'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->find($id);
        if ($user) {
            $user->restore();
            return redirect()->route('admin.users.index')->with('success', 'Berhasil mengembalikan data!');
        } else {
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }
    }

    public function deletePermanent($id)
    {
        $user = User::onlyTrashed()->find($id);
        if ($user) {
            $user->forceDelete();
            return redirect()->back()->with('success', 'Berhasil menghapus data secara permanen!');
        } else {
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }
    }

    public function exportExcel()
    {
        $fileName = 'data-petugas.xlsx';
        return Excel::download(new UserExport, $fileName);
    }
}
