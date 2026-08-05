<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('court_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('court_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week');
            $table->foreignId('time_slot_id')->constrained()->restrictOnDelete();
            $table->boolean('is_open')->default(true);
            $table->timestamps();

            $table->unique(['court_id', 'day_of_week', 'time_slot_id'], 'court_schedule_unique_slot');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('court_schedules');
    }
};
