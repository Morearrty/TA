@extends('layouts.district_admin')

@section('title', 'Daftar Proposal Kegiatan')

@section('page-title', 'Daftar Proposal Kegiatan')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('district.admin.proposals.index') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari judul proposal..." name="search" value="{{ request('search') }}">
                            <button class="btn btn-purple" type="submit">
                                <i class="bi bi-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="status" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Review</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}" placeholder="Dari Tanggal">
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}" placeholder="Sampai Tanggal">
                    </div>
                    <div class="col-md-1 text-end">
                        @if(request('search') || request('status') || request('date_from') || request('date_to'))
                            <a href="{{ route('district.admin.proposals.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Proposal Kegiatan</h5>
                <a href="{{ route('district.admin.proposals.create') }}" class="btn btn-sm btn-purple">
                    <i class="bi bi-plus-circle"></i> Buat Proposal
                </a>
            </div>
            <div class="card-body">
                @if($proposals->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Judul Kegiatan</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th>Dibuat Oleh</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proposals as $proposal)
                            <tr>
                                <td>
                                    <a href="{{ route('district.admin.proposals.show', $proposal->id) }}" class="text-decoration-none fw-medium">
                                        {{ Str::limit($proposal->title, 40) }}
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($proposal->start_date)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($proposal->end_date)->format('d M Y') }}</td>
                                <td>
                                    @if($proposal->status == 'pending')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif($proposal->status == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($proposal->status == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>{{ $proposal->creator->name ?? 'Tidak diketahui' }}</td>
                                <td>
                                    <a href="{{ route('district.admin.proposals.show', $proposal->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $proposals->withQueryString()->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <i class="bi bi-clipboard-x" style="font-size: 3rem; color: #d1d5db;"></i>
                    <p class="mt-3 text-muted">Tidak ada proposal ditemukan</p>
                    <a href="{{ route('district.proposals.create') }}" class="btn btn-purple mt-2">
                        <i class="bi bi-plus-circle me-1"></i> Buat Proposal
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
