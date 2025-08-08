<?php
// database/migrations/2024_01_01_000001_create_events_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('event_date');
            $table->enum('status', ['active', 'inactive', 'completed'])->default('active');
            $table->string('organizer_name');
            $table->string('organizer_email');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};
