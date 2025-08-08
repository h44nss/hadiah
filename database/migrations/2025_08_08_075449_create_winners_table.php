<?php
// database/migrations/2024_01_01_000004_create_winners_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('winners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('draw_id')->constrained()->onDelete('cascade');
            $table->foreignId('participant_id')->constrained()->onDelete('cascade');
            $table->integer('position');
            $table->timestamp('drawn_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('winners');
    }
};
