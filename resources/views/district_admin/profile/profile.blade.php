{{-- resources/views/district_admin/profile.blade.php --}}

@extends('layouts.district_admin')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card card-hover">
            <div class="card-body text-center">
                <div class="profile-avatar mx-auto mb-3" style="width: 100px; height: 100px; font-size: 2.5rem;">
                    {{ substr($admin->name, 0, 1) }}
                </div>
                <h5 class="card-title">{{ $admin->name }}</h5>
                <p class="card-text text-muted">{{ $admin->email }}</p>
                <span class="badge badge-district-admin fs-6">Admin Distrik</span>
                <hr>
                <a href="{{ route('district.admin.profile.edit') }}" class="btn btn-purple w-100">
                    <i class="bi bi-pencil-square me-2"></i>Edit Profil
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card card-hover">
            <div class="card-header">
                <h5 class="mb-0">Detail Akun</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <dl class="row">
                    <dt class="col-sm-3">Nama Lengkap</dt>
                    <dd class="col-sm-9">{{ $admin->name }}</dd>

                    <dt class="col-sm-3">Email</dt>
                    <dd class="col-sm-9">{{ $admin->email }}</dd>

                    <dt class="col-sm-3">Peran</dt>
                    <dd class="col-sm-9">
                        <span class="badge badge-district-admin">{{ $admin->getRoleDisplayName() }}</span>
                    </dd>

                    <dt class="col-sm-3">Distrik</dt>
                    <dd class="col-sm-9">{{ $admin->member->district->name ?? 'N/A' }}</dd>

                    <dt class="col-sm-3">Bergabung Sejak</dt>
                    <dd class="col-sm-9">{{ $admin->created_at->format('d F Y') }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection