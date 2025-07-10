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
        Schema::create('event_registrations', static function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 256);
            $table->string('last_name', 256);
            $table->string('email', 256);
            $table->string('mobile_number', 12);
            $table->string('gender', 10);
            $table->string('company', 256)->nullable();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
