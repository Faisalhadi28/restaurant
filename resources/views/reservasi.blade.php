@extends('templates.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-6">

                <div class="card shadow-sm border-0 mt-3">
                    <div class="card-header bg-success text-white text-center fw-bold">
                        FORM RESERVASI
                    </div>

                    <div class="card-body p-4">

                        {{-- Alert sukses --}}
                        @if (session('success'))
                            <div class="alert alert-success text-center fw-semibold">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Jika belum login --}}
                        @if (!Auth::check())
                            <div class="alert alert-warning text-center fw-semibold">
                                Silakan login terlebih dahulu untuk melakukan reservasi.
                            </div>

                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}" class="btn btn-success">Login Sekarang</a>
                            </div>
                        @else
                            <form action="{{ route('user.reservasi.store') }}" method="POST">
                                @csrf

                                {{-- Nama User --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Nama Pemesan</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ Auth::check() ? Auth::user()->name : '' }}">
                                </div>

                                {{-- Tanggal --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tanggal Reservasi</label>
                                    <input type="date" name="tanggal" class="form-control" required>
                                </div>

                                {{-- Jam --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Jam</label>
                                    <input type="time" name="jam" class="form-control" required>
                                </div>

                                {{-- Jumlah Orang --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Jumlah Orang</label>
                                    <input type="number" name="jumlah_orang" class="form-control" placeholder="Contoh: 4"
                                        required>
                                </div>

                                {{-- Catatan --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Catatan (opsional)</label>
                                    <textarea name="catatan" class="form-control" rows="3" placeholder="Contoh: meja dekat jendela"></textarea>
                                </div>

                                <div class="d-flex justify-content-between mt-3">
                                    <a href="{{ route('home') }}" class="btn btn-danger">
                                        Kembali
                                    </a>

                                    <button class="btn btn-success w-15 fw-semibold mt-2">
                                        Kirim Reservasi
                                    </button>
                                </div>

                            </form>
                        @endif

                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
