<?php

namespace App\Http\Controllers\DistrictAdmin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\ActivityProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Tambahkan ini
use Illuminate\Validation\Rule; 

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
        $admin = auth()->user();
        return view('district_admin.profile', compact('admin'));
    }
     public function editProfile()
    {
        $admin = auth()->user();
        return view('district_admin.edit_profile', compact('admin'));
    }
     public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'current_password' => 'nullable|required_with:password|current_password',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'current_password.current_password' => 'Password saat ini tidak cocok.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Juga update nama di data member yang terkait
        if ($user->member) {
            $user->member->name = $request->name;
            $user->member->email = $request->email;
            $user->member->save();
        }

        return redirect()->route('district.admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }

}
