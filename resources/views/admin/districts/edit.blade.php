@extends('layouts.admin')

@section('title', 'Edit Distrik')

@section('page-title', 'Edit Distrik')

@section('page-actions')
    <a href="{{ route('admin.districts.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Form Edit Distrik</h5>
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

            <form action="{{ route('admin.districts.update', $district->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Distrik</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $district->name) }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="code" class="form-label">Kode Distrik</label>
                    <input type="text" class="form-control" id="code" name="code" value="{{ old('code', $district->code) }}" required>
                    <small class="text-muted">Kode harus unik dan akan digunakan sebagai awalan ID anggota</small>
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
