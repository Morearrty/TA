@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Reset Password untuk {{ $member->name }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.members.reset-password.update', $member->id) }}" method="POST">
                @csrf
                @method('PUT')

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(isset($hasUserAccount) && !$hasUserAccount)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Info:</strong> Anggota ini belum memiliki akun user. Sistem akan otomatis membuat akun user baru dengan password yang Anda tentukan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="mb-3">
                    <label for="member_id" class="form-label">ID Anggota</label>
                    <input type="text" class="form-control" value="{{ $member->member_id }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" value="{{ $member->name }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{ $member->email }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
