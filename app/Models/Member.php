<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', 
        'name', 
        'nik', 
        'email', 
        'phone_number', 
        'address', 
        'date_of_birth', 
        'place_of_birth', 
        'gender', 
        'photo', 
        'district_id', 
        'registration_date', 
        'expiry_date',
        'status',
        'approval_status',
        'approved_by',
        'approval_notes',
        'user_id'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'registration_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }
    
    /**
     * Get the user associated with the member.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Check if the member has a user account.
     */
    public function hasAccount()
    {
        return $this->user()->exists();
    }
}
