@extends('layouts.admin')

@section('title', 'Edit Anggota')

@section('page-title', 'Edit Anggota')

@section('page-actions')
    <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Form Edit Anggota</h5>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="member_id" class="form-label">ID Anggota</label>
                        <input type="text" class="form-control" id="member_id" value="{{ $member->member_id }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="registration_date" class="form-label">Tanggal Daftar</label>
                        <input type="text" class="form-control" id="registration_date" value="{{ $member->registration_date->format('d/m/Y') }}" readonly>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $member->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nik" class="form-label">NIK (16 digit) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik', $member->nik) }}" maxlength="16" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $member->email ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="phone_number" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $member->phone_number ?? '') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $member->address ?? '') }}</textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="place_of_birth" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth', $member->place_of_birth) }}">
                    </div>
                    <div class="col-md-6">
                        <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $member->date_of_birth ? $member->date_of_birth->format('Y-m-d') : '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="gender" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="gender" name="gender">
                            <option value="" selected disabled>Pilih Jenis Kelamin</option>
                            <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="district_id" class="form-label">Distrik/Cabang <span class="text-danger">*</span></label>
                        <select class="form-select" id="district_id" name="district_id" required>
                            <option value="" selected disabled>Pilih Distrik/Cabang</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}" {{ old('district_id', $member->district_id) == $district->id ? 'selected' : '' }}>
                                    {{ $district->name }} ({{ $district->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active" {{ old('status', $member->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status', $member->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="photo" class="form-label">Foto</label>
                        <input class="form-control" type="file" id="photo" name="photo" accept="image/*">
                        <div class="form-text">Upload foto berwarna ukuran 3x4 (maks. 2MB)</div>
                    </div>
                    <div class="col-md-6">
                        @if($member->photo)
                            <div class="mt-2">
                                <label class="form-label">Foto Saat Ini</label>
                                <div>
                                    <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto {{ $member->name }}" class="img-thumbnail" style="max-height: 100px;">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Validasi NIK (hanya angka & maksimum 16 digit)
    document.getElementById('nik').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);
    });
</script>
@endsection
