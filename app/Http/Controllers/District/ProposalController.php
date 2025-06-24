<?php

namespace App\Http\Controllers\District;

use App\Http\Controllers\Controller;
use App\Models\ActivityProposal;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the activity proposals for the district.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get the district ID from the user relationship or admin selection
        if ($user->isAdmin()) {
            $district_id = session('selected_district_id');
            if (!$district_id) {
                return redirect()->route('admin.districts.index')
                    ->with('error', 'Please select a district first.');
            }
        } else {
            // Regular user - get district from member relationship
            if (!$user->member || !$user->member->district_id) {
                return redirect()->route('member.dashboard')
                    ->with('error', 'You are not associated with any district.');
            }
            $district_id = $user->member->district_id;
        }
        
        $district = District::findOrFail($district_id);
        $proposals = ActivityProposal::where('district_id', $district_id)
            ->latest()
            ->paginate(10);
            
        return view('district.proposals.index', compact('district', 'proposals'));
    }
    
    /**
     * Show the form for creating a new activity proposal.
     */
    public function create()
    {
        $user = Auth::user();
        
        // Get the district ID from the user relationship or admin selection
        if ($user->isAdmin()) {
            $district_id = session('selected_district_id');
            if (!$district_id) {
                return redirect()->route('admin.districts.index')
                    ->with('error', 'Please select a district first.');
            }
        } else {
            // Regular user - get district from member relationship
            if (!$user->member || !$user->member->district_id) {
                return redirect()->route('member.dashboard')
                    ->with('error', 'You are not associated with any district.');
            }
            $district_id = $user->member->district_id;
        }
        
        $district = District::findOrFail($district_id);
        
        return view('district.proposals.create', compact('district'));
    }
    
    /**
     * Store a newly created activity proposal in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Get the district ID from the user relationship or admin selection
        if ($user->isAdmin()) {
            $district_id = session('selected_district_id');
            if (!$district_id) {
                return redirect()->route('admin.districts.index')
                    ->with('error', 'Please select a district first.');
            }
        } else {
            // Regular user - get district from member relationship
            if (!$user->member || !$user->member->district_id) {
                return redirect()->route('member.dashboard')
                    ->with('error', 'You are not associated with any district.');
            }
            $district_id = $user->member->district_id;
        }
        
        // Validate the input - budget fields removed
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
        ]);
        
        // Create activity proposal - budget fields removed
        $proposal = ActivityProposal::create([
            'district_id' => $district_id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'location' => $validated['location'],
            'budget_amount' => 0, // Set to 0 as default since field is removed
            'budget_details' => '-', // Set to a placeholder since field is removed
            'status' => 'pending',
        ]);
        
        return redirect()->route('district.proposals.show', $proposal->id)
            ->with('success', 'Activity proposal submitted successfully and is pending approval.');
    }
    
    /**
     * Display the specified activity proposal.
     */
    public function show(ActivityProposal $proposal)
    {
        $user = Auth::user();
        
        // Verify the user has access to this proposal
        if (!$user->isAdmin()) {
            if (!$user->member || $user->member->district_id !== $proposal->district_id) {
                return redirect()->route('district.proposals.index')
                    ->with('error', 'You do not have permission to view this proposal.');
            }
        }
        
        return view('district.proposals.show', compact('proposal'));
    }
    
    /**
     * Show the form for editing the specified activity proposal.
     */
    public function edit(ActivityProposal $proposal)
    {
        $user = Auth::user();
        
        // Verify the user has access to this proposal
        if (!$user->isAdmin()) {
            if (!$user->member || $user->member->district_id !== $proposal->district_id) {
                return redirect()->route('district.proposals.index')
                    ->with('error', 'You do not have permission to edit this proposal.');
            }
        }
        
        // Only allow editing if the proposal is still pending
        if ($proposal->status !== 'pending') {
            return redirect()->route('district.proposals.show', $proposal->id)
                ->with('error', 'You cannot edit a proposal that has been ' . $proposal->status . '.');
        }
        
        return view('district.proposals.edit', compact('proposal'));
    }
    
    /**
     * Update the specified activity proposal in storage.
     */
    public function update(Request $request, ActivityProposal $proposal)
    {
        $user = Auth::user();
        
        // Verify the user has access to this proposal
        if (!$user->isAdmin()) {
            if (!$user->member || $user->member->district_id !== $proposal->district_id) {
                return redirect()->route('district.proposals.index')
                    ->with('error', 'You do not have permission to update this proposal.');
            }
        }
        
        // Only allow updating if the proposal is still pending
        if ($proposal->status !== 'pending') {
            return redirect()->route('district.proposals.show', $proposal->id)
                ->with('error', 'You cannot update a proposal that has been ' . $proposal->status . '.');
        }
        
        // Validate the input - budget fields removed
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
        ]);
        
        // Update the proposal - budget fields removed
        $proposal->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'location' => $validated['location'],
        ]);
        
        return redirect()->route('district.proposals.show', $proposal->id)
            ->with('success', 'Activity proposal updated successfully.');
    }
    
    /**
     * Remove the specified activity proposal from storage.
     */
    public function destroy(ActivityProposal $proposal)
    {
        $user = Auth::user();
        
        // Verify the user has access to this proposal
        if (!$user->isAdmin()) {
            if (!$user->member || $user->member->district_id !== $proposal->district_id) {
                return redirect()->route('district.proposals.index')
                    ->with('error', 'You do not have permission to delete this proposal.');
            }
        }
        
        // Only allow deleting if the proposal is still pending
        if ($proposal->status !== 'pending') {
            return redirect()->route('district.proposals.show', $proposal->id)
                ->with('error', 'You cannot delete a proposal that has been ' . $proposal->status . '.');
        }
        
        $proposal->delete();
        
        return redirect()->route('district.proposals.index')
            ->with('success', 'Activity proposal deleted successfully.');
    }
}
