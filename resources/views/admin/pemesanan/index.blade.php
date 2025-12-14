@extends('templates.app')

@section('content')
<div class="container my-4">

    <h2 class="mb-4">Daftar Pemesanan</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            @foreach($pemesanans as $p)
                <div class="border-bottom pb-3 mb-3">

                    <div class="d-flex justify-content-between">
                        <h5 class="fw-bold">Pesanan #{{ $p->id }}</h5>
                        <span class="text-muted">
                            {{ $p->tanggal_pesanan ? $p->tanggal_pesanan->format('d M Y, H:i') : '-' }}
                        </span>
                    </div>

                    <p><strong>Nama Pembeli:</strong> {{ $p->user->name }}</p>

                    <ul class="mt-2">
                        @foreach($p->orderDetail as $d)
                            <li>
                                {{ $d->menu->name }} ({{ $d->jumlah }}x)
                                — Rp {{ number_format($d->subtotal, 0, ',', '.') }}
                            </li>
                        @endforeach
                    </ul>

                    <div class="d-flex justify-content-between mt-2">
                        <strong>Total: Rp {{ number_format($p->total_harga, 0, ',', '.') }}</strong>

                        <form action="{{ route('admin.pemesanans.destroy', $p->id) }}"
                              method="POST"
                              onsubmit="return confirm('Hapus pemesanan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>

                </div>
            @endforeach

        </div>
    </div>
</div>
@endsection
