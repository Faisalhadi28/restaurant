@extends('templates.app')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success text-center mt-3 shadow-sm rounded-3">
            {{ Session::get('success') }}
        </div>
    @endif

    {{-- CSS MINIMAL --}}
    <style>
        .menu-hero {
            padding: 130px 20px 80px;
            background: linear-gradient(135deg, #fffaf5, #fdf4e8);
        }

        .menu-item.hidden {
            display: none !important;
        }
    </style>

    {{-- HERO --}}
    <section class="menu-hero text-center">
        <h2 class="display-5 fw-bold text-success">Menu Kami</h2>
        <p class="text-muted mx-auto" style="max-width: 700px;">
            Rasakan kelezatan hidangan khas Nusantara dan minuman segar kami yang dibuat dengan bahan berkualitas tinggi.
        </p>
    </section>

    {{-- KATEGORI --}}
    <div class="container my-4">
        <div class="d-flex justify-content-center gap-2 flex-wrap">

            <button class="btn btn-outline-success btn-category active" data-category="all">
                Semua
            </button>

            <button class="btn btn-outline-success btn-category" data-category="makanan">
                Makanan
            </button>

            <button class="btn btn-outline-success btn-category" data-category="minuman">
                Minuman
            </button>

        </div>
    </div>

    {{-- SEARCH BAR --}}
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <input type="text" id="searchInput" class="form-control shadow-sm" placeholder="Cari menu ...">
            </div>
        </div>
    </div>


    {{-- LIST MENU --}}
    <div class="container my-4">
        <div class="row g-4">

            @foreach ($menus as $menu)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 menu-item" data-category="{{ strtolower($menu->category) }}">

                    <div class="card h-100 shadow-sm">

                        <img src="{{ asset('storage/' . $menu->image) }}" class="card-img-top"
                            style="height: 180px; object-fit: cover;">

                        <div class="card-body text-center">

                            <h5 class="card-title fw-bold text-success">
                                {{ $menu->name }}
                            </h5>

                            <p class="fw-semibold mb-3">
                                Rp {{ number_format($menu->price, 0, ',', '.') }}
                            </p>

                            @if (Auth::check())
                                <form action="{{ route('user.pesanan.tambah', $menu->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success w-100">
                                        <i class="fa-solid fa-basket-shopping"></i> Tambah Pesanan
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-success w-100">
                                    <i class="fa-solid fa-basket-shopping"></i> Tambah Pesanan
                                </a>
                            @endif

                        </div>
                    </div>

                </div>
            @endforeach

        </div>
    </div>

    {{-- CTA --}}
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

    {{-- SCRIPT FILTER --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('.btn-category');
            const items = document.querySelectorAll('.menu-item');

            buttons.forEach(btn => {
                btn.addEventListener('click', () => {

                    // Toggle active button
                    buttons.forEach(b => b.classList.remove('active', 'btn-success'));
                    btn.classList.add('active');

                    const category = btn.dataset.category;

                    // Filter menu items
                    items.forEach(item => {
                        if (category === 'all' || item.dataset.category === category) {
                            item.classList.remove('hidden');
                        } else {
                            item.classList.add('hidden');
                        }
                    });

                });
            });
        });
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('.btn-category');
            const items = document.querySelectorAll('.menu-item');
            const searchInput = document.getElementById('searchInput');

            // --- FILTER BY CATEGORY ---
            buttons.forEach(btn => {
                btn.addEventListener('click', () => {

                    buttons.forEach(b => b.classList.remove('active', 'btn-success'));
                    btn.classList.add('active');

                    filterMenu();
                });
            });

            // --- FILTER BY SEARCH ---
            searchInput.addEventListener('keyup', () => {
                filterMenu();
            });

            // --- FUNGSI UTAMA FILTER ---
            function filterMenu() {
                const activeCategory = document.querySelector('.btn-category.active').dataset.category;
                const keyword = searchInput.value.toLowerCase();

                items.forEach(item => {
                    const itemCategory = item.dataset.category;
                    const itemName = item.querySelector('.card-title').innerText.toLowerCase();

                    const matchCategory = activeCategory === 'all' || itemCategory === activeCategory;
                    const matchSearch = itemName.includes(keyword);

                    if (matchCategory && matchSearch) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                });
            }
        });
    </script>
@endpush
