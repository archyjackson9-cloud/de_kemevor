<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('quote');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Seed with the clinic's current testimonial copy so the home page
        // keeps showing content immediately after migrating.
        DB::table('testimonials')->insert([
            ['name' => 'Abena M., Accra',       'quote' => 'Absolutely life-changing experience. My skin has never looked better!', 'sort_order' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Efua A., Tema',          'quote' => 'The post-partum care I received here was beyond what I expected. I feel like myself again.', 'sort_order' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kofi B., East Legon',    'quote' => 'Professional, discreet, and incredibly effective. I highly recommend The Healing Room.', 'sort_order' => 3, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ama D., Kumasi',         'quote' => 'The BBL aftercare protocol here is unmatched. Best decision I ever made.', 'sort_order' => 4, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Akosua T., Accra',       'quote' => 'Finally a clinic that treats you with dignity and delivers real results.', 'sort_order' => 5, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Yaa O., Takoradi',       'quote' => 'My acne cleared up in just 4 sessions. I cried tears of joy!', 'sort_order' => 6, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
