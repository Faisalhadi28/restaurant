@extends('templates.app')

@section('content')
    <div class="container my-5">
        <div class="card shadow p-4">
            <h4 class="mb-3">Profil Saya</h4>

            {{-- Alert sukses --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Form Update Profil --}}
            <form action="{{ route('user.profile.update') }}" method="POST">
                @csrf

                {{-- Nama --}}
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="username"
                           value="{{ Auth::user()->name }}"
                           class="form-control" required>
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control"
                           value="{{ Auth::user()->email }}" readonly>
                </div>

                <hr class="my-4">

                <h5 class="fw-bold mb-3">Ubah Password</h5>

                <div class="mb-3">
                    <label class="form-label">Password Baru (Opsional)</label>
                    <input type="password" name="password" class="form-control"
                           placeholder="Isi jika ingin mengganti password">
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('home') }}" class="btn btn-danger">Kembali</a>
                    <button class="btn btn-success w-20">Simpan Perubahan</button>
                </div>

            </form>
        </div>
    </div>
@endsection
