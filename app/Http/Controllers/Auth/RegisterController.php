<?php
// Path: app/Http/Controllers/Auth/RegisterController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRegistrationRequest;
use App\Models\District;
use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;

class RegisterController extends Controller
{
    /**
     * Menampilkan halaman form pendaftaran.
     */
    public function create() 
    {
        $districts = District::all();
        // Pastikan file view ini ada di: resources/views/auth/register.blade.php
        return view('auth.register', compact('districts'));
    }

    /**
     * Menyimpan data pendaftaran baru.
     */
    public function store(MemberRegistrationRequest $request)
    {
        $validated = $request->validated();

        $district = District::findOrFail($validated['district_id']);
        $count = Member::where('district_id', $validated['district_id'])->count() + 1;
        $member_id = $district->code . '-' . str_pad($count, 5, '0', STR_PAD_LEFT);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('members', 'public');
            $validated['photo'] = $path;
        }

        $registrationDate = now();
        $expiryDate = now()->addYears(5);

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
            'registration_password' => $validated['password']
        ]);

        return redirect()->route('register.success', $member->id);
    }

    /**
     * Menampilkan halaman sukses setelah pendaftaran.
     */
    public function success($id)
    {
        $member = Member::findOrFail($id);
        // Pastikan file view ini ada di: resources/views/auth/success.blade.php
        return view('auth.success', compact('member'));
    }

    /**
     * Download KTA setelah pendaftaran.
     */
    public function downloadKta($id)
    {
        $member = Member::with('district')->findOrFail($id);
        // Pastikan file view ini ada: resources/views/anggota/kta-pdf.blade.php
        $pdf = Pdf::loadView('anggota.kta-pdf', compact('member'));
        return $pdf->download('KTA-' . $member->member_id . '.pdf');
    }
}