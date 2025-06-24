<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - TA-AMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-form {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 100px;
        }
        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .admin-badge {
            background-color: #dc3545;
            color: white;
            font-size: 0.8rem;
            padding: 3px 8px;
            border-radius: 5px;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-form">
                    <div class="form-header">
                        <h2>Admin Login <span class="admin-badge">ADMIN</span></h2>
                        <p class="text-muted">Login khusus untuk administrator</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-danger">Login</button>
                        </div>
                    </form>
                    
                    <div class="mt-4 text-center">
                        <a href="/" class="text-decoration-none">← Kembali ke Halaman Utama</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
