<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityProposal extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'district_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'target_participants',
        'attachments',
        'status',
        'rejection_reason',
        'approved_by',
        'approval_date',
        'created_by',
        'submitted_at'
    ];
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approval_date' => 'date',
        'submitted_at' => 'datetime',
    ];
    
    /**
     * Get the district that owns the activity proposal.
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    
    /**
     * Get the user who approved the activity proposal.
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    
    /**
     * Scope a query to only include pending proposals.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    
    /**
     * Scope a query to only include approved proposals.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
    
    /**
     * Scope a query to only include rejected proposals.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
    
    /**
     * Check if the proposal is pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }
    
    /**
     * Check if the proposal is approved.
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }
    
    /**
     * Check if the proposal is rejected.
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
