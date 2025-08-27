<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body,
    html {
        height: 100%;
    }

    .login-container {
        height: 100vh;
    }

    .left-side {
        background: url('https://img.freepik.com/free-vector/admin-concept-illustration_114360-2334.jpg') no-repeat center center;
        background-size: cover;
    }

    footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        padding: 10px;
        background: #f8f9fa;
        text-align: center;
        font-size: 14px;
        border-top: 1px solid #ddd;
    }
    </style>
</head>

<body>

    <div class="container-fluid login-container">
        <div class="row h-100">
            <!-- Kiri: Gambar -->
            <div class="col-md-6 d-none d-md-block left-side"></div>

            <!-- Kanan: Form Login -->
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div class="w-75">
                    <h2 class="mb-4 text-center">Login Admin</h2>
                    <form method="POST" action="{{ route('admin.login.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email / Username</label>
                            <input type="text" name="username" class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-danger w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        &copy; {{ date('Y') }} Crochet Lixiu DIY. All rights reserved.
    </footer>

</body>

</html>