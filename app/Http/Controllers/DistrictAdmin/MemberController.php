<?php

namespace App\Http\Controllers\DistrictAdmin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('district_admin');
    }
    
    /**
     * Display a listing of members in the district.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $district_id = $user->member->district_id;
        
        $query = Member::where('district_id', $district_id);
        
        // Handle search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('member_id', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Handle status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $members = $query->latest()->paginate(10);
        
        return view('district_admin.members.index', compact('members'));
    }
    
    /**
     * Display the specified member.
     */
    public function show(Member $member)
    {
        $user = Auth::user();
        $district_id = $user->member->district_id;
        
        // Ensure the member belongs to the admin's district
        if ($member->district_id != $district_id) {
            return redirect()->route('district.admin.members.index')
                ->with('error', 'Anda tidak memiliki akses untuk melihat anggota dari distrik lain.');
        }
        
        return view('district_admin.members.show', compact('member'));
    }
}
