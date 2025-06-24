<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    public function members()
    {
        return $this->hasMany(Member::class);
    }
    
    /**
     * Get the activity proposals for the district.
     */
    public function activityProposals()
    {
        return $this->hasMany(ActivityProposal::class);
    }
    
    /**
     * Get the pending activity proposals for the district.
     */
    public function pendingProposals()
    {
        return $this->activityProposals()->where('status', 'pending');
    }
    
    /**
     * Get the approved activity proposals for the district.
     */
    public function approvedProposals()
    {
        return $this->activityProposals()->where('status', 'approved');
    }
}
