<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('training_phases', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('phase_number')->default(1);
            $table->string('title', 150);
            $table->string('subtitle', 200)->nullable();
            $table->text('description')->nullable();
            $table->text('topics')->nullable(); // one topic per line
            $table->string('image')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Seed with the clinic's current Esthetic Training Program curriculum
        // so the Training page has real content immediately after migrating.
        DB::table('training_phases')->insert([
            [
                'phase_number' => 1, 'title' => 'Mindset & Safety',
                'subtitle' => 'Before anyone touches a client',
                'description' => 'Every great esthetician starts with the right foundation. This phase builds the professional mindset, ethics, and safety habits that protect both you and your future clients.',
                'topics' => "Professional ethics in esthetics\nHygiene, sanitation and safety",
                'sort_order' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'phase_number' => 2, 'title' => 'Core Science',
                'subtitle' => 'The "why" behind everything else',
                'description' => 'Understanding the skin is the foundation of every treatment you will ever perform. This phase covers the anatomy, physiology, and science that inform every decision you make in the treatment room.',
                'topics' => "Skin anatomy and physiology\nThe science of a healthy skin\nDifferent skin types and conditions",
                'sort_order' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'phase_number' => 3, 'title' => 'Client-Facing Skills',
                'subtitle' => 'Before hands-on technique',
                'description' => 'Technical skill means little without the ability to listen, assess, and communicate. This phase prepares you to confidently manage real client relationships from the very first consultation.',
                'topics' => "Client care and communication\nSkin analysis and consultation\nContraindications and precautions",
                'sort_order' => 3, 'is_active' => true, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'phase_number' => 4, 'title' => 'Hands-On Technique, Step by Step',
                'subtitle' => null,
                'description' => 'Now it is time to put theory into practice. Under expert supervision, you will perform real treatments on real skin, building the muscle memory and confidence that separates trained professionals from amateurs.',
                'topics' => "Advanced cleansing and explanation\nSteaming and impurity extraction",
                'sort_order' => 4, 'is_active' => true, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'phase_number' => 5, 'title' => 'Ingredient & Product Knowledge',
                'subtitle' => 'Needed before they can choose a mask/serum intelligently',
                'description' => 'A great esthetician is also a trusted product advisor. This phase builds the ingredient literacy you need to recommend the right products for every skin type and concern.',
                'topics' => "Ingredients and their benefits\nSkin types and the acids\nProfessional products knowledge",
                'sort_order' => 5, 'is_active' => true, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'phase_number' => 6, 'title' => 'Applying It',
                'subtitle' => null,
                'description' => 'With the science and the products understood, you will now bring it all together — applying masks and serums with precision and following complete, professional treatment protocols.',
                'topics' => "Facial mask and serum application\nTreatment protocols",
                'sort_order' => 6, 'is_active' => true, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'phase_number' => 7, 'title' => 'Beyond the Treatment Room',
                'subtitle' => null,
                'description' => 'Great technique builds a career only when paired with great business sense. This final phase equips you to manage clients, run a practice, and grow a sustainable future in esthetics.',
                'topics' => "Business and client management\nCareer growth and opportunities",
                'sort_order' => 7, 'is_active' => true, 'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('training_phases');
    }
};
