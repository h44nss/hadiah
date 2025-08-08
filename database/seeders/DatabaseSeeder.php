<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Draw;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Sample Event
        $event = Event::create([
            'name' => 'Workshop Laravel 2024',
            'description' => 'Workshop pengembangan web dengan Laravel',
            'event_date' => '2024-12-01',
            'status' => 'active',
            'organizer_name' => 'Tech Community',
            'organizer_email' => 'admin@techcommunity.com'
        ]);

        // Sample Participants
        $participants = [
            ['name' => 'John Doe', 'email' => 'john@example.com', 'company' => 'Tech Corp'],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'company' => 'Digital Inc'],
            ['name' => 'Bob Johnson', 'email' => 'bob@example.com', 'company' => 'Web Solutions'],
        ];

        foreach ($participants as $participant) {
            $event->participants()->create($participant);
        }

        // Sample Draw
        Draw::create([
            'event_id' => $event->id,
            'name' => 'Hadiah Utama',
            'description' => 'Laptop Gaming untuk pemenang utama',
            'winner_count' => 1,
        ]);
    }
}
