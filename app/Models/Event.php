<?php
// app/Models/Event.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'event_date',
        'status',
        'organizer_name',
        'organizer_email',
        'image', // tambahkan field image
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            $event->slug = Str::slug($event->name) . '-' . time();
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $casts = [
        'event_date' => 'date'
    ];

    public function draws()
    {
        return $this->hasMany(Draw::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }
}
