@extends('templates.app')

@section('content')
<div class="container my-5">

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded-3">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger shadow-sm rounded-3">
            {{ session('error') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold mb-0 text-success">
            <i class="bi bi-trash"></i> Data Sampah Menu
        </h4>
        <div>
            <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-success">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-success text-center">
                    <tr>
                        <th style="width:5%">No</th>
                        <th style="width:15%">Foto</th>
                        <th style="width:25%">Nama Menu</th>
                        <th style="width:15%">Kategori</th>
                        <th style="width:15%">Harga</th>
                        <th style="width:10%">Status</th>
                        <th style="width:15%">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($menuTrash as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if($item->image)
                                    <img src="{{ asset('storage/'.$item->image) }}" 
                                         width="80" class="rounded shadow-sm">
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>
                            <td class="fw-semibold">{{ $item->name }}</td>
                            <td>{{ $item->category }}</td>
                            <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>
                                @if($item->available)
                                    <span class="badge bg-success-subtle text-success px-3 py-2">Tersedia</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2">Habis</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Tombol Restore --}}
                                    <form action="{{ route('admin.menus.restore', $item->id) }}" 
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-success btn-sm">
                                            <i class="bi bi-arrow-clockwise"></i> Kembalikan
                                        </button>
                                    </form>

                                    {{-- Tombol Hapus Permanen --}}
                                    <form action="{{ route('admin.menus.deletePermanent', $item->id) }}" 
                                        method="POST"
                                        onsubmit="return confirm('Yakin hapus permanen {{ $item->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-x-circle"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 text-muted">
                                Tidak ada data menu di tempat sampah.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Style --}}
<style>
    body {
        background-color: #f9fcfa;
        font-family: 'Poppins', sans-serif;
    }
    .table thead {
        background-color: #198754 !important;
        color: #fff;
    }
    .btn {
        border-radius: 10px;
        font-weight: 500;
    }
    .card {
        border-radius: 16px;
    }
    .table-hover tbody tr:hover {
        background-color: #f4fdf8;
    }
    .alert-success {
        background-color: #e8fff1;
        color: #157347;
    }
    .alert-danger {
        background-color: #ffeaea;
        color: #b02a37;
    }
</style>
@endsection
