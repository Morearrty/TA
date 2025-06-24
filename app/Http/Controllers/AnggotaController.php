<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRegistrationRequest;
use App\Models\District;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AnggotaController extends Controller
{
    public function daftar() 
    {
        $districts = District::all();
        return view('anggota.daftar', compact('districts'));
    }

    public function store(MemberRegistrationRequest $request)
    {
        // Get validated data from the form request
        $validated = $request->validated();

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
        
        // Create member with pending approval status
        $member = Member::create([
            'member_id' => $member_id,
            'name' => $validated['name'],
            'nik' => $validated['nik'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'] ?? null,
            'address' => $validated['address'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'place_of_birth' => $validated['place_of_birth'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'photo' => $validated['photo'] ?? null,
            'district_id' => $validated['district_id'],
            'registration_date' => $registrationDate,
            'expiry_date' => $expiryDate,
            'status' => 'inactive',
            'approval_status' => 'pending',
            'registration_password' => $validated['password'] // Save raw password for later hashing during approval
        ]);
        
        // User account will be created after admin approval
        
        // Do not create user account until approved by admin
        // Also don't log them in, as they can't access the system until approved

        return redirect()->route('anggota.success', $member->id);
    }

    public function success($id)
    {
        $member = Member::findOrFail($id);
        return view('anggota.success', compact('member'));
    }

    public function downloadKta($id)
    {
        $member = Member::with('district')->findOrFail($id);
        
        $pdf = PDF::loadView('anggota.kta-pdf', compact('member'));
        return $pdf->download('KTA-' . $member->member_id . '.pdf');
    }
}
