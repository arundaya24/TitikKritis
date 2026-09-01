<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CritiqueUpdate extends Model
{
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
