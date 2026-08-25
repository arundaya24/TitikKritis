<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Critique extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'province_id',
        'regency_id',
        'district_id',
        'government_level',
        'title',
        'content',
        'image',
        'is_anonymous',
        'status',
        'admin_note',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'is_anonymous' => 'boolean',
            'submitted_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

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

    public function histories()
    {
        return $this->hasMany(CritiqueHistory::class);
    }

    public function response()
    {
        return $this->hasOne(Response::class);
    }

    public function getSubmitterNameAttribute()
    {
        if ($this->is_anonymous) {
            return 'Anonim';
        }
        return $this->user->name;
    }

    public function getSubmitterUsernameAttribute()
    {
        if ($this->is_anonymous) {
            return 'anonim';
        }
        return $this->user->username;
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByGovernmentLevel($query, $level)
    {
        return $query->where('government_level', $level);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }
}
