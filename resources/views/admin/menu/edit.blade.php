@extends('templates.app')

@section('content')
<div class="container my-5">

    {{-- Breadcrumb --}}
    <nav class="navbar navbar-expand-lg bg-white rounded shadow-sm mb-4 border">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.menus.index') }}" class="text-decoration-none text-success">Menu</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Ubah Data Menu
                    </li>
                </ol>
            </nav>
        </div>
    </nav>

    {{-- Card Form --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <h4 class="fw-semibold text-center text-success mb-4">
                <i class="bi bi-pencil-square me-2"></i> Ubah Data Menu
            </h4>

            <form method="POST" action="{{ route('admin.menus.update', $menu->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Nama Menu --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nama Menu :</label>
                    <input type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        id="name"
                        name="name"
                        value="{{ old('name', $menu->name) }}"
                        placeholder="Masukkan nama menu...">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div class="mb-3">
                    <label for="category" class="form-label fw-semibold">Kategori :</label>
                    <input type="text"
                        class="form-control @error('category') is-invalid @enderror"
                        id="category"
                        name="category"
                        value="{{ old('category', $menu->category) }}"
                        placeholder="Masukkan kategori menu...">
                    @error('category')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Harga --}}
                <div class="mb-3">
                    <label for="price" class="form-label fw-semibold">Harga :</label>
                    <input type="number"
                        class="form-control @error('price') is-invalid @enderror"
                        id="price"
                        name="price"
                        value="{{ old('price', $menu->price) }}"
                        placeholder="Masukkan harga menu...">
                    @error('price')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Deskripsi :</label>
                    <textarea
                        class="form-control @error('description') is-invalid @enderror"
                        id="description"
                        name="description"
                        rows="3"
                        placeholder="Masukkan deskripsi menu...">{{ old('description', $menu->description) }}</textarea>
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Foto (opsional) --}}
                <div class="mb-3">
                    <label for="image" class="form-label fw-semibold">Foto Menu :</label>
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $menu->image) }}" width="120" class="rounded shadow-sm">
                    </div>
                    <input type="file"
                        class="form-control @error('image') is-invalid @enderror"
                        id="image"
                        name="image">
                    <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                    @error('image')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label for="available" class="form-label fw-semibold">Status Ketersediaan :</label>
                    <select name="available" id="available" class="form-control @error('available') is-invalid @enderror">
                        <option value="1" {{ old('available', $menu->available) == 1 ? 'selected' : '' }}>Tersedia</option>
                        <option value="0" {{ old('available', $menu->available) == 0 ? 'selected' : '' }}>Habis</option>
                    </select>
                    @error('available')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-check-circle"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Style --}}
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
