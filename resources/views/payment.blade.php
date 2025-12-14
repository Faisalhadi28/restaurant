@extends('templates.app')

@section('content')
    <div class="container my-5">
        <div class="card shadow rounded-4 mx-auto" style="max-width: 700px;">
            <div class="card-body p-4">

                {{-- JUDUL --}}
                <h4 class="text-center mb-4 fw-bold">Selesaikan Pembayaran</h4>

                {{-- QR CODE PEMBAYARAN --}}
                <div class="text-center mb-4">
                    <img src="{{ url('storage/' . $qr) }}" class="img-fluid rounded shadow-sm" style="max-width: 260px;">
                </div>
                {{-- RINCIAN PEMBAYARAN --}}
                <div class="table-responsive w-75 mx-auto">
                    <table class="table table-borderless">
                        <tbody>
                            @foreach ($pemesanan->orderDetail as $detail)
                                <tr class="align-middle">
                                    <td class="fw-medium">{{ $detail->menu->name }}</td>
                                    <td class="text-end">
                                        <b>Rp {{ number_format($detail->menu->price, 0, ',', '.') }}</b>
                                        <span class="text-secondary">x{{ $detail->jumlah }}</span>
                                    </td>
                                </tr>
                            @endforeach


                            <tr class="align-middle border-top">
                                <th class="fs-5">Total</th>
                                <th class="fs-5 text-end">
                                    Rp {{ number_format($pemesanan->total_harga , 0, ',', '.') }}
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- TOMBOL --}}
                <form action="{{ route('user.payment.update', $pemesanan->id) }}" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')

                    <button class="btn btn-primary btn-lg w-100 rounded-3">
                        Sudah Dibayar
                    </button>
                </form>

            </div>
        </div>
    </div>
@endsection
