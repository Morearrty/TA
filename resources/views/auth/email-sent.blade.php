<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Terkirim - TA-AMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="auth-card">
                    <div class="text-center mb-4">
                        <h3 class="text-purple">TA-AMS</h3>
                        <h2 class="auth-title">Email Terkirim</h2>
                        <div class="my-4 text-center">
                            <i class="bi bi-envelope-check text-success" style="font-size: 60px;"></i>
                        </div>
                        <p class="mb-0">Link reset password telah dikirim ke email Anda.</p>
                        <p class="text-muted">Silakan periksa kotak masuk email Anda dan ikuti instruksi untuk reset password.</p>
                    </div>
                    
                    @if(session('reset_link'))
                    <div class="alert alert-info">
                        <h5>Link Reset Password Demo:</h5>
                        <a href="{{ session('reset_link') }}" class="alert-link">{{ session('reset_link') }}</a>
                        <p class="small mt-2 mb-0">Catatan: Pada sistem live, link ini akan dikirim via email.</p>
                    </div>
                    @endif

                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
