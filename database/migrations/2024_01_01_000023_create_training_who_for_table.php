<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('training_who_for', function (Blueprint $table) {
            $table->id();
            $table->string('label', 150);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('training_who_for')->insert([
            ['label' => 'Aspiring Estheticians',        'sort_order' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['label' => 'Beauty & Wellness Enthusiasts', 'sort_order' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['label' => 'Salon & Spa Professionals',     'sort_order' => 3, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['label' => 'Entrepreneurs',                 'sort_order' => 4, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('training_who_for');
    }
};
