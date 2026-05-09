@extends('templates.app')

@section('content')
    <div class="container mt-4">

        <h3 class="mb-4">Data Reservasi Masuk</h3>

        <div class="card shadow">
            <div class="card-body">

                @if (count($reservasis) == 0)
                    <div class="alert alert-warning text-center">
                        Belum ada reservasi.
                    </div>
                @else
                    <table class="table table-bordered">
                        <thead class="table-success">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Jumlah</th>
                                <th>Catatan</th>
                                <th>Waktu Kirim</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservasis as $index => $r)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $r->user->name }}</td>
                                    <td>{{ $r->tanggal }}</td>
                                    <td>{{ $r->jam }}</td>
                                    <td>{{ $r->jumlah_orang }}</td>
                                    <td>{{ $r->catatan ?? '-' }}</td>
                                    <td>{{ $r->created_at->format('d-m-Y H:i') }}</td>

                                    <td>
                                        <form action="{{ route('admin.reservasis.delete', $r->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>
@endsection
