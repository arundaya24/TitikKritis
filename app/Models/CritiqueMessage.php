<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CritiqueMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'critique_id',
        'user_id',
        'message',
    ];

    public function critique()
    {
        return $this->belongsTo(Critique::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
