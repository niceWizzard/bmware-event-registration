<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', static function (Blueprint $table) {
            $table->id();
            $table->string('title', 256);
            $table->string('slug', 256)->unique();
            $table->string('banner')->nullable();
            $table->longText('description')->nullable();
            $table->string('venue', 256);
            $table->string('partner', 256);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->dateTime('registration_start_date');
            $table->dateTime('registration_end_date');
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
