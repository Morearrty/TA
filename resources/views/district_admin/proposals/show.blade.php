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
                        <p>{{ isset($proposal->budget_details) && is_string($proposal->budget_details) && ($details = json_decode($proposal->budget_details, true)) ? ($details['target_participants'] ?? 'Tidak disebutkan') : 'Tidak disebutkan' }}</p>
                    </div>
                </div>
                
                <h6 class="mb-3">Lampiran</h6>
                <div class="mb-4">
                    @php
                        $details = isset($proposal->budget_details) && is_string($proposal->budget_details) ? json_decode($proposal->budget_details, true) : [];
                        $attachments = $details['attachments'] ?? [];
                    @endphp
                    
                    @if(!empty($attachments))
                        <div class="list-group">
                            @foreach($attachments as $attachment)
                                <a href="{{ asset('storage/' . $attachment) }}" target="_blank" class="list-group-item list-group-item-action">
                                    <i class="bi bi-file-earmark"></i> Lampiran {{ $loop->iteration }}
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Tidak ada lampiran</p>
                    @endif
                </div>
                
                @if($proposal->attachments)
                <h6 class="mb-3">Lampiran</h6>
                <div class="list-group mb-4">
                    @foreach(explode(',', $proposal->attachments) as $attachment)
                        <a href="{{ asset('storage/' . trim($attachment)) }}" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-file-earmark-text me-3 text-primary" style="font-size: 1.2rem;"></i>
                            <span>{{ basename(trim($attachment)) }}</span>
                        </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informasi Proposal</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Diajukan oleh</span>
                        <span class="fw-medium">{{ $proposal->creator->name ?? 'Tidak diketahui' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Tanggal Pengajuan</span>
                        <span class="fw-medium">{{ \Carbon\Carbon::parse($proposal->created_at)->format('d M Y H:i') }}</span>
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
                    @if($proposal->approved_at)
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Tanggal Persetujuan</span>
                        <span class="fw-medium">{{ \Carbon\Carbon::parse($proposal->approved_at)->format('d M Y H:i') }}</span>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Status Proposal</h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column align-items-center">
                    <div class="my-3 text-center">
                        @if($proposal->status == 'pending')
                            <i class="bi bi-hourglass-split" style="font-size: 3rem; color: #f59e0b;"></i>
                            <h5 class="mt-3">Menunggu Persetujuan</h5>
                            <p class="text-muted">Proposal Anda sedang menunggu persetujuan dari admin pusat.</p>
                        @elseif($proposal->status == 'approved')
                            <i class="bi bi-check-circle" style="font-size: 3rem; color: #10b981;"></i>
                            <h5 class="mt-3">Proposal Disetujui</h5>
                            <p class="text-muted">Proposal Anda telah disetujui oleh admin pusat.</p>
                        @elseif($proposal->status == 'rejected')
                            <i class="bi bi-x-circle" style="font-size: 3rem; color: #ef4444;"></i>
                            <h5 class="mt-3">Proposal Ditolak</h5>
                            <p class="text-muted">Proposal Anda ditolak oleh admin pusat.</p>
                        @endif
                    </div>
                </div>
                
                @if($proposal->admin_notes)
                <div class="mt-3">
                    <h6 class="mb-2">Catatan Admin</h6>
                    <div class="p-3 bg-light rounded">
                        {!! nl2br(e($proposal->admin_notes)) !!}
                    </div>
                </div>
                @endif
                
                @if($proposal->status == 'rejected')
                <div class="mt-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('district.admin.proposals.create') }}" class="btn btn-outline-primary">
                            <i class="bi bi-plus-circle me-2"></i> Buat Proposal Baru
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
