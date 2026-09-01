<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CritiqueUpdateFile extends Model
{
    public function critiqueUpdate()
    {
        return $this->belongsTo(CritiqueUpdate::class, 'critique_update_id');
    }
}
