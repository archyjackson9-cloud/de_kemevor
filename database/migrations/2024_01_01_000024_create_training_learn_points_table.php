<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('training_learn_points', function (Blueprint $table) {
            $table->id();
            $table->string('text', 200);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('training_learn_points')->insert([
            ['text' => 'Professional ethics, hygiene and safety in a clinical setting',   'sort_order' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['text' => 'Skin anatomy, physiology and how to identify skin types',          'sort_order' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['text' => 'Client consultation, communication and contraindications',         'sort_order' => 3, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['text' => 'Hands-on cleansing, steaming and extraction technique',            'sort_order' => 4, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['text' => 'Ingredient knowledge and professional product selection',          'sort_order' => 5, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['text' => 'Full facial treatment protocols from start to finish',             'sort_order' => 6, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['text' => 'Business fundamentals and building a career in esthetics',         'sort_order' => 7, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('training_learn_points');
    }
};
