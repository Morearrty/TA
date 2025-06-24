<?php

namespace App\Http\Controllers\DistrictAdmin;

use App\Http\Controllers\Controller;
use App\Models\ActivityProposal;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProposalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('district_admin');
    }
    
    /**
     * Display a listing of proposals in the district.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $district_id = $user->member->district_id;
        
        $query = ActivityProposal::where('district_id', $district_id);
        
        // Handle status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Handle date filter
        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('end_date', '<=', $request->date_to);
        }
        
        $proposals = $query->latest()->paginate(10);
        
        return view('district_admin.proposals.index', compact('proposals'));
    }
    
    /**
     * Display the specified proposal.
     */
    public function show(ActivityProposal $proposal)
    {
        $user = Auth::user();
        $district_id = $user->member->district_id;
        
        // Ensure the proposal belongs to the admin's district
        if ($proposal->district_id != $district_id) {
            return redirect()->route('district.admin.proposals.index')
                ->with('error', 'Anda tidak memiliki akses untuk melihat proposal dari distrik lain.');
        }
        
        return view('district_admin.proposals.show', compact('proposal'));
    }
    
    /**
     * Show the form for creating a new proposal.
     */
    public function create()
    {
        return view('district_admin.proposals.create');
    }
    
    /**
     * Store a newly created proposal in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $district_id = $user->member->district_id;
        
        // Validate the request
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
        
        // Tidak ada anggaran biaya yang perlu diproses
        
        // Process attachments
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('proposals/attachments', 'public');
                $attachmentPaths[] = $path;
            }
        }
        
        // Gunakan pendekatan dengan DB Query Builder untuk mengatasi masalah default value
        $proposalData = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'location' => $validated['location'],
            'budget_amount' => 0, // Tetapkan budget_amount ke 0
            'budget_details' => json_encode([
                'target_participants' => $validated['target_participants'],
                'attachments' => !empty($attachmentPaths) ? $attachmentPaths : [],
            ]),
            'status' => 'pending',
            'district_id' => $district_id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        // Gunakan DB::table untuk insert data langsung
        $proposalId = DB::table('activity_proposals')->insertGetId($proposalData);
        
        // Ambil proposal yang baru dibuat
        $proposal = ActivityProposal::findOrFail($proposalId);
        
        return redirect()->route('district.admin.proposals.show', $proposal->id)
            ->with('success', 'Proposal kegiatan berhasil dibuat dan dikirim ke admin pusat untuk persetujuan.');
    }
    
    /**
     * Submit proposal to admin for approval.
     */
    public function submit(ActivityProposal $proposal)
    {
        $user = Auth::user();
        $district_id = $user->member->district_id;
        
        // Ensure the proposal belongs to the admin's district
        if ($proposal->district_id != $district_id) {
            return redirect()->route('district.admin.proposals.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengirim proposal dari distrik lain.');
        }
        
        // Update proposal status to pending for admin review
        $proposal->status = 'pending';
        $proposal->submitted_at = now();
        $proposal->submitted_by = $user->id;
        $proposal->save();
        
        return redirect()->route('district.admin.proposals.show', $proposal->id)
            ->with('success', 'Proposal berhasil dikirim ke admin pusat untuk persetujuan.');
    }
}
