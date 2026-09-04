<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('home_values', function (Blueprint $table) {
            $table->id();
            $table->string('icon', 50)->default('fa-star');
            $table->string('title', 100);
            $table->text('body');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Seed with the clinic's current "Why Choose Us" copy so the home page
        // keeps showing content immediately after migrating.
        DB::table('home_values')->insert([
            ['icon' => 'fa-user-md',  'title' => 'Expert Care', 'body' => 'Our certified specialists bring years of clinical expertise and continuous training in the latest aesthetic techniques.', 'sort_order' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['icon' => 'fa-lock',     'title' => 'Privacy & Dignity', 'body' => 'Your privacy is our highest priority. All treatments are conducted in a fully confidential, judgment-free environment.', 'sort_order' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['icon' => 'fa-seedling', 'title' => 'Holistic Approach', 'body' => 'We treat the whole person — body, skin, and confidence — using methods that nurture long-term wellness, not just quick fixes.', 'sort_order' => 3, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['icon' => 'fa-star',     'title' => 'Proven Results', 'body' => 'Our clients see measurable, lasting results. We back our treatments with before-and-after tracking and follow-up support.', 'sort_order' => 4, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('home_values');
    }
};
