<?php

namespace App\Http\Controllers\DistrictAdmin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\ActivityProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('district_admin');
    }
    
    /**
     * Display the district admin dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $district_id = $user->member->district_id;
        
        // Get district members count
        $membersCount = Member::where('district_id', $district_id)->count();
        
        // Get pending proposals count
        $pendingProposalsCount = ActivityProposal::where('district_id', $district_id)
            ->where('status', 'pending')
            ->count();
        
        // Get approved proposals count
        $approvedProposalsCount = ActivityProposal::where('district_id', $district_id)
            ->where('status', 'approved')
            ->count();
        
        // Get latest members
        $latestMembers = Member::where('district_id', $district_id)
            ->latest()
            ->take(5)
            ->get();
        
        // Get latest proposals
        $latestProposals = ActivityProposal::where('district_id', $district_id)
            ->latest()
            ->take(5)
            ->get();
        
        return view('district_admin.dashboard', compact(
            'membersCount', 
            'pendingProposalsCount', 
            'approvedProposalsCount',
            'latestMembers',
            'latestProposals'
        ));
    }

    public function profile()
    {
        $admin = auth()->user(); // asumsikan ini adalah admin distrik
        return view('district_admin.profile', compact('admin'));
    }
}
