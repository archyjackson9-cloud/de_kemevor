<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->enum('gender', ['female', 'male', 'prefer_not_to_say'])->default('prefer_not_to_say');
            $table->date('date_of_birth')->nullable();
            $table->text('health_notes')->nullable();
            $table->integer('loyalty_points')->default(0);
            $table->enum('discount_tier', ['none', 'new_client', 'loyal', 'special'])->default('new_client');
            $table->integer('total_bookings')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
