@extends('templates.app')

@section('content')
<div class="container my-5">

    {{-- Breadcrumb --}}
    <nav class="navbar navbar-expand-lg bg-white rounded shadow-sm mb-4 border">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.users.index') }}" class="text-decoration-none text-success">Pengguna</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Tambah Data
                    </li>
                </ol>
            </nav>
        </div>
    </nav>

    {{-- Card Form --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <h4 class="fw-semibold text-center text-success mb-4">Tambah Data Pengguna</h4>

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                {{-- Nama --}}
                <div class="mb-3">
                    <label for="first_name" class="form-label fw-semibold">Nama Lengkap:</label>
                    <input type="text"
                           class="form-control @error('first_name') is-invalid @enderror"
                           id="first_name"
                           name="first_name"
                           value="{{ old('first_name') }}"
                           placeholder="Masukkan nama lengkap...">
                    @error('first_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="Masukkan email aktif...">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           id="password"
                           name="password"
                           placeholder="Masukkan password...">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label fw-semibold">Role :</label>
                    <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                        <option value="">-- Pilih Role --</option>
                        <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Admin</option>
                        <option value="staff" {{ old('role')=='staff' ? 'selected' : '' }}>Staff</option>
                    </select>
                    @error('role')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-check-circle"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f9fcfa;
        font-family: 'Poppins', sans-serif;
    }
    .card {
        border-radius: 16px;
    }
    .btn {
        border-radius: 10px;
        font-weight: 500;
    }
    .breadcrumb-item a {
        color: #198754;
    }
    .breadcrumb-item.active {
        color: #6c757d;
    }
</style>
@endsection
