<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TA-AMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #faf7ff;
            font-family: 'Poppins', sans-serif;
        }
        .login-container {
            max-width: 450px;
            margin: 100px auto;
        }
        .login-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 5px 20px rgba(88, 28, 135, 0.15);
            padding: 30px;
            border-top: 4px solid var(--color-purple-600);
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h2 {
            font-weight: 600;
            color: var(--color-purple-800);
        }
        .form-control:focus {
            border-color: var(--color-purple-600);
            box-shadow: 0 0 0 0.25rem rgba(147, 51, 234, 0.25);
        }
        .btn-login {
            width: 100%;
            padding: 10px;
            font-weight: 500;
            background-color: var(--color-purple-600);
            border-color: var(--color-purple-700);
        }
        .btn-login:hover {
            background-color: var(--color-purple-700);
            border-color: var(--color-purple-800);
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
            background: linear-gradient(135deg, var(--color-purple-600), var(--color-yellow-500));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: transparent;
        }
        .input-group-text {
            background-color: var(--color-purple-100);
            border-color: var(--color-purple-200);
            color: var(--color-purple-700);
        }
        .form-check-input:checked {
            background-color: var(--color-purple-600);
            border-color: var(--color-purple-700);
        }
        a {
            color: var(--color-purple-600);
            text-decoration: none;
        }
        a:hover {
            color: var(--color-purple-800);
            text-decoration: underline;
        }
        .alert-danger {
            background-color: var(--color-yellow-100);
            border-color: var(--color-yellow-300);
            color: var(--color-yellow-800);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <div class="logo">TA-AMS</div>
                    <h2>Login</h2>
                    <p class="text-muted">Masuk ke akun Anda</p>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="small text-end">Lupa password?</a>
                    </div>
                    
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary btn-login">Login</button>
                    </div>
                </form>
                
                <div class="text-center">
                    <p>Anggota baru? <a href="{{ route('anggota.daftar') }}">Daftar akun</a></p>
                    <a href="/" class="text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
