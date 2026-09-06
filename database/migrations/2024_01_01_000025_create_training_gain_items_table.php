<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('training_gain_items', function (Blueprint $table) {
            $table->id();
            $table->string('icon', 50)->default('fa-star');
            $table->string('title', 100);
            $table->text('body');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('training_gain_items')->insert([
            ['icon' => 'fa-graduation-cap', 'title' => 'Expert-Led Training',       'body' => 'Learn from experienced professionals who bring real clinical practice into every lesson.', 'sort_order' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['icon' => 'fa-hands-holding',  'title' => 'Hands-On Practice',          'body' => 'Real techniques, real results — you will practice on real skin under expert supervision.', 'sort_order' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['icon' => 'fa-certificate',    'title' => 'Industry-Recognized Skills', 'body' => 'Build competence that clients can trust, backed by a certificate upon completion.', 'sort_order' => 3, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['icon' => 'fa-chart-line',     'title' => 'Career Support',             'body' => 'Guidance to help you grow and succeed long after your final assessment.', 'sort_order' => 4, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('training_gain_items');
    }
};
