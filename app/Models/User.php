<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'province_id',
        'regency_id',
        'district_id',
        'role',
        'address',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ===== RELASI =====
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function critiques()
    {
        return $this->hasMany(Critique::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class, 'admin_id');
    }

    public function critiqueHistories()
    {
        return $this->hasMany(CritiqueHistory::class, 'changed_by');
    }

    // ===== AVATAR =====
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/avatars/'.$this->avatar);
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=0d6efd&color=fff&size=100';
    }

    // ===== ROLE METHODS =====
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin()
    {
        return $this->role === 'admin' || $this->role === 'super_admin';
    }

    public function isRegularAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function canManageAdmins()
    {
        return $this->role === 'super_admin';
    }

    public function canCreateSuperAdmin()
    {
        return $this->role === 'super_admin';
    }
}
