@extends('templates.app')

@section('content')
    <div class="container my-5">

        <h2 class="mb-4">Histori Reservasi</h2>

        @if ($reservasis->isEmpty())
            <div class="alert alert-info">
                Kamu belum memiliki histori reservasi.
            </div>
        @else
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    @foreach ($reservasis as $reservasi)
                        @php
                            $waktuReservasi = \Carbon\Carbon::createFromFormat(
                                'Y-m-d H:i:s',
                                $reservasi->tanggal . ' ' . $reservasi->jam,
                                'Asia/Jakarta',
                            );

                            $sekarang = \Carbon\Carbon::now('Asia/Jakarta');

                            $expired = $waktuReservasi->isSameDay($sekarang) && $waktuReservasi->lt($sekarang);
                        @endphp


                        <div
                            class="border-bottom pb-3 mb-3
                        {{ $expired ? 'bg-danger-subtle p-3 rounded' : '' }}">

                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold mb-0">
                                    Reservasi #{{ $reservasi->id }}
                                </h5>

                                <span class="{{ $expired ? 'text-danger fw-bold' : 'text-muted' }}">
                                    {{ $waktuReservasi->format('d M Y, H:i') }}
                                </span>
                            </div>

                            <div class="mt-3">
                                <p class="mb-1">
                                    <strong>Jumlah Orang:</strong>
                                    {{ $reservasi->jumlah_orang }}
                                </p>

                                <p class="mb-1">
                                    <strong>Catatan:</strong>
                                    {{ $reservasi->catatan ?? '-' }}
                                </p>

                                @if ($expired)
                                    <span class="badge bg-danger mt-2">Expired</span>
                                @else
                                    <span class="badge bg-success mt-2">Akan Datang</span>
                                @endif
                            </div>

                        </div>
                    @endforeach

                </div>
            </div>
        @endif

    </div>
@endsection
