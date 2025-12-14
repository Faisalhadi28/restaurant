@extends('templates.app')

@section('content')
    {{-- ALERTS --}}
    @if (Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3 shadow-sm" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    @if (Session::get('logout'))
        <div class="alert alert-warning alert-dismissible fade show mt-3 shadow-sm" role="alert">
            {{ Session::get('logout') }}
        </div>
    @endif


    {{-- HERO SECTION --}}
    <section class="min-vh-100 d-flex align-items-center bg-light">
        <div class="container text-center">
            <h1 class="display-4 fw-bold text-success mb-3">
                Selamat Datang di <span class="text-warning">PesalResto</span>
            </h1>
            <p class="lead text-secondary mb-4 mx-auto" style="max-width: 650px">
                Nikmati cita rasa autentik dengan tampilan modern dan kualitas terbaik.
                PesalResto selalu menghadirkan yang spesial untuk Anda.
            </p>

            <a href="#best-seller" class="btn btn-success btn-lg px-4 rounded-pill shadow-sm">
                Lihat Menu Favorit
            </a>
        </div>
    </section>

    <section id="best-seller" class="py-5">
        <div class="container">

            <div class="text-center mb-5">
                <h2 class="fw-bold text-success">Menu Favorit Kami</h2>
                <div class="mx-auto bg-warning rounded" style="width: 80px; height: 4px;"></div>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach ($menus as $menu)
                    <div class="col-md-4 col-lg-3">

                        <div class="card shadow-sm rounded-4 h-100 overflow-hidden">
                            <img src="{{ asset('storage/' . $menu->image) }}" class="card-img-top" alt="{{ $menu->name }}"
                                style="height: 190px; object-fit: cover">

                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $menu->name }}</h5>
                                <p class="text-success fw-bold mb-3">
                                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                                </p>

                                @if (Auth::check())
                                    <form action="{{ route('user.pesanan.tambah', $menu->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-outline-success w-100">
                                            <i class="fa-solid fa-basket-shopping me-1"></i> Tambah Pesanan
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-success w-100">
                                        <i class="fa-solid fa-basket-shopping me-1"></i> Tambah Pesanan
                                    </a>
                                @endif

                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </section>


    <div class="container my-5">
        <div class="p-5 rounded text-center text-white" style="background: linear-gradient(135deg, #007b5e, #00a77a);">

            <h3 class="fw-bold">Ingin Makan di Tempat?</h3>

            <p class="mx-auto mb-4" style="max-width: 500px;">
                Reservasi sekarang dan nikmati pengalaman kuliner terbaik dengan suasana nyaman dan pelayanan istimewa.
            </p>

            <a href="{{ route('user.reservasi') }}" class="btn btn-light px-4 py-2 fw-semibold">
                BOOK A TABLE
            </a>

        </div>
    </div>


    {{-- <footer class="bg-dark text-light text-center p-0">
        <div class="container py-5">

            <h5 class="fw-bold text-warning mb-3">PESALRESTO</h5>
            <p class="text-secondary mx-auto" style="max-width: 600px">
                Nikmati cita rasa khas Nusantara dalam suasana modern dan hangat.
                Setiap sajian dibuat dengan bahan terbaik.
            </p>

            <div class="d-flex flex-column flex-md-row justify-content-center gap-3 text-secondary small mt-3">
                <div><i class="fas fa-map-marker-alt text-warning me-2"></i>Jl. Raya Ciawi No.456, Bogor</div>
                <div><i class="fas fa-envelope text-warning me-2"></i>pesalresto@gmail.com</div>
                <div><i class="fas fa-phone text-warning me-2"></i>+62 812 3456 7890</div>
            </div>

            <div class="border-top border-secondary mt-4 pt-3">
                <small class="text-secondary">© 2025 <span class="text-warning">PesalResto</span> — All Rights
                    Reserved.</small>
            </div>

        </div>
    </footer> --}}
@endsection
