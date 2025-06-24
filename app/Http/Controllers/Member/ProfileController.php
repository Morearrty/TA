<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display the member's profile.
     */
    public function index()
    {
        $user = Auth::user();
        $member = $user->member;
        
        if (!$member) {
            return redirect()->route('member.dashboard')
                ->with('error', 'Anda tidak memiliki profil anggota yang terkait dengan akun ini.');
        }
        
        return view('member.profile', compact('user', 'member'));
    }
    
    /**
     * Show the form for editing the member's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        $member = $user->member;
        
        if (!$member) {
            return redirect()->route('member.dashboard')
                ->with('error', 'Anda tidak memiliki profil anggota yang terkait dengan akun ini.');
        }
        
        return view('member.edit-profile', compact('user', 'member'));
    }
    
    /**
     * Update the member's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $member = $user->member;
        
        if (!$member) {
            return redirect()->route('member.dashboard')
                ->with('error', 'Anda tidak memiliki profil anggota yang terkait dengan akun ini.');
        }
        
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'phone_number' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'place_of_birth' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'current_password' => 'required|current_password',
            'password' => 'nullable|min:8|confirmed',
        ]);
        
        // Update member data
        $member->name = $request->name;
        $member->email = $request->email;
        $member->phone_number = $request->phone_number;
        $member->date_of_birth = $request->date_of_birth;
        $member->place_of_birth = $request->place_of_birth;
        $member->gender = $request->gender;
        $member->address = $request->address;
        $member->save();
        
        // Update user account information
        $user->name = $request->name;
        $user->email = $request->email;
        
        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        return redirect()->route('member.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }
    
    /**
     * Update the member's profile photo.
     */
    public function updatePhoto(Request $request)
    {
        $user = Auth::user();
        $member = $user->member;
        
        if (!$member) {
            return redirect()->route('member.dashboard')
                ->with('error', 'Anda tidak memiliki profil anggota yang terkait dengan akun ini.');
        }
        
        // Validate the request
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($member->photo && Storage::disk('public')->exists($member->photo)) {
                Storage::disk('public')->delete($member->photo);
            }
            
            // Upload new photo
            $path = $request->file('photo')->store('members', 'public');
            $member->photo = $path;
            $member->save();
            
            return redirect()->route('member.profile')
                ->with('success', 'Foto profil berhasil diperbarui.');
        }
        
        return redirect()->route('member.profile')
            ->with('error', 'Gagal mengupload foto.');
    }
    
    /**
     * Download the member's KTA (Member Card).
     */
    public function downloadKta()
    {
        $user = Auth::user();
        $member = $user->member;
        
        if (!$member) {
            return redirect()->route('member.dashboard')
                ->with('error', 'Anda tidak memiliki profil anggota yang terkait dengan akun ini.');
        }
        
        $pdf = PDF::loadView('anggota.kta-pdf', compact('member'));
        return $pdf->download('KTA-' . $member->member_id . '.pdf');
    }
}
