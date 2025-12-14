<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PESALRESTO - Daftar Akun</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="min-height: 100vh;">

    <div class="card shadow p-4" style="width: 430px; border-radius: 18px;">

        <div class="text-center mb-3">
            <h4 class="fw-bold text-success"><i class="fa-solid fa-utensils me-2"></i>Daftar Akun</h4>
        </div>

        <form method="POST" action="{{ route('signup.register') }}">
            @csrf

            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Nama Depan</label>
                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}">
                    @error('first_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col">
                    <label class="form-label">Nama Belakang</label>
                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}">
                    @error('last_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Kata Sandi</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <button type="submit" class="btn btn-success w-100 mb-3">Daftar Sekarang</button>

            <p class="text-center small text-muted">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-success fw-semibold">Login di sini</a>
            </p>

            <div class="text-center mt-2">
                <a href="{{ route('home') }}" class="text-secondary small">← Kembali ke Beranda</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
