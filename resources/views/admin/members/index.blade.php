@extends('layouts.admin')

@section('title', 'Manajemen Anggota')

@section('page-title', 'Manajemen Anggota')

@section('page-actions')
    <a href="{{ route('admin.members.create') }}" class="btn btn-purple">
        <i class="bi bi-plus-circle"></i> Tambah Anggota
    </a>
@endsection

@section('content')
    <div class="card card-purple mb-4">
        <div class="card-header d-flex align-items-center">
            <i class="bi bi-funnel me-2 text-purple-600"></i>
            <h5 class="mb-0 header-purple">Filter Anggota</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.members.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <input type="text" name="search" class="form-control" placeholder="Cari (Nama, ID, NIK, Email)" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <select name="district_id" class="form-select">
                            <option value="">-- Semua Distrik --</option>
                            @foreach($districts as $district)
                                <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>
                                    {{ $district->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <select name="status" class="form-select">
                            <option value="">-- Semua Status --</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-purple">
                            <i class="bi bi-search"></i> Cari
                        </button>
                        <a href="{{ route('admin.members.index') }}" class="btn btn-yellow">
                            <i class="bi bi-x-circle"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-yellow">
        <div class="card-header d-flex align-items-center">
            <i class="bi bi-people me-2 text-yellow-600"></i>
            <h5 class="mb-0 header-yellow">Daftar Anggota</h5>
        </div>
        <div class="card-body">
            @if($members->isEmpty())
                <div class="alert alert-info">
                    Tidak ada data anggota yang ditemukan.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>ID Anggota</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Distrik</th>
                                <th>Tgl Daftar</th>
                                <th>Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $index => $member)
                                <tr>
                                    <td>{{ $members->firstItem() + $index }}</td>
                                    <td>{{ $member->member_id }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->nik }}</td>
                                    <td>{{ $member->district?->name ?? '-' }}</td>
                                    <td>{{ $member->registration_date->format('d/m/Y') }}</td>
                                    <td>
                                        @if($member->status == 'active')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.members.show', $member->id) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.members.edit', $member->id) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('admin.members.download-kta', $member->id) }}" class="btn btn-sm btn-success" title="Download KTA">
                                                <i class="bi bi-download"></i>
                                            </a>
                                            <a href="{{ route('admin.members.reset-password', $member->id) }}" class="btn btn-sm btn-warning" title="Reset Password">
                                                <i class="bi bi-key"></i>
                                            </a>
                                            <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?');" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-3">
                    {{ $members->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
