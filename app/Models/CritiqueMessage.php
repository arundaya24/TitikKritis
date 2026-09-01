<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CritiqueMessage extends Model
{
    public function messages()
    {
        return $this->hasMany(CritiqueMessage::class);
    }
}
