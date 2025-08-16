<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e0f7fa);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border: none;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
        }

        .btn-success {
            border-radius: 12px;
            font-weight: 600;
            padding: 12px;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(25, 135, 84, 0.4);
        }

        .logo {
            width: 120px;
            margin-bottom: 15px;
        }

        h3 {
            font-weight: 700;
            color: #333;
        }

        .text-center a {
            color: #198754;
            font-weight: 500;
            text-decoration: none;
        }

        .text-center a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card p-4 p-md-5" style="max-width: 450px; width: 100%;">

            <center>
                <img src="{{ asset('images/logo.png') }}" alt="Logo Toko" class="logo">
            </center>
            <h3 class="text-center mb-4">Daftar Akun Customer</h3>

            <form method="POST" action="{{ route('customer.register') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama lengkap"
                        required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="contoh@email.com"
                        required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label fw-bold">Nomor Telepon</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="08xxxxxxxxxx" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Minimal 6 karakter" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        placeholder="Ulangi password" required>
                </div>

                <button type="submit" class="btn btn-success w-100">Daftar</button>
            </form>

            <p class="text-center mt-3 mb-0">
                Sudah punya akun? <a href="{{ route('customer.login') }}">Login disini</a>
            </p>
        </div>
    </div>

</body>

</html>