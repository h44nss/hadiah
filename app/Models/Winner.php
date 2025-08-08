<?php
// app/Models/Winner.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    use HasFactory;

    protected $fillable = [
        'draw_id',
        'participant_id',
        'position',
        'drawn_at'
    ];

    protected $casts = [
        'drawn_at' => 'datetime'
    ];

    public function draw()
    {
        return $this->belongsTo(Draw::class);
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
