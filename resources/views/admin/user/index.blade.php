@extends('templates.app')

@section('content')
<div class="container my-5">

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

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold mb-0 text-success">Data Pengguna (Admin & User)</h4>
        <div>
            <a href="{{route('admin.users.export')}}" class="btn btn-outline-success me-2">
                <i class="bi bi-file-earmark-excel"></i> Export (.XLSX)
            </a>
            <a href="{{route ('admin.users.trash')}}" class="btn btn-outline-warning me-2">
                <i class="bi bi-trash"></i> Data Sampah
            </a>
            <a href="{{route('admin.users.create')}}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Tambah Data
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
                    @forelse ($users as $index => $item)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td class="fw-semibold">{{ $item->name }}</td>
                            <td class="text-muted">{{ $item->email }}</td>
                            <td>
                                @if($item->role == 'admin')
                                    <span class="badge bg-primary-subtle text-primary px-3 py-2">Admin</span>
                                @elseif($item->role == 'staff')
                                    <span class="badge bg-success-subtle text-success px-3 py-2">Staff</span>
                                @else
                                    <span class="badge bg-secondary px-3 py-2">{{ ucfirst($item->role) }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('admin.users.edit', $item->id)}}"
                                   class="btn btn-outline-info btn-sm me-2">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('admin.users.destroy', $item->id) }}" 
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Yakin hapus {{ $item->name }}?')"
                                            class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-muted">
                                Belum ada data pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection
