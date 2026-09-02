<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CritiqueUpdateFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'critique_update_id',
        'file_path',
        'original_name',
        'file_type',
    ];

    public function critiqueUpdate()
    {
        return $this->belongsTo(CritiqueUpdate::class, 'critique_update_id');
    }
}
