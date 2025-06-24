@extends('layouts.admin')

@section('title', 'Proposal Detail')
@section('page-title', 'Activity Proposal Detail')

@section('page-actions')
    <a href="{{ route('admin.proposals.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Proposals
    </a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Basic Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th width="150">ID</th>
                            <td>{{ $proposal->id }}</td>
                        </tr>
                        <tr>
                            <th>Title</th>
                            <td>{{ $proposal->title }}</td>
                        </tr>
                        <tr>
                            <th>District</th>
                            <td>{{ $proposal->district->name }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($proposal->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($proposal->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Submitted</th>
                            <td>{{ $proposal->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        @if($proposal->status != 'pending')
                            <tr>
                                <th>
                                    @if($proposal->status == 'approved')
                                        Approved By
                                    @else
                                        Rejected By
                                    @endif
                                </th>
                                <td>{{ $proposal->approver->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>
                                    @if($proposal->status == 'approved')
                                        Approval Date
                                    @else
                                        Rejection Date
                                    @endif
                                </th>
                                <td>{{ $proposal->approval_date ? $proposal->approval_date->format('d M Y H:i') : 'N/A' }}</td>
                            </tr>
                            @if($proposal->status == 'rejected')
                                <tr>
                                    <th>Rejection Reason</th>
                                    <td>{{ $proposal->rejection_reason }}</td>
                                </tr>
                            @endif
                        @endif
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>Activity Details</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th width="150">Start Date</th>
                            <td>{{ $proposal->start_date->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>End Date</th>
                            <td>{{ $proposal->end_date->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Location</th>
                            <td>{{ $proposal->location ?? 'N/A' }}</td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Description</h5>
                </div>
                <div class="card-body">
                    {!! nl2br(e($proposal->description)) !!}
                </div>
            </div>
        </div>
    </div>



    @if($proposal->status == 'pending')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-check-circle me-2"></i>Review Proposal</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.proposals.update-status', $proposal->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Decision</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="statusApprove" value="approved" required>
                                        <label class="form-check-label" for="statusApprove">Approve</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="statusReject" value="rejected">
                                        <label class="form-check-label" for="statusReject">Reject</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3" id="rejectionReasonContainer" style="display: none;">
                                <label for="rejection_reason" class="form-label">Rejection Reason</label>
                                <textarea class="form-control" name="rejection_reason" id="rejection_reason" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Submit Decision
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusRadios = document.querySelectorAll('input[name="status"]');
        const rejectionReasonContainer = document.getElementById('rejectionReasonContainer');
        
        statusRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'rejected') {
                    rejectionReasonContainer.style.display = 'block';
                } else {
                    rejectionReasonContainer.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush
@endsection
