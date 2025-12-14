<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
// class laravel untuk memanipulasi date time
use Carbon\Carbon;

class UserExport implements FromCollection, Withheadings, WithMapping
{
    // membuat property untuk mengurutkan data
    private $key = 0;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //  memanggil data yg di munculkan di excel
        return User::all();
    }

    // menentukan header data (th)
    public function headings(): array
    {
        return ['No', 'Nama', 'Email','role', 'Tanggal Bergabung'];
    }

    // menentukan isi data (td)
    public function map($user): array
    {
        return [
            ++$this->key+0,
            $user->name,
            $user->email,
            $user->role,
            Carbon::parse($user->created_at)->Format('d-m-Y'),
        ];
    }
}
