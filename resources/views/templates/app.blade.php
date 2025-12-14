<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PesalResto</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
        }

        /* Sidebar */
        #sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #ffffff;
            border-right: 1px solid #ddd;
            padding-top: 80px; /* Space for top navbar */
            transition: all .3s;
        }

        #sidebar .nav-link {
            padding: 12px 20px;
            color: #333;
            font-weight: 500;
        }

        #sidebar .nav-link:hover {
            background: #e9f5ee;
            color: #198754;
        }

        /* Content */
        #content {
            margin-left: 250px;
            padding: 90px 30px 30px 30px;
            transition: all .3s;
        }

        /* For Mobile */
        @media (max-width: 992px) {
            #sidebar {
                left: -260px;
            }

            #sidebar.show {
                left: 0;
            }

            #content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

<!-- TOP NAVBAR (Toggle Button) -->
<nav class="navbar navbar-light bg-white shadow-sm fixed-top">
    <div class="container-fluid">
        <button class="btn btn-outline-success d-lg-none" id="toggleSidebar">
            <i class="bi bi-list"></i>
        </button>
        <span class="navbar-brand fw-bold text-success ms-2">PesalResto</span>
    </div>
</nav>

<!-- SIDEBAR -->
<div id="sidebar">

    <ul class="nav flex-column">

        {{-- ADMIN MENU --}}
        @if (Auth::check() && Auth::user()->role === 'admin')

            <li><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
            <li><a class="nav-link" href="{{ route('admin.menus.index') }}"><i class="bi bi-card-list me-2"></i> Menu</a></li>
            <li><a class="nav-link" href="{{ route('admin.pemesanans.index') }}"><i class="bi bi-receipt me-2"></i> Pemesanan</a></li>
            <li><a class="nav-link" href="{{ route('admin.users.index') }}"><i class="bi bi-people me-2"></i> Users</a></li>
            <li><a class="nav-link" href="{{ route('admin.reservasis.index') }}"><i class="bi bi-calendar-check me-2"></i> Reservasi</a></li>

            <hr class="text-muted">

            <li>
                <a href="{{ route('logout') }}" class="nav-link text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </li>

        {{-- USER MENU --}}
        @elseif(Auth::check() && Auth::user()->role === 'user')

            <li><a class="nav-link" href="{{ route('home') }}"><i class="bi bi-house me-2"></i> Home</a></li>
            <li><a class="nav-link" href="{{ route('menuss') }}"><i class="bi bi-grid me-2"></i> Menu</a></li>
            <li><a class="nav-link" href="{{ route('user.keranjang') }}"><i class="bi bi-cart me-2"></i> Pesanan</a></li>
            <li><a class="nav-link" href="{{ route('user.histori') }}"><i class="bi bi-clock-history me-2"></i> History</a></li>

            <hr class="text-muted">

            <li><a class="nav-link" href="{{ route('user.profile') }}"><i class="bi bi-person me-2"></i> Profil Saya</a></li>

            <li>
                <a class="nav-link text-danger" href="{{ route('logout') }}">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </li>

        {{-- GUEST --}}
        @else

            <li><a class="nav-link" href="{{ route('home') }}"><i class="bi bi-house me-2"></i> Home</a></li>
            <li><a class="nav-link" href="{{ route('menuss') }}"><i class="bi bi-grid me-2"></i> Menu</a></li>

            <hr>

            <li><a href="{{ route('login') }}" class="nav-link text-success"><i class="bi bi-box-arrow-in-right me-2"></i> Login</a></li>
            <li><a href="{{ route('signup') }}" class="nav-link text-success"><i class="bi bi-person-plus me-2"></i> Signup</a></li>

        @endif

    </ul>

</div>

<!-- MAIN CONTENT -->
<div id="content">
    @yield('content')
</div>


<!-- JS SCRIPTS (tidak dihapus) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@stack('script')

<script>
    // Sidebar toggle (mobile)
    document.getElementById('toggleSidebar').onclick = function () {
        document.getElementById('sidebar').classList.toggle('show');
    };
</script>

</body>
</html>
