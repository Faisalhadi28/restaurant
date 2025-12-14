@extends('templates.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 75vh;">
        <div class="card shadow rounded-4 text-center p-5" style="max-width: 480px;">

            {{-- CEKLIST HIJAU --}}
            <div class="d-flex justify-content-center mb-4">
                <div class="bg-success rounded-circle d-flex justify-content-center align-items-center shadow"
                    style="width: 110px; height: 110px; animation: pop .4s ease;">
                    <i class="bi bi-check-lg text-white" style="font-size: 55px;"></i>
                </div>
            </div>

            <h3 class="fw-bold mb-2">Pembayaran Berhasil</h3>
            <p class="text-secondary mb-4">
                Terima kasih! Pembayaran Anda untuk pesanan #{{ $pemesanan->id }} telah berhasil diproses.
            </p>

            {{-- BUTTON --}}
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4 rounded-3">
                    Kembali
                </a>

                <a href="{{ route('user.histori') }}" class="btn btn-primary px-4 py-2 rounded-3">
                    Lihat Histori
                </a>

            </div>

        </div>
    </div>

    <style>
        @keyframes pop {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
@endsection
