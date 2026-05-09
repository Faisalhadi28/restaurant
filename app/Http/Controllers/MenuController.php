<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MenuExport;



class MenuController extends Controller
{
    /**
     * Tampilkan semua menu (admin)
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $menus = Menu::when($search, function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
            ->orWhere('category', 'like', "%$search%");
        })
        ->orderBy('id', 'DESC')
        ->get();   // <-- TAMBAH INI

        return view('admin.menu.index', compact('menus', 'search'));
    }



    /**
     * Form tambah menu
     */
    public function create()
    {
        return view('admin.menu.create');
    }

    public function deactivate($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->available = 0; // Set jadi habis
        $menu->save();

        return redirect()->back()->with('success', 'Menu telah diubah menjadi Habis.');
    }

    public function activate($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->available = 1; // Set jadi tersedia
        $menu->save();

        return redirect()->back()->with('success', 'Menu telah diubah menjadi Tersedia.');
    }


    /**
     * Simpan menu baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|in:Makanan,Minuman',
            'price'       => 'required|numeric',
            'description' => 'nullable|string|min:5',
            'image'       => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'available'   => 'required|boolean',
        ], [
            'name.required' => 'Nama menu wajib diisi.',
            'category.required' => 'Kategori wajib dipilih.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'image.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'available.required' => 'Status ketersediaan wajib dipilih.',
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $namaFile = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('menus', $namaFile, 'public');
        }

        $create = Menu::create([
            'name'        => $request->name,
            'category'    => $request->category,
            'price'       => $request->price,
            'description' => $request->description,
            'image'       => $path ?? null,
            'available'   => $request->available,
        ]);

        if ($create) {
            return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil ditambahkan!');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan menu!');
        }
    }

    /**
     * Form edit menu
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menu.edit', compact('menu'));
    }

    /**
     * Update data menu
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|in:Makanan,Minuman',
            'price'       => 'required|numeric',
            'description' => 'nullable|string|min:5',
            'image'       => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'available'   => 'required|boolean',
        ]);

        $menu = Menu::findOrFail($id);

        // Jika upload gambar baru
        if ($request->file('image')) {
            $oldImage = storage_path('app/public/' . $menu->image);
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }

            $file = $request->file('image');
            $namaFile = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('menus', $namaFile, 'public');
        }

        $update = $menu->update([
            'name'        => $request->name,
            'category'    => $request->category,
            'price'       => $request->price,
            'description' => $request->description,
            'image'       => $path ?? $menu->image,
            'available'   => $request->available,
        ]);

        if ($update) {
            return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil diperbarui!');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui menu!');
        }
    }

    public function home()
    {
        $menus = Menu::where('available', 1 )->limit(2)->get();
        return view('home', compact('menus'));
    }

    /**
     * Hapus menu (soft delete)
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil dihapus!');
    }

    /**
     * Tampilkan menu yang sudah dihapus
     */
    public function trash()
    {
        $menuTrash = Menu::onlyTrashed()->get();
        return view('admin.menu.trash', compact('menuTrash'));
    }

    /**
     * Restore menu yang dihapus
     */
    public function restore($id)
    {
        $menu = Menu::onlyTrashed()->findOrFail($id);
        $menu->restore();

        return redirect()->route('admin.menus.trash')->with('success', 'Menu berhasil dikembalikan!');
    }

    /**
     * Hapus permanen menu
     */
    public function deletePermanent($id)
    {
        $menu = Menu::onlyTrashed()->findOrFail($id);

        if  ($menu->image) {
            $path = storage_path('app/public/' . $menu->image);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $menu->forceDelete();
        return redirect()->back()->with('success', 'Menu berhasil dihapus secara permanen!');
    }

    /**
     * Export ke Excel
     */
    public function exportExcel()
    {
        $fileName = 'data-menu.xlsx';
        return Excel::download(new MenuExport, $fileName);
    }
}
