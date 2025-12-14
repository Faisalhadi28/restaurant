@extends('templates.app')

@section('content')
    <div class="container my-5">
        <div class="card p-4 shadow">
            <h4 class="text-center mb-4">RINGKASAN PEMESANAN</h4>

            {{-- Informasi Pesanan --}}
            <div class="mb-3">
                <b>Tanggal Pesanan:</b>
                {{ $pemesanan->tanggal_pesanan->timezone('Asia/Jakarta')->format('d M Y H:i:s') }}
            </div>

            {{-- Detail Pesanan --}}
            <h5 class="mb-3">Detail Pesanan</h5>
            @foreach ($pemesanan->orderDetail as $detail)
                <div class="d-flex justify-content-between border-bottom py-2">
                    <div>
                        <b>{{ $detail->menu->name }}</b><br>
                        <small>{{ $detail->jumlah }} x Rp {{ number_format($detail->menu->price, 0, ',', '.') }}</small>
                    </div>
                    <div>
                        <b class="text-success">
                            Rp {{ number_format($detail->jumlah * $detail->menu->price, 0, ',', '.') }}
                        </b>
                    </div>
                </div>
            @endforeach

            <hr>

            {{-- Total --}}
            <h5 class="text-end">
                Total:
                <span class="text-primary">
                    Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}
                </span>
            </h5>

            {{-- <div class="text-center mt-4">
            <a href="#" class="btn btn-success px-4">Konfirmasi Pembayaran</a>
        </div> --}}

            <div class="d-flex justify-content-between mt-3">

                {{-- Tombol Kembali ke Pesanan --}}
                <a href="{{ route('user.keranjang') }}" class="btn btn-danger">
                    Kembali ke Pesanan
                </a>

                {{-- Tombol Konfirmasi Pembayaran --}}
                <form action="{{ route('user.payment', $pemesanan->id) }}" method="GET">
                    <button type="submit" class="btn btn-primary">
                        Konfirmasi Pembayaran
                    </button>
                </form>

            </div>


        </div>
    </div>
@endsection
