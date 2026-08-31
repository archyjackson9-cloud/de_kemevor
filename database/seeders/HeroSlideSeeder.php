<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'image'      => 'https://images.unsplash.com/photo-1600334129128-685c5582fd35?w=1600',
                'eyebrow'    => 'Advanced Aesthetic Clinic · Accra, Ghana',
                'title'      => 'Restore and Maintain',
                'title_gold' => 'Your Confidence',
                'subtitle'   => 'Premium wellness and aesthetic treatments tailored for your unique journey — from post-partum recovery to rejuvenation and beyond.',
                'sort_order' => 1,
            ],
            [
                'image'      => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=1600',
                'eyebrow'    => 'Post-Partum & Recovery Care',
                'title'      => 'Heal, Recover, and',
                'title_gold' => 'Feel Like Yourself Again',
                'subtitle'   => 'Specialized aftercare protocols designed around your body, your recovery, and your timeline.',
                'sort_order' => 2,
            ],
            [
                'image'      => 'https://images.unsplash.com/photo-1519823551278-64ac92734fb1?w=1600',
                'eyebrow'    => 'Skin & Body Treatments',
                'title'      => 'Expert-Led Care,',
                'title_gold' => 'Visible Results',
                'subtitle'   => 'From skin tightening to body contouring, every treatment is tailored to your goals by trained specialists.',
                'sort_order' => 3,
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::firstOrCreate(
                ['sort_order' => $slide['sort_order']],
                array_merge($slide, ['is_active' => true])
            );
        }
    }
}
