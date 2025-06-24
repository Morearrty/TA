@extends('layouts.district_admin')

@section('title', 'Detail Proposal Kegiatan')
@section('page-title', 'Detail Proposal Kegiatan')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <a href="{{ route('district.admin.proposals.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Proposal
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Proposal</h5>
                <span class="badge 
                    @if($proposal->status == 'pending') bg-warning text-dark
                    @elseif($proposal->status == 'approved') bg-success
                    @elseif($proposal->status == 'rejected') bg-danger
                    @endif
                    px-3 py-2">
                    @if($proposal->status == 'pending') Menunggu Persetujuan Admin
                    @elseif($proposal->status == 'approved') Disetujui
                    @elseif($proposal->status == 'rejected') Ditolak
                    @endif
                </span>
            </div>
            <div class="card-body">
                <h4>{{ $proposal->title }}</h4>
                <p class="text-muted mb-4">
                    <i class="bi bi-calendar-event me-1"></i> 
                    {{ \Carbon\Carbon::parse($proposal->start_date)->format('d M Y') }} - 
                    {{ \Carbon\Carbon::parse($proposal->end_date)->format('d M Y') }}
                </p>
                
                <h6 class="mb-3">Deskripsi Kegiatan</h6>
                <div class="p-3 bg-light rounded mb-4">
                    {!! nl2br(e($proposal->description)) !!}
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="mb-3">Lokasi</h6>
                        <p>{{ $proposal->location ?? 'Tidak disebutkan' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="mb-3">Target Peserta</h6>
                        {{-- MEMBACA DARI KOLOM YANG BENAR --}}
                        <p>{{ $proposal->target_participants ?? 'Tidak disebutkan' }}</p>
                    </div>
                </div>
                
                <h6 class="mb-3">Lampiran</h6>
                <div class="mb-4">
                    @php
                        // MEMBACA DARI KOLOM 'attachments' YANG BENAR
                        $attachments = json_decode($proposal->attachments, true) ?? [];
                    @endphp
                    
                    @if(!empty($attachments))
                        <div class="list-group">
                            @foreach($attachments as $attachment)
                                <a href="{{ asset('storage/' . $attachment) }}" target="_blank" class="list-group-item list-group-item-action">
                                    <i class="bi bi-file-earmark-arrow-down me-2"></i> {{ basename($attachment) }}
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Tidak ada lampiran</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        {{-- Sisa dari view ini sudah benar, tidak perlu diubah --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informasi Proposal</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Diajukan oleh</span>
                        {{-- Menggunakan relasi 'creator' yang ada di model --}}
                        <span class="fw-medium">{{ $proposal->creator->name ?? 'Tidak diketahui' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Tanggal Pengajuan</span>
                        <span class="fw-medium">{{ \Carbon\Carbon::parse($proposal->submitted_at ?? $proposal->created_at)->format('d M Y H:i') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Status</span>
                        <span>
                            @if($proposal->status == 'pending')
                                <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                            @elseif($proposal->status == 'approved')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($proposal->status == 'rejected')
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection