<?php
// app/Models/Participant.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'email',
        'phone',
        'company',
        'notes'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function winners()
    {
        return $this->hasMany(Winner::class);
    }
}
