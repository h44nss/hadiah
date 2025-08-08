<?php
// database/migrations/2024_01_01_000005_add_slug_to_events_and_draws.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('slug')->unique()->after('name');
        });

        Schema::table('draws', function (Blueprint $table) {
            $table->string('slug')->after('name');
            $table->index(['event_id', 'slug']);
        });

        // Generate slugs for existing data
        DB::table('events')->get()->each(function ($event) {
            DB::table('events')
                ->where('id', $event->id)
                ->update(['slug' => Str::slug($event->name) . '-' . $event->id]);
        });

        DB::table('draws')->get()->each(function ($draw) {
            DB::table('draws')
                ->where('id', $draw->id)
                ->update(['slug' => Str::slug($draw->name) . '-' . $draw->id]);
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('draws', function (Blueprint $table) {
            $table->dropIndex(['event_id', 'slug']);
            $table->dropColumn('slug');
        });
    }
};
