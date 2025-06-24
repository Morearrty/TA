@extends('layouts.admin')

@section('title', 'Tambah Distrik')

@section('page-title', 'Tambah Distrik')

@section('page-actions')
    <a href="{{ route('admin.districts.index') }}" class="btn btn-yellow">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="card card-purple">
        <div class="card-header d-flex align-items-center">
            <i class="bi bi-geo-alt me-2 text-purple-600"></i>
            <h5 class="mb-0 header-purple">Form Tambah Distrik</h5>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.districts.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Distrik</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="code" class="form-label">Kode Distrik</label>
                    <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" required>
                    <small class="text-muted">Kode harus unik dan akan digunakan sebagai awalan ID anggota</small>
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn btn-purple">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
