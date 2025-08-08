<?php
// app/Models/Draw.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Draw extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'slug',
        'description',
        'image',
        'winner_count',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($draw) {
            $draw->slug = Str::slug($draw->name) . '-' . time();
        });
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function winners()
    {
        return $this->hasMany(Winner::class);
    }
}
