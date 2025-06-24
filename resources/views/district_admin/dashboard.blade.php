@extends('layouts.district_admin')

@section('title', 'Dashboard Admin Distrik')

@section('page-title', 'Dashboard Admin Distrik')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading"><i class="bi bi-info-circle-fill me-2"></i>Selamat Datang, Admin Distrik!</h4>
            <p>Anda memiliki akses untuk mengelola proposal kegiatan dan melihat data anggota di distrik Anda.</p>
        </div>
    </div>
</div>

<div class="row gx-4">
    <div class="col-md-4">
        <div class="card card-hover" style="background: linear-gradient(135deg, #7c3aed, #4c1d95); color: white; border: none;">
            <div class="card-body">
                <h5 class="card-title">Total Anggota</h5>
                <h2 class="display-4">{{ $membersCount }}</h2>
                <p>Jumlah anggota di distrik</p>
                <a href="{{ route('district.admin.members.index') }}" class="btn btn-yellow mt-2">
                    <i class="bi bi-people"></i> Lihat Anggota
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-hover" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border: none;">
            <div class="card-body">
                <h5 class="card-title">Proposal Menunggu</h5>
                <h2 class="display-4">{{ $pendingProposalsCount }}</h2>
                <p>Proposal yang perlu ditinjau</p>
                <a href="{{ route('district.admin.proposals.index', ['status' => 'pending']) }}" class="btn btn-light mt-2">
                    <i class="bi bi-clock"></i> Tinjau Proposal
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-hover" style="background: linear-gradient(135deg, #10b981, #047857); color: white; border: none;">
            <div class="card-body">
                <h5 class="card-title">Proposal Disetujui</h5>
                <h2 class="display-4">{{ $approvedProposalsCount }}</h2>
                <p>Proposal yang telah disetujui</p>
                <a href="{{ route('district.admin.proposals.index', ['status' => 'approved']) }}" class="btn btn-light mt-2">
                    <i class="bi bi-check2-circle"></i> Lihat Proposal
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Proposal Terbaru</h5>
                <a href="{{ route('district.admin.proposals.index') }}" class="btn btn-sm btn-purple">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($latestProposals->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestProposals as $proposal)
                            <tr>
                                <td>
                                    <a href="{{ route('district.admin.proposals.show', $proposal->id) }}" class="fw-medium text-decoration-none">
                                        {{ Str::limit($proposal->title, 30) }}
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($proposal->start_date)->format('d/m/Y') }}</td>
                                <td>
                                    @if($proposal->status == 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif($proposal->status == 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                    @elseif($proposal->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('district.admin.proposals.show', $proposal->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="bi bi-clipboard-x" style="font-size: 3rem; color: #d1d5db;"></i>
                    <p class="mt-3 text-muted">Belum ada proposal kegiatan</p>
                    <a href="{{ route('district.proposals.create') }}" class="btn btn-sm btn-purple mt-2">
                        <i class="bi bi-plus-circle me-1"></i> Buat Proposal
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Anggota Terbaru</h5>
                <a href="{{ route('district.admin.members.index') }}" class="btn btn-sm btn-purple">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($latestMembers->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($latestMembers as $member)
                    <a href="{{ route('district.admin.members.show', $member->id) }}" class="list-group-item list-group-item-action d-flex align-items-center py-3">
                        <div class="me-3">
                            @if($member->photo)
                            <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto {{ $member->name }}" class="rounded-circle" width="40" height="40">
                            @else
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-person"></i>
                            </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">{{ $member->name }}</h6>
                            <small class="text-muted">{{ $member->member_id }}</small>
                        </div>
                        <div>
                            @if($member->approval_status == 'approved')
                            <span class="badge bg-success">Aktif</span>
                            @elseif($member->approval_status == 'pending')
                            <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($member->approval_status == 'rejected')
                            <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </div>
                    </a>
                    @endforeach
                </div>
                @else
                <div class="text-center py-4">
                    <i class="bi bi-people" style="font-size: 3rem; color: #d1d5db;"></i>
                    <p class="mt-3 text-muted">Belum ada anggota di distrik ini</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
