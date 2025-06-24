@extends('layouts.admin')

@section('title', 'Manajemen Distrik')

@section('page-title', 'Manajemen Distrik')

@section('page-actions')
    <a href="{{ route('admin.districts.create') }}" class="btn btn-purple">
        <i class="bi bi-plus-circle"></i> Tambah Distrik
    </a>
@endsection

@section('content')
<div style="margin-left:0 !important; width:100vw; max-width:100vw; padding:0;">
    <div class="container-fluid px-0" style="padding-left:0 !important; padding-right:0 !important;">
        <div class="card" style="margin-left:0 !important; width:100vw; max-width:100vw;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 header-purple">Daftar Distrik</h5>
            </div>
            <div class="card-body">
                @if($districts->isEmpty())
                    <div class="alert alert-purple">
                        <i class="bi bi-info-circle me-2"></i> Belum ada data distrik. Silakan tambahkan distrik baru.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nama Distrik</th>
                                    <th>Kode</th>
                                    <th>Jumlah Anggota</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($districts as $index => $district)
                                    <tr>
                                        <td>{{ $districts->firstItem() + $index }}</td>
                                        <td>{{ $district->name }}</td>
                                        <td><span class="badge badge-purple">{{ $district->code }}</span></td>
                                        <td>{{ $district->members_count ?? 0 }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.districts.edit', $district->id) }}" class="btn btn-sm btn-purple">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.districts.destroy', $district->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus distrik ini?');" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-yellow">
                                                        <i class="bi bi-trash"></i> Hapus
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
                        {{ $districts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
