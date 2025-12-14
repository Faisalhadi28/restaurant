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
            <i class="bi bi-trash"></i> Data Sampah Pengguna
        </h4>
        <div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-success">
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
                        <th style="width:25%">Nama</th>
                        <th style="width:25%">Email</th>
                        <th style="width:15%">Role</th>
                        <th style="width:30%">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($userTrash as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $user->name }}</td>
                            <td class="text-muted">{{ $user->email }}</td>
                            <td>
                                @if($user->role == 'admin')
                                    <span class="badge bg-primary-subtle text-primary px-3 py-2">Admin</span>
                                @elseif($user->role == 'staff')
                                    <span class="badge bg-success-subtle text-success px-3 py-2">Staff</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.users.restore', $user->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-success btn-sm me-2">
                                        <i class="bi bi-arrow-clockwise"></i> Kembalikan
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.deletePermanent', $user->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Yakin hapus permanen {{ $user->name }}?')"
                                            class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-x-circle"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-muted">
                                Tidak ada data pengguna di tempat sampah.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Style menyesuaikan tampilan index --}}
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
