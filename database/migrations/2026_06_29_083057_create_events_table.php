<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('description')->nullable();
            $table->string('venue');
            $table->string('entertainment')->nullable();
            $table->string('image')->nullable();
            $table->string('dietary_info')->nullable();
            $table->string('ticket_prices')->nullable();
            
            // Event Date & Time (For Countdown)
            $table->date('event_date');
            $table->time('event_time')->nullable();
            $table->dateTime('countdown_end');

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
