@extends('layouts.district_admin')

@section('title', 'Daftar Anggota Distrik')

@section('page-title', 'Daftar Anggota Distrik')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('district.admin.members.index') }}" method="GET" class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari nama, ID, atau email..." name="search" value="{{ request('search') }}">
                            <button class="btn btn-purple" type="submit">
                                <i class="bi bi-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="status" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="col-md-3 text-end">
                        @if(request('search') || request('status'))
                            <a href="{{ route('district.admin.members.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Reset Filter
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
            <div class="card-header">
                <h5 class="mb-0">Daftar Anggota</h5>
            </div>
            <div class="card-body">
                @if($members->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID Anggota</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $member)
                            <tr>
                                <td>{{ $member->member_id }}</td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->email ?? '-' }}</td>
                                <td>{{ $member->phone ?? '-' }}</td>
                                <td>
                                    @if($member->status == 'active')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('district.admin.members.show', $member->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $members->withQueryString()->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <i class="bi bi-people" style="font-size: 3rem; color: #d1d5db;"></i>
                    <p class="mt-3 text-muted">Tidak ada anggota ditemukan</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
