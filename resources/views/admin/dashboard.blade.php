@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('page-title', 'Dashboard Admin')

@section('content')
    <div class="row gx-4">
        <div class="col-md-3">
            <div class="card card-hover" style="background: linear-gradient(135deg, #9333ea, #7e22ce); color: white; border: none;">
                <div class="card-body">
                    <h5 class="card-title">Total Anggota</h5>
                    <h2 class="display-4">{{ $totalMembers }}</h2>
                    <p>Jumlah anggota terdaftar</p>
                    <a href="{{ route('admin.members.index') }}" class="btn btn-yellow mt-2">
                        <i class="bi bi-people"></i> Lihat Semua
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-hover" style="background: linear-gradient(135deg, #e11d48, #be123c); color: white; border: none;">
                <div class="card-body">
                    <h5 class="card-title">Menunggu Approval</h5>
                    <h2 class="display-4">{{ \App\Models\Member::where('approval_status', 'pending')->count() }}</h2>
                    <p>Anggota yang perlu disetujui</p>
                    <a href="{{ route('admin.members.pending') }}" class="btn btn-yellow mt-2">
                        <i class="bi bi-person-check"></i> Lihat Semua
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card card-hover" style="background: linear-gradient(135deg, #22c55e, #16a34a); color: white; border: none;">
                <div class="card-body">
                    <h5 class="card-title">Anggota Aktif</h5>
                    <h2 class="display-4">{{ $activeMembers }}</h2>
                    <p>Anggota dengan status aktif</p>
                    <a href="{{ route('admin.members.index', ['status' => 'active']) }}" class="btn btn-yellow mt-2">
                        <i class="bi bi-check-circle"></i> Lihat Semua
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card card-hover" style="background: linear-gradient(135deg, #eab308, #f59e0b); color: #4a044e; border: none;">
                <div class="card-body">
                    <h5 class="card-title">Anggota Tidak Aktif</h5>
                    <h2 class="display-4">{{ $inactiveMembers }}</h2>
                    <p>Anggota dengan status tidak aktif</p>
                    <a href="{{ route('admin.members.index', ['status' => 'inactive']) }}" class="btn btn-purple mt-2">
                        <i class="bi bi-x-circle"></i> Lihat Semua
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row gx-4 mt-4">
        <div class="col-md-3">
            <div class="card card-hover" style="background: linear-gradient(135deg, #6b21a8, #9333ea); color: white; border: none;">
                <div class="card-body">
                    <h5 class="card-title">Pengajuan Kegiatan</h5>
                    <h2 class="display-4">{{ \App\Models\ActivityProposal::count() }}</h2>
                    <p>Total pengajuan kegiatan</p>
                    <a href="{{ route('admin.proposals.index') }}" class="btn btn-yellow mt-2">
                        <i class="bi bi-file-earmark-text"></i> Lihat Semua
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card card-purple mt-4">
        <div class="card-header d-flex align-items-center">
            <i class="bi bi-geo-alt me-2 text-purple-600"></i>
            <h5 class="mb-0 header-purple">Distribusi Anggota per Distrik</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Distrik</th>
                            <th>Kode</th>
                            <th>Jumlah Anggota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($districts as $district)
                            <tr>
                                <td>{{ $district->name }}</td>
                                <td><span class="badge bg-secondary">{{ $district->code }}</span></td>
                                <td>{{ $district->members_count ?? 0 }}</td>
                                <td>
                                    <a href="{{ route('admin.members.index', ['district_id' => $district->id]) }}" class="btn btn-sm btn-purple">
                                        <i class="bi bi-eye"></i> Lihat Anggota
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
