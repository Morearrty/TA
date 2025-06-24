@extends('layouts.district_admin')

@section('title', 'Buat Proposal Kegiatan')

@section('page-title', 'Buat Proposal Kegiatan')

@section('styles')
<style>

    
    .attachments-area {
        padding: 20px;
        border: 2px dashed #d1d5db;
        border-radius: 5px;
        background-color: #f9fafb;
        text-align: center;
    }
    
    .attachments-area.dragover {
        background-color: #f5f3ff;
        border-color: #8b5cf6;
    }
</style>
@endsection

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <a href="{{ route('district.admin.proposals.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Proposal
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Pengajuan Proposal Kegiatan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('district.admin.proposals.store') }}" method="POST" enctype="multipart/form-data" id="proposalForm">
                    @csrf
                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Kegiatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi Kegiatan <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="location" class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" required>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="target_participants" class="form-label">Target Peserta <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('target_participants') is-invalid @enderror" id="target_participants" name="target_participants" value="{{ old('target_participants') }}" required>
                                @error('target_participants')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    

                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="attachments" class="form-label">Lampiran (opsional)</label>
                                <div class="attachments-area" id="attachments-area">
                                    <i class="bi bi-cloud-arrow-up" style="font-size: 2rem; color: #6d28d9;"></i>
                                    <p class="mt-2">Seret file ke sini atau klik untuk mengunggah</p>
                                    <small class="text-muted">Jenis file yang didukung: PDF, Word, Excel, JPG, PNG (Maks. 10MB)</small>
                                    <input type="file" name="attachments[]" id="attachments" multiple class="d-none">
                                </div>
                                <div id="file-list" class="mt-3"></div>
                                @error('attachments')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                                @error('attachments.*')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                Proposal yang sudah dikirim akan diproses oleh admin pusat untuk mendapatkan persetujuan.
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="window.history.back()">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Kirim Proposal
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        
        // File upload handling
        const attachmentsArea = document.getElementById('attachments-area');
        const attachmentsInput = document.getElementById('attachments');
        const fileList = document.getElementById('file-list');
        
        attachmentsArea.addEventListener('click', () => {
            attachmentsInput.click();
        });
        
        attachmentsArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            attachmentsArea.classList.add('dragover');
        });
        
        attachmentsArea.addEventListener('dragleave', () => {
            attachmentsArea.classList.remove('dragover');
        });
        
        attachmentsArea.addEventListener('drop', (e) => {
            e.preventDefault();
            attachmentsArea.classList.remove('dragover');
            
            if (e.dataTransfer.files.length) {
                attachmentsInput.files = e.dataTransfer.files;
                updateFileList();
            }
        });
        
        attachmentsInput.addEventListener('change', updateFileList);
        
        function updateFileList() {
            fileList.innerHTML = '';
            
            if (attachmentsInput.files.length) {
                const ul = document.createElement('ul');
                ul.className = 'list-group';
                
                Array.from(attachmentsInput.files).forEach(file => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item d-flex align-items-center';
                    
                    // Icon based on file type
                    let icon = 'bi-file-earmark';
                    if (file.type.includes('pdf')) {
                        icon = 'bi-file-earmark-pdf';
                    } else if (file.type.includes('word')) {
                        icon = 'bi-file-earmark-word';
                    } else if (file.type.includes('excel') || file.type.includes('sheet')) {
                        icon = 'bi-file-earmark-excel';
                    } else if (file.type.includes('image')) {
                        icon = 'bi-file-earmark-image';
                    }
                    
                    li.innerHTML = `
                        <i class="bi ${icon} me-2"></i>
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">${file.name}</div>
                            <small>${(file.size / 1024 / 1024).toFixed(2)} MB</small>
                        </div>
                    `;
                    
                    ul.appendChild(li);
                });
                
                fileList.appendChild(ul);
            }
        }
        
        // Form validation
        document.getElementById('proposalForm').addEventListener('submit', function(e) {
            const startDate = new Date(document.getElementById('start_date').value);
            const endDate = new Date(document.getElementById('end_date').value);
            
            if (endDate < startDate) {
                e.preventDefault();
                alert('Tanggal selesai tidak boleh sebelum tanggal mulai.');
                return false;
            }
            
            return true;
        });
    });
</script>
@endsection
