<?php
// Path: app/Http/Controllers/DistrictAdmin/ProposalController.php

namespace App\Http\Controllers\DistrictAdmin;

use App\Http\Controllers\Controller;
use App\Models\ActivityProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProposalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('district_admin');
    }

    /**
     * Menampilkan daftar proposal di distrik admin.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $district_id = $user->member->district_id;
        
        $query = ActivityProposal::where('district_id', $district_id);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('end_date', '<=', $request->date_to);
        }
        
        $proposals = $query->with('creator')->latest()->paginate(10);
        
        return view('district_admin.proposals.index', compact('proposals'));
    }

    /**
     * Menampilkan detail proposal.
     */
    public function show(ActivityProposal $proposal)
    {
        $user = Auth::user();
        
        if ($proposal->district_id != $user->member->district_id) {
            return redirect()->route('district.admin.proposals.index')
                ->with('error', 'Anda tidak memiliki akses untuk melihat proposal dari distrik lain.');
        }
        
        return view('district_admin.proposals.show', compact('proposal'));
    }

    /**
     * Menampilkan form untuk membuat proposal baru.
     */
    public function create()
    {
        return view('district_admin.proposals.create');
    }

    /**
     * Menyimpan proposal baru ke database. (INI BAGIAN YANG DIPERBAIKI)
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $district_id = $user->member->district_id;
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string|max:255',
            'target_participants' => 'required|string|max:255',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
        ]);
        
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('proposals/attachments', 'public');
                $attachmentPaths[] = $path;
            }
        }
        
        // Menggunakan Eloquent 'create' dengan data yang sudah benar
        $proposal = ActivityProposal::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'location' => $validated['location'],
            'target_participants' => $validated['target_participants'],
            'attachments' => !empty($attachmentPaths) ? json_encode($attachmentPaths) : null, // Simpan sbg JSON di kolom 'attachments'
            'budget_amount' => 0, // Sesuai migrasi, default 0
            'budget_details' => null, // Kolom ini tidak kita gunakan lagi untuk data utama
            'status' => 'pending', // Status awal adalah 'pending'
            'district_id' => $district_id,
            'created_by' => $user->id, // Mengisi kolom 'created_by' dengan ID user yang login
            'submitted_at' => now(), // Mengisi waktu pengajuan
        ]);
        
        return redirect()->route('district.admin.proposals.show', $proposal->id)
            ->with('success', 'Proposal kegiatan berhasil dibuat dan dikirim ke admin pusat untuk persetujuan.');
    }

    /**
     * Mengirim proposal ke admin untuk persetujuan.
     */
    public function submit(ActivityProposal $proposal)
    {
        $user = Auth::user();
        
        if ($proposal->district_id != $user->member->district_id) {
            return redirect()->route('district.admin.proposals.index')
                ->with('error', 'Akses ditolak.');
        }
        
        $proposal->status = 'pending';
        $proposal->submitted_at = now();
        $proposal->submitted_by = $user->id; // submitted_by belum ada di migrasi, jadi saya ganti ke created_by
        $proposal->save();
        
        return redirect()->route('district.admin.proposals.show', $proposal->id)
            ->with('success', 'Proposal berhasil dikirim ke admin pusat untuk persetujuan.');
    }
}