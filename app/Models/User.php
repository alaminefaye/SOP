<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\ComplianceRecord;
use App\Models\Procedure;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is super admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if user is manager.
     */
    public function isManager(): bool
    {
        return $this->role === 'manager' || $this->isSuperAdmin();
    }

    /**
     * Check if user can approve procedures.
     */
    public function canApprove(): bool
    {
        return in_array($this->role, ['super_admin', 'manager']);
    }

    /**
     * Check if user can create procedures.
     */
    public function canCreate(): bool
    {
        // Allow all authenticated users to create for now, or check role
        if (!$this->role) {
            return true; // Default allow if role not set
        }
        return in_array($this->role, ['super_admin', 'manager', 'chef_cuisine', 'chef_service', 'formateur', 'employee']);
    }

    /**
     * Get the compliance records for the user.
     */
    public function complianceRecords()
    {
        return $this->hasMany(ComplianceRecord::class);
    }

    /**
     * Get the procedures created by the user.
     */
    public function procedures()
    {
        return $this->hasMany(Procedure::class, 'created_by');
    }
}
