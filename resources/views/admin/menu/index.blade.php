@extends('templates.app')

@section('content')
<div class="container my-5">

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success shadow-sm rounded-3">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger shadow-sm rounded-3">
            {{ session('error') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-semibold mb-0 text-success">Data Menu</h4>
        <div>
            <a href="{{ route('admin.menus.export') }}" class="btn btn-outline-success me-2">
                <i class="bi bi-file-earmark-excel"></i> Export (.XLSX)
            </a>
            <a href="{{ route('admin.menus.trash') }}" class="btn btn-outline-warning me-2">
                <i class="bi bi-trash"></i> Data Sampah
            </a>
            <a href="{{ route('admin.menus.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Tambah Menu
            </a>
        </div>
    </div>

    {{-- Search --}}
    <form action="{{ route('admin.menus.index') }}" method="GET" class="d-flex mb-3" style="max-width: 1500px;">
        <input type="text" name="search" value="{{ $search }}" class="form-control me-2"
            placeholder="Cari menu...">
        <button class="btn btn-success">Cari</button>
    </form>

    {{-- Tabel --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-success text-center">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-center">
                    @forelse ($menus as $index => $menu)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $menu->image) }}" width="90"
                                    class="rounded shadow-sm">
                            </td>
                            <td class="fw-semibold">{{ $menu->name }}</td>
                            <td>{{ $menu->category }}</td>
                            <td>Rp{{ number_format($menu->price, 0, ',', '.') }}</td>
                            <td>
                                @if ($menu->available)
                                    <span class="badge bg-success-subtle text-success px-3 py-2">Tersedia</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2">Habis</span>
                                @endif
                            </td>

                            <td>

                                {{-- Detail --}}
                                <button class="btn btn-outline-secondary btn-sm me-1"
                                    onclick="showMenuModal({{ $menu }})">
                                    <i class="bi bi-eye"></i> Detail
                                </button>

                                {{-- Edit --}}
                                <a href="{{ route('admin.menus.edit', $menu->id) }}"
                                    class="btn btn-outline-info btn-sm me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin hapus {{ $menu->name }}?')"
                                        class="btn btn-outline-danger btn-sm me-1">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>

                                {{-- Toggle Status --}}
                                @if ($menu->available)
                                    <form action="{{ route('admin.menus.deactivate', $menu->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-warning btn-sm">
                                            <i class="bi bi-slash-circle"></i> Habis
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.menus.activate', $menu->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-success btn-sm">
                                            <i class="bi bi-check-circle"></i> Tersedia
                                        </button>
                                    </form>
                                @endif

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="py-4 text-muted">Data tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>

{{-- Modal Detail --}}
<div class="modal fade" id="menuModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Menu</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="menuModalBody"></div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    function showMenuModal(menu) {
        let image = "{{ asset('storage/') }}/" + menu.image;

        let content = `
            <img src="${image}" width="200" class="d-block mx-auto rounded my-3 shadow-sm">
            <ul class="list-unstyled text-start">
                <li><strong>Nama Menu:</strong> ${menu.name}</li>
                <li><strong>Kategori:</strong> ${menu.category}</li>
                <li><strong>Harga:</strong> Rp${menu.price.toLocaleString('id-ID')}</li>
                <li><strong>Status:</strong> ${menu.available == 1
                    ? '<span class="badge bg-success">Tersedia</span>'
                    : '<span class="badge bg-danger">Habis</span>'}</li>
                <li><strong>Deskripsi:</strong> ${menu.description ?? '-'}</li>
            </ul>
        `;
        document.querySelector("#menuModalBody").innerHTML = content;
        new bootstrap.Modal(document.querySelector("#menuModal")).show();
    }
</script>
@endpush
