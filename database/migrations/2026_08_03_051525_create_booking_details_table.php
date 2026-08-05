<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('court_id')->constrained()->restrictOnDelete();
            $table->date('booking_date')->index();
            $table->foreignId('time_slot_id')->constrained()->restrictOnDelete();
            $table->timestamps();

            $table->index(['court_id', 'booking_date', 'time_slot_id'], 'booking_details_lookup_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_details');
    }
};
