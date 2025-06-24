<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::with('district');
        
        // Handle search and filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('member_id', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('approval_status')) {
            $query->where('approval_status', $request->approval_status);
        }
        // Don't filter by approval status by default so all members are visible
        
        $members = $query->latest()->paginate(10);
        $districts = District::all();
        
        return view('admin.members.index', compact('members', 'districts'));
    }

    public function create()
    {
        $districts = District::all();
        return view('admin.members.create', compact('districts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:members,nik',
            'email' => 'required|email|unique:members,email',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'place_of_birth' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'photo' => 'nullable|image|max:2048',
            'district_id' => 'required|exists:districts,id',
        ]);

        // Generate member ID
        $district = District::findOrFail($validated['district_id']);
        $count = Member::where('district_id', $validated['district_id'])->count() + 1;
        $member_id = $district->code . '-' . str_pad($count, 5, '0', STR_PAD_LEFT);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('members', 'public');
            $validated['photo'] = $path;
        }

        // Set registration and expiry dates
        $registrationDate = now();
        $expiryDate = now()->addYears(5);
        
        // Create member
        $member = Member::create([
            'member_id' => $member_id,
            'name' => $validated['name'],
            'nik' => $validated['nik'],
            'email' => $validated['email'],
            'registration_password' => $validated['password'], // Store original password
            'phone_number' => $validated['phone_number'] ?? null,
            'address' => $validated['address'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'place_of_birth' => $validated['place_of_birth'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'photo' => $validated['photo'] ?? null,
            'district_id' => $validated['district_id'],
            'registration_date' => $registrationDate,
            'expiry_date' => $expiryDate,
            'status' => 'active',
            'approval_status' => 'approved'
        ]);
        
        // Create user account automatically
        $user = new User();
        $user->name = $member->name;
        $user->email = $member->email;
        $user->password = Hash::make($validated['password']);
        $user->is_admin = false;
        $user->member_id = $member->id;
        $user->save();
        
        // Update member with user ID
        $member->user_id = $user->id;
        $member->save();

        return redirect()->route('admin.members.index')->with('success', 'Member created successfully');
    }

    public function show(Member $member)
    {
        return view('admin.members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        $districts = District::all();
        return view('admin.members.edit', compact('member', 'districts'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:members,nik,' . $member->id,
            'email' => 'nullable|email|unique:members,email,' . $member->id,
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'place_of_birth' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'photo' => 'nullable|image|max:2048',
            'district_id' => 'required|exists:districts,id',
            'status' => 'required|in:active,inactive',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }
            $path = $request->file('photo')->store('members', 'public');
            $validated['photo'] = $path;
        }

        $member->update([
            'name' => $validated['name'],
            'nik' => $validated['nik'],
            'email' => $validated['email'] ?? null,
            'phone_number' => $validated['phone_number'] ?? null,
            'address' => $validated['address'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'place_of_birth' => $validated['place_of_birth'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'district_id' => $validated['district_id'],
            'status' => $validated['status']
        ]);

        if (isset($validated['photo'])) {
            $member->photo = $validated['photo'];
            $member->save();
        }

        return redirect()->route('admin.members.index')->with('success', 'Member updated successfully');
    }

    public function destroy(Member $member)
    {
        // Delete photo if exists
        if ($member->photo) {
            Storage::disk('public')->delete($member->photo);
        }

        $member->delete();
        return redirect()->route('admin.members.index')->with('success', 'Member deleted successfully');
    }

    public function downloadKta(Member $member)
    {
        $pdf = PDF::loadView('anggota.kta-pdf', compact('member'));
        return $pdf->download('KTA-' . $member->member_id . '.pdf');
    }

    /**
     * Display a listing of the pending members.
     */
    public function pendingApproval()
    {
        $pendingMembers = Member::with('district')
            ->where('approval_status', 'pending')
            ->latest()
            ->paginate(10);
            
        return view('admin.members.pending', compact('pendingMembers'));
    }
    
    /**
     * Approve a pending member registration.
     */
    public function approve(Member $member)
    {
        if ($member->approval_status !== 'pending') {
            return redirect()->route('admin.members.pending')
                ->with('error', 'Member is not pending approval.');
        }
        
        // Update member status
        $member->approval_status = 'approved';
        $member->approved_by = auth()->id();
        $member->approved_at = now();
        $member->status = 'active';
        $member->save();
        
        // Create user account for the approved member using password from registration
        $user = new User();
        $user->name = $member->name;
        $user->email = $member->email;
        
        // Use the password that was set during registration instead of creating a new one
        // Check if registration_password exists, otherwise create a default password
        if ($member->registration_password) {
            // Hash the raw password that was stored during registration
            $user->password = Hash::make($member->registration_password);
        } else {
            // Create default password if registration_password is not available
            $defaultPassword = 'member' . $member->id . 'pass';
            $user->password = Hash::make($defaultPassword);
        }
        
        $user->is_admin = false;
        $user->member_id = $member->id; // Set the member_id on the user model
        $user->save();
        
        // Also update the member with the user ID for bidirectional relationship
        $member->user_id = $user->id;
        $member->save();
        
        // Send notification to the member with login credentials
        // Note: You would implement email notification here
        
        return redirect()->route('admin.members.pending')
            ->with('success', "Member {$member->name} has been approved successfully.");
    }
    
    /**
     * Reject a pending member registration.
     */
    public function reject(Request $request, Member $member)
    {
        if ($member->approval_status !== 'pending') {
            return redirect()->route('admin.members.pending')
                ->with('error', 'Member is not pending approval.');
        }
        
        // Validate rejection notes
        $request->validate([
            'approval_notes' => 'required|string|max:500'
        ]);
        
        // Update member status
        $member->approval_status = 'rejected';
        $member->approved_by = auth()->id();
        $member->approval_notes = $request->approval_notes;
        $member->save();
        
        // Could add email notification here
        
        return redirect()->route('admin.members.pending')
            ->with('success', "Member {$member->name} has been rejected.");
    }
    
    /**
     * Show form to reset a member's password.
     */
    public function showResetPasswordForm(Member $member)
    {
        $hasUserAccount = User::where('member_id', $member->id)->exists();
        return view('admin.members.reset-password', compact('member', 'hasUserAccount'));
    }
    
    /**
     * Reset a member's password.
     */
    public function resetPassword(Request $request, Member $member)
    {
        // Validate the request
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        // Find the related user
        $user = User::where('member_id', $member->id)->first();
        
        // If user account doesn't exist, create one
        if (!$user) {
            // Check if member is approved
            if ($member->approval_status != 'approved') {
                // Auto-approve the member
                $member->approval_status = 'approved';
                $member->approved_by = auth()->id();
                $member->approved_at = now();
                $member->status = 'active';
                $member->save();
            }
            
            // Create new user account
            $user = new User();
            $user->name = $member->name;
            $user->email = $member->email;
            $user->is_admin = false;
            $user->member_id = $member->id;
        }
        
        // Update the password
        $user->password = Hash::make($request->password);
        $user->save();
        
        // Also update the registration_password field in the member record
        $member->registration_password = $request->password;
        
        // Make sure the bidirectional relationship is established
        if (!$member->user_id) {
            $member->user_id = $user->id;
        }
        $member->save();
        
        return redirect()->route('admin.members.index')
            ->with('success', "Password for {$member->name} has been reset successfully.");
    }
    
    /**
     * Update user role (member/district_admin).
     */
    public function updateRole(Request $request, Member $member)
    {
        $request->validate([
            'role' => 'required|in:member,district_admin',
        ]);
        
        // Find the related user
        $user = User::where('member_id', $member->id)->first();
        
        if (!$user) {
            return redirect()->route('admin.members.show', $member->id)
                ->with('error', 'Anggota ini belum memiliki akun user.');
        }
        
        // Update role
        $user->role = $request->role;
        $user->save();
        
        return redirect()->route('admin.members.show', $member->id)
            ->with('success', "Peran {$member->name} telah diubah menjadi " . 
                ($request->role == 'district_admin' ? 'Admin Distrik' : 'Anggota Biasa'));
    }
}
