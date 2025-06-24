@extends('layouts.district_admin')

@section('title', 'Detail Anggota')

@section('page-title', 'Detail Anggota')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <a href="{{ route('district.admin.members.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Anggota
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body text-center">
                @if($member->photo)
                    <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto {{ $member->name }}" class="img-fluid rounded mb-3" style="max-height: 200px;">
                @else
                    <div class="bg-light rounded mb-3 d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="bi bi-person-bounding-box" style="font-size: 5rem; color: #ccc;"></i>
                    </div>
                @endif
                
                <h5 class="mb-1">{{ $member->name }}</h5>
                <p class="text-muted mb-3">{{ $member->member_id }}</p>
                
                <div class="d-flex justify-content-center mb-2">
                    @if($member->status == 'active')
                        <span class="badge bg-success px-3 py-2">Aktif</span>
                    @else
                        <span class="badge bg-danger px-3 py-2">Tidak Aktif</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Anggota</h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Informasi Pribadi</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Nama Lengkap</span>
                                <span class="fw-medium">{{ $member->name }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Email</span>
                                <span class="fw-medium">{{ $member->email ?? 'Tidak ada' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Jenis Kelamin</span>
                                <span class="fw-medium">{{ $member->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Tanggal Lahir</span>
                                <span class="fw-medium">{{ $member->birthdate ? \Carbon\Carbon::parse($member->birthdate)->format('d M Y') : 'Tidak ada' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Nomor Telepon</span>
                                <span class="fw-medium">{{ $member->phone ?? 'Tidak ada' }}</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Informasi Keanggotaan</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">ID Anggota</span>
                                <span class="fw-medium">{{ $member->member_id }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Status Anggota</span>
                                <span class="fw-medium">
                                    @if($member->status == 'active')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    @endif
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Status Verifikasi</span>
                                <span class="fw-medium">
                                    @if($member->approval_status == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($member->approval_status == 'pending')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif($member->approval_status == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Peran User</span>
                                <span class="fw-medium">
                                    @if($member->user)
                                        @if($member->user->is_admin)
                                            <span class="badge bg-primary">Admin Utama</span>
                                        @elseif($member->user->role == 'district_admin')
                                            <span class="badge bg-info">Admin Distrik</span>
                                        @else
                                            <span class="badge bg-secondary">Anggota</span>
                                        @endif
                                    @else
                                        <span class="badge bg-warning text-dark">Belum Ada Akun</span>
                                    @endif
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Tanggal Bergabung</span>
                                <span class="fw-medium">{{ \Carbon\Carbon::parse($member->created_at)->format('d M Y') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <h6 class="text-muted mb-2">Alamat</h6>
                        <p>{{ $member->address ?? 'Tidak ada' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
