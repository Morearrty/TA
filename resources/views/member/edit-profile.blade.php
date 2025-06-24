@extends('layouts.member')

@section('title', 'Edit Profil')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="page-title d-flex justify-content-between align-items-center">
        <h2>Edit Profil</h2>
        <a href="{{ route('member.profile') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Profil
        </a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        </div>
    @endif
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card card-purple">
                <div class="card-header d-flex align-items-center">
                    <i class="bi bi-image me-2 text-purple-600"></i>
                    <h5 class="mb-0 header-purple">Foto Profil</h5>
                </div>
                <div class="card-body text-center">
                    <form action="{{ route('member.update-photo') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                        @csrf
                        
                        <div class="mb-3">
                            <div class="profile-photo-container mb-3">
                                @if($member->photo)
                                    <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto Profil" class="img-thumbnail rounded-circle mx-auto" style="width: 150px; height: 150px; object-fit: cover;" id="photoPreview">
                                @else
                                    <img src="{{ asset('images/default-avatar.png') }}" alt="Foto Profil Default" class="img-thumbnail rounded-circle mx-auto" style="width: 150px; height: 150px; object-fit: cover;" id="photoPreview">
                                @endif
                            </div>
                            
                            <div class="mb-3">
                                <label for="photo" class="form-label">Pilih Foto Baru</label>
                                <input type="file" class="form-control" id="photo" name="photo" accept="image/*" onchange="previewImage()">
                                <div class="form-text">Format: JPG, PNG, JPEG. Maks: 2MB</div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-purple">
                            <i class="bi bi-upload me-1"></i> Update Foto
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card card-purple">
                <div class="card-header d-flex align-items-center">
                    <i class="bi bi-person-vcard me-2 text-purple-600"></i>
                    <h5 class="mb-0 header-purple">Informasi Pribadi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('member.update-profile') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $member->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $member->email) }}" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="phone_number" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $member->phone_number) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik', $member->nik) }}" readonly>
                                <div class="form-text">NIK tidak dapat diubah</div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $member->date_of_birth ? $member->date_of_birth->format('Y-m-d') : '') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="place_of_birth" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth', $member->place_of_birth) }}">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="district_id" class="form-label">Distrik/Cabang</label>
                                <input type="text" class="form-control" value="{{ $member->district->name }}" readonly>
                                <div class="form-text">Distrik tidak dapat diubah</div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $member->address) }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                            <div class="form-text">Masukkan password saat ini untuk mengonfirmasi perubahan</div>
                        </div>
                        
                        <hr>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <div class="form-text">Biarkan kosong jika tidak ingin mengubah password</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-purple">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage() {
        const file = document.getElementById('photo').files[0];
        const preview = document.getElementById('photoPreview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
