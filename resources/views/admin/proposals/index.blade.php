@extends('layouts.admin')

@section('title', 'Pengajuan Kegiatan')
@section('page-title', 'Pengajuan Kegiatan')

@section('content')
<div style="margin-left:0 !important; width:100vw; max-width:100vw; padding:0;">
    <div class="container-fluid px-0" style="padding-left:0 !important; padding-right:0 !important;">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.proposals.index') }}" class="row g-3">
                            <div class="col-md-4">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="all" {{ $status == 'all' ? 'selected' : '' }}>All Statuses</option>
                                    <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="district_id" class="form-label">District</label>
                                <select name="district_id" id="district_id" class="form-select">
                                    <option value="">All Districts</option>
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}" {{ $district_id == $district->id ? 'selected' : '' }}>
                                            {{ $district->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn" style="background-color: #6f42c1; color: white">
                                        <i class="bi bi-filter me-1"></i> Filter
                                    </button>
                                    <a href="{{ route('admin.proposals.index') }}" class="btn" style="background-color: #ffc107; color: #212529">
                                        <i class="bi bi-arrow-clockwise me-1"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="margin-left:0 !important; width:100vw; max-width:100vw;">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr style="background-color: #6f42c1; color: white">
                                <th>ID</th>
                                <th>Title</th>
                                <th>District</th>

                                <th>Status</th>
                                <th>Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($proposals as $proposal)
                                <tr>
                                    <td>{{ $proposal->id }}</td>
                                    <td>{{ $proposal->title }}</td>
                                    <td>{{ $proposal->district?->name ?? '-' }}</td>

                                    <td>
                                        @if($proposal->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($proposal->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>{{ $proposal->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.proposals.show', $proposal->id) }}" class="btn btn-sm" style="background-color: #6f42c1; color: white">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No activity proposals found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $proposals->appends(['status' => $status, 'district_id' => $district_id])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
