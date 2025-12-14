@extends('templates.app')

@section('content')
    <div class="container my-5">

        <h2 class="mb-4">Histori Pembayaran</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        @if ($pemesanans->isEmpty())
            <div class="alert alert-info">
                Kamu belum memiliki histori pesanan.
            </div>
        @else
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    @foreach ($pemesanans as $pesanan)
                        <div class="border-bottom pb-3 mb-3">

                            <div class="d-flex justify-content-between">
                                <h5 class="fw-bold">Pesanan #{{ $pesanan->id }}</h5>
                                <span class="text-muted">
                                    {{ $pesanan->tanggal_pesanan ? $pesanan->tanggal_pesanan->format('d M Y, H:i') : '-' }}
                                </span>
                            </div>

                            <ul class="mt-2">
                                @foreach ($pesanan->orderDetail as $detail)
                                    <li>
                                        {{ $detail->menu->name }}
                                        ({{ $detail->jumlah }}x)
                                        —
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </li>
                                @endforeach
                            </ul>

                            <div class="d-flex justify-content-between mt-2">
                                <strong>Total: Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong>

                                <a href="{{ route('user.histori.pdf', $pesanan->id) }}" class="btn btn-primary btn-sm">
                                    Download PDF
                                </a>

                                <!-- Tombol HAPUS per histori -->
                                <form action="{{ route('user.histori.hapus', $pesanan->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin mau hapus histori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endsection
