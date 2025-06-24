@extends('layouts.admin')

@section('title', 'Detail Anggota')

@section('page-title', 'Detail Anggota')

@section('content')
    <div class="row">
        <div class="mb-3">
            <a href="{{ route('admin.members.edit', $member->id) }}" class="btn btn-primary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('admin.members.download-kta', $member->id) }}" class="btn btn-success">
                <i class="bi bi-download"></i> Download KTA
            </a>
            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
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
                    
                    <!-- Informasi Peran User -->
                    <div class="mt-3">
                        <h6 class="text-muted mb-2">Peran User</h6>
                        @if($member->user)
                            <div class="d-flex justify-content-center mb-2">
                                @if($member->user->is_admin)
                                    <span class="badge bg-primary px-3 py-2">Admin Utama</span>
                                @elseif($member->user->role == 'district_admin')
                                    <span class="badge bg-info px-3 py-2">Admin Distrik</span>
                                @else
                                    <span class="badge bg-secondary px-3 py-2">Anggota</span>
                                @endif
                            </div>
                            
                            <!-- Tombol Ubah Peran -->
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#changeRoleModal">
                                    <i class="bi bi-person-gear"></i> Ubah Peran
                                </button>
                            </div>
                        @else
                            <p class="text-muted">Belum memiliki akun user</p>
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
                                    <span class="fw-medium">{{ $member->user?->email ?? $member->email ?? 'Tidak ada' }}</span>
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
                                    <span class="text-muted">Distrik</span>
                                    <span class="fw-medium">{{ $member->district?->name ?? 'Tidak ada' }}</span>
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

    <!-- Modal Ubah Peran -->
    <div class="modal fade" id="changeRoleModal" tabindex="-1" aria-labelledby="changeRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeRoleModalLabel">Ubah Peran Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.members.update-role', $member->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="role" class="form-label">Pilih Peran</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="member" {{ $member->user && $member->user->role == 'member' && !$member->user->is_admin ? 'selected' : '' }}>Anggota Biasa</option>
                                <option value="district_admin" {{ $member->user && $member->user->role == 'district_admin' ? 'selected' : '' }}>Admin Distrik</option>
                            </select>
                            <div class="form-text">Admin Distrik dapat mengelola proposal kegiatan dan melihat data anggota di distriknya.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
