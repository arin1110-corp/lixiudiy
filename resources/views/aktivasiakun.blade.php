<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Customer</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
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

    .btn-primary {
        border-radius: 12px;
        font-weight: 600;
        padding: 12px;
        transition: all 0.3s ease;
        background-color: #198754;
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.4);
        background-color: #157347;
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

    .input-group-text {
        cursor: pointer;
        border-radius: 0 12px 12px 0;
    }
    </style>
</head>

<body>

    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card p-4 p-md-5" style="max-width: 400px; width: 100%;">
            <center>
                <img src="{{ asset('images/logo.png') }}" alt="Logo Toko" class="logo">
            </center>
            <h3 class="text-center mb-4">Login Customer</h3>

            <form method="POST" action="{{ route('customer.aktivasi') }}">
                @csrf
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="contoh@email.com"
                        required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Token Aktivasi</label>
                    <div class="input-group">
                        <input type="token" class="form-control" id="password" name="token"
                            placeholder="Masukkan token aktivasi" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <p class="text-center mt-3 mb-0">
                Belum punya akun? <a href="{{ route('customer.register') }}">Daftar disini</a>
            </p>
        </div>
    </div>

    <script>
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        const toggleIcon = document.getElementById("togglePassword");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.textContent = "🙈";
        } else {
            passwordInput.type = "password";
            toggleIcon.textContent = "👁";
        }
    }
    </script>

</body>

</html>