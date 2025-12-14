<?php

namespace App\Exports;

use App\Models\Menu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class MenuExport implements FromCollection, WithHeadings, WithMapping
{
    private $key = 0;

    /**
     * Ambil data yang akan diekspor
     */
    public function collection()
    {
        return Menu::all();
    }

    /**
     * Header kolom Excel
     */
    public function headings(): array
    {
        return ['No', 'Nama Menu', 'Kategori', 'Harga', 'Status', 'Foto', 'Dibuat Pada'];
    }

    /**
     * Mapping data setiap baris
     */
    public function map($menu): array
    {
        return [
            ++$this->key,
            $menu->name,
            $menu->category,
            'Rp' . number_format($menu->price, 0, ',', '.'),
            $menu->available ? 'Tersedia' : 'Habis',
            asset('storage/' . $menu->image),
            Carbon::parse($menu->created_at)->translatedFormat('d F Y '),
        ];
    }
}
