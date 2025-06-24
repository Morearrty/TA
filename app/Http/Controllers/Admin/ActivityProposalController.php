<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityProposal;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityProposalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    
    /**
     * Display a listing of the activity proposals.
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');
        $district_id = $request->input('district_id');
        
        $query = ActivityProposal::with(['district', 'approver']);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        if ($district_id) {
            $query->where('district_id', $district_id);
        }
        
        $proposals = $query->latest()->paginate(10);
        $districts = District::all();
        
        return view('admin.proposals.index', compact('proposals', 'districts', 'status', 'district_id'));
    }
    
    /**
     * Show the specified activity proposal.
     */
    public function show(ActivityProposal $proposal)
    {
        return view('admin.proposals.show', compact('proposal'));
    }
    
    /**
     * Update the status of the activity proposal.
     */
    public function updateStatus(Request $request, ActivityProposal $proposal)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'required_if:status,rejected',
        ]);
        
        $proposal->status = $validated['status'];
        
        if ($validated['status'] === 'approved') {
            $proposal->approved_by = Auth::id();
            $proposal->approval_date = now();
            $proposal->rejection_reason = null;
        } else {
            $proposal->rejection_reason = $validated['rejection_reason'];
            $proposal->approved_by = null;
            $proposal->approval_date = null;
        }
        
        $proposal->save();
        
        return redirect()->route('admin.proposals.show', $proposal->id)
            ->with('success', 'Proposal status updated successfully.');
    }
}
