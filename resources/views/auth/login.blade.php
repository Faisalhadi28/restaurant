<!DOCTYPE html>
<html lang="id">

<head>
    @if (Session::get('failed'))
        <div class="alert alert-danger position-absolute top-0 w-100 text-center m-0">
            {{ Session::get('failed') }}
        </div>
    @endif
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | PESALRESTO</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-light d-flex justify-content-center align-items-center" style="min-height: 100vh;">

    <!-- Alert -->
    @if (Session::get('success'))
        <div class="alert alert-success position-absolute top-0 w-100 text-center m-0">
            {{ Session::get('success') }}
        </div>
    @endif

    @if (Session::get('error'))
        <div class="alert alert-danger position-absolute top-0 w-100 text-center m-0">
            {{ Session::get('error') }}
        </div>
    @endif

    <!-- Login Card -->
    <div class="card shadow p-4" style="width: 400px; border-radius: 18px;">

        <div class="text-center mb-3">
            <h4 class="fw-bold text-success">
                <i class="fa-solid fa-utensils me-2"></i> PESALRESTO
            </h4>
        </div>

        <form method="POST" action="{{ route('login.auth') }}">
            @csrf

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="Masukkan email">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label">Kata Sandi</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="Masukkan password">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button class="btn btn-success w-100 mb-3">Masuk Sekarang</button>

            <div class="text-center small text-muted">
                Belum punya akun? <a href="{{ route('signup') }}" class="text-success fw-semibold">Daftar</a>
            </div>

            <div class="text-center mt-2">
                <a href="{{ route('home') }}" class="text-secondary small">← Kembali ke Beranda</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
