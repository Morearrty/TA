@extends('layouts.admin')

@section('title', 'Pendaftaran Anggota Menunggu Persetujuan')
@section('page-title', 'Persetujuan Pendaftaran')

@section('page-actions')
    <a href="{{ route('admin.members.index') }}" class="btn btn-outline-purple">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Anggota
    </a>
@endsection

@section('content')
    <div class="alert mb-4" style="background-color: var(--color-purple-100); border-color: var(--color-purple-300); color: var(--color-purple-900);">
        <div class="d-flex">
            <div class="me-3">
                <i class="bi bi-info-circle-fill fs-3" style="color: var(--color-purple-700);"></i>
            </div>
            <div>
                <h5 class="alert-heading">Informasi</h5>
                <p class="mb-0">Halaman ini menampilkan daftar anggota yang baru mendaftar dan menunggu persetujuan dari admin.</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-people me-2"></i> Daftar Anggota Menunggu Persetujuan</h5>
        </div>
        <div class="card-body">
            @if($pendingMembers->isEmpty())
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>
                    Tidak ada pendaftaran anggota yang menunggu persetujuan.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID Anggota</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>NIK</th>
                                <th>Distrik</th>
                                <th>Tgl Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingMembers as $index => $member)
                                <tr>
                                    <td>{{ $pendingMembers->firstItem() + $index }}</td>
                                    <td>{{ $member->member_id }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td>{{ $member->nik }}</td>
                                    <td>{{ $member->district->name }}</td>
                                    <td>{{ $member->registration_date->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.members.show', $member->id) }}" class="btn btn-sm btn-purple me-1">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                            <button type="button" class="btn btn-sm btn-yellow me-1" data-bs-toggle="modal" data-bs-target="#approveModal-{{ $member->id }}">
                                                <i class="bi bi-check-circle"></i> Setujui
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $member->id }}">
                                                <i class="bi bi-x-circle"></i> Tolak
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Approve Modal -->
                                <div class="modal fade" id="approveModal-{{ $member->id }}" tabindex="-1" aria-labelledby="approveModalLabel-{{ $member->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="approveModalLabel-{{ $member->id }}">Setujui Pendaftaran</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Anda yakin ingin menyetujui pendaftaran anggota <strong>{{ $member->name }}</strong>?</p>
                                                <p class="text-muted">Setelah disetujui, anggota ini akan memiliki akun yang aktif pada sistem.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-purple" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('admin.members.approve', $member->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-yellow">Setujui</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Reject Modal -->
                                <div class="modal fade" id="rejectModal-{{ $member->id }}" tabindex="-1" aria-labelledby="rejectModalLabel-{{ $member->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="rejectModalLabel-{{ $member->id }}">Tolak Pendaftaran</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.members.reject', $member->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menolak pendaftaran anggota <strong>{{ $member->name }}</strong>?</p>
                                                    
                                                    <div class="mb-3">
                                                        <label for="approval_notes" class="form-label">Alasan Penolakan</label>
                                                        <textarea class="form-control" id="approval_notes" name="approval_notes" rows="3" required></textarea>
                                                        <div class="form-text">Masukkan alasan mengapa pendaftaran ini ditolak.</div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-purple" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-yellow">Tolak</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $pendingMembers->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
