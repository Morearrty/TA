<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .success-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
            text-align: center;
        }
        .success-icon {
            font-size: 80px;
            color: #28a745;
        }
        .member-info {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
            text-align: left;
        }
        .download-button {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="success-card">
                    <div class="success-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <h2 class="mt-4">Pendaftaran Berhasil!</h2>
                    <p class="text-muted">Selamat, Anda telah terdaftar sebagai anggota.</p>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Pendaftaran Anda sedang menunggu persetujuan dari admin. Anda akan mendapatkan notifikasi melalui email setelah pendaftaran disetujui.
                    </div>
                    
                    <div class="member-info">
                        <h5 class="mb-3">Informasi Keanggotaan</h5>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">ID Anggota</div>
                            <div class="col-md-8">{{ $member->member_id }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Nama</div>
                            <div class="col-md-8">{{ $member->name }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Tanggal Pendaftaran</div>
                            <div class="col-md-8">{{ $member->registration_date?->format('d/m/Y') ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-bold">Berlaku Hingga</div>
                            <div class="col-md-8">{{ $member->expiry_date?->format('d/m/Y') ?? '-' }}</div>
                        </div>
                    </div>
                    
                    <div class="download-button">
                        <p class="text-muted mb-3">Setelah pendaftaran Anda disetujui, Anda dapat mengunduh kartu anggota dan mengakses halaman member.</p>
                        <a href="{{ route('anggota.download-kta', $member->id) }}" class="btn btn-primary disabled">
                            <i class="bi bi-download me-2"></i> Download Kartu Anggota
                        </a>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('welcome') }}" class="text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
