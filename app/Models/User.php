<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'member_id',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    /**
     * Get the member associated with the user.
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // Konstanta untuk peran user
    const ROLE_ADMIN = 'admin';
    const ROLE_DISTRICT_ADMIN = 'district_admin';
    const ROLE_MEMBER = 'member';
    
    /**
     * Check if the user is an admin.
     */
    public function isAdmin()
    {
        return $this->is_admin == true;
    }
    
    /**
     * Check if the user is a district admin.
     */
    public function isDistrictAdmin()
    {
        return $this->role == self::ROLE_DISTRICT_ADMIN;
    }
    
    /**
     * Check if the user is a regular member.
     */
    public function isMember()
    {
        return $this->role == self::ROLE_MEMBER && !$this->is_admin;
    }
    
    /**
     * Get the user's role display name.
     */
    public function getRoleDisplayName()
    {
        if ($this->is_admin) {
            return 'Admin Utama';
        } elseif ($this->role == self::ROLE_DISTRICT_ADMIN) {
            return 'Admin Distrik';
        } else {
            return 'Anggota';
        }
    }
}
