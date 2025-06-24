<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #faf7ff; font-family: 'Poppins', sans-serif; }
        .registration-form { background-color: white; border-radius: 10px; box-shadow: 0 5px 20px rgba(88, 28, 135, 0.15); padding: 30px; margin-top: 30px; margin-bottom: 30px; border-top: 4px solid var(--color-purple-600); }
        .form-header h2 { color: var(--color-purple-800); font-weight: 600; }
        .required:after { content: ' *'; color: var(--color-purple-600); }
        .form-control:focus, .form-select:focus { border-color: var(--color-purple-400); box-shadow: 0 0 0 0.25rem rgba(147, 51, 234, 0.25); }
        label { color: var(--color-purple-900); font-weight: 500; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="registration-form">
                    <div class="form-header text-center mb-4">
                        <h2>Form Pendaftaran Anggota</h2>
                        <p class="text-muted">Isi data diri Anda dengan lengkap dan benar</p>
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

                    {{-- GANTI ACTION FORM DI SINI --}}
                    <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- ... sisa form biarkan sama ... --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label required">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="nik" class="form-label required">NIK (16 digit)</label>
                                <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik') }}" maxlength="16" required>
                            </div>
                        </div>
                         <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label required">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone_number" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label required">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label required">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="place_of_birth" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="district_id" class="form-label required">Distrik/Cabang</label>
                                <select class="form-select" id="district_id" name="district_id" required>
                                    <option value="" selected disabled>Pilih Distrik/Cabang</option>
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                         <div class="mb-3">
                            <label for="photo" class="form-label">Foto</label>
                            <input class="form-control" type="file" id="photo" name="photo" accept="image/*">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="agreement" name="agreement" required>
                            <label class="form-check-label" for="agreement">Saya menyatakan bahwa data yang saya berikan adalah benar</label>
                        </div>
                        <div class="text-center">
                            <a href="{{ route('welcome') }}" class="btn btn-outline-secondary me-2">Kembali</a>
                            <button type="submit" class="btn btn-primary btn-lg px-4">Daftar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>