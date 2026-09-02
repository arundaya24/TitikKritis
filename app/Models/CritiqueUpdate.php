<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CritiqueUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'critique_id',
        'user_id',
        'old_status',
        'new_status',
    ];

    public function critique()
    {
        return $this->belongsTo(Critique::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->hasMany(CritiqueUpdateFile::class);
    }
}
