@extends('templates.app')
@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Detail Pesanan</h5>
                    </div>

                    <div class="card-body">
                        @if (!$pemesanan)
                            <div class="alert alert-info">
                                Keranjang Anda kosong. Silakan tambahkan menu terlebih dahulu.
                            </div>
                        @else
                            {{-- INFORMASI PESANAN (TANGGAL) --}}
                            <div class="card p-3 mb-3">
                                <h5>Informasi Pesanan</h5>
                                <p>
                                    <b>Tanggal:</b>
                                    {{ $pemesanan->tanggal_pesanan->timezone('Asia/Jakarta')->format('d M Y H:i:s') }}
                                </p>
                            </div>

                            @foreach ($pemesanan->orderDetail as $detail)
                                <div class="d-flex justify-content-between align-items-center py-3 border-bottom">

                                    <div>
                                        <h6 class="fw-bold mb-1">{{ $detail->menu->name }}</h6>
                                        <small class="text-muted">
                                            {{ $detail->jumlah }} x Rp
                                            {{ number_format($detail->menu->price, 0, ',', '.') }}
                                        </small>
                                    </div>

                                    <div class="text-end">
                                        <span class="fw-bold text-success">
                                            Rp {{ number_format($detail->jumlah * $detail->menu->price, 0, ',', '.') }}
                                        </span>
                                    </div>

                                </div>
                            @endforeach
                            <div class="d-flex justify-content-between mt-3">

                                {{-- Tombol Batalkan --}}
                                <form action="{{ route('user.pesanan.batalkan', $pemesanan->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin membatalkan pesanan?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        Batalkan Pesanan
                                    </button>
                                </form>

                                {{-- Tombol Bayar --}}
                                <form action="{{ route('user.checkout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">
                                        Bayar Sekarang
                                    </button>
                                </form>

                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
