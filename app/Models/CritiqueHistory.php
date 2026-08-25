<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CritiqueHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'critique_id',
        'old_status',
        'new_status',
        'changed_by',
        'note',
    ];

    public function critique()
    {
        return $this->belongsTo(Critique::class);
    }

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
