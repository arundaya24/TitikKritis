<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'regency_id',
        'name',
    ];

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function critiques()
    {
        return $this->hasMany(Critique::class);
    }
}
