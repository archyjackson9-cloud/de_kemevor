<?php

namespace Database\Seeders;

use App\Models\AboutCertification;
use App\Models\AboutValue;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class PageSettingsSeeder extends Seeder
{
    public function run(): void
    {
        // ── About Page Settings ──────────────────────────────────────────
        $aboutSettings = [
            'about_hero_eyebrow'  => 'Our Story',
            'about_hero_title'    => 'About The Healing Room',
            'about_hero_sub'      => 'A sanctuary built on expertise, compassion, and results.',
            'about_hero_type'     => 'none',
            'about_hero_media'    => null,

            'about_story_eyebrow' => 'How It All Began',
            'about_story_title'   => 'Our Clinic Story',
            'about_story_body'    => "The Healing Room was born out of a simple but powerful conviction: every person deserves access to world-class aesthetic and wellness care — delivered with dignity, expertise, and genuine compassion.\n\nFounded in the heart of Accra, Ghana, our clinic was created to bridge the gap between luxury wellness and accessible, evidence-based care. We noticed that many women and men were navigating post-partum recovery, skin concerns, and body confidence issues without the professional support they truly needed.\n\nToday, The Healing Room has become a trusted sanctuary for hundreds of clients across Ghana — from new mothers reclaiming their bodies after childbirth, to professionals investing in their skin health, to individuals seeking discreet, transformative rejuvenation treatments.",

            'about_stat_1_num'   => '500+',
            'about_stat_1_label' => 'Happy Clients',
            'about_stat_2_num'   => '3+',
            'about_stat_2_label' => 'Years Experience',
            'about_stat_3_num'   => '14+',
            'about_stat_3_label' => 'Treatments',
            'about_stat_4_num'   => '98%',
            'about_stat_4_label' => 'Satisfaction Rate',

            'about_mission'   => 'To restore and maintain the confidence of every client through premium, personalized esthetic treatments — delivered in a safe, private, and empowering environment.',

            'about_cta_title' => 'Ready to Begin Your Journey?',
            'about_cta_sub'   => 'Book a consultation and let our team create a personalized treatment plan for you.',
        ];

        foreach ($aboutSettings as $key => $value) {
            SiteSetting::firstOrCreate(['key' => $key], ['value' => $value]);
        }

        // ── Contact Page Settings ─────────────────────────────────────────
        $contactSettings = [
            'contact_hero_eyebrow' => "We're Here For You",
            'contact_hero_title'   => 'Get In Touch',
            'contact_hero_sub'     => "Questions? We'd love to hear from you. Send us a message or give us a call.",
            'contact_hero_type'    => 'none',
            'contact_hero_media'   => null,

            'contact_phone'    => '0597173323',
            'contact_website'  => 'https://www.thehealingroom.com',
            'contact_location' => 'Accra, Ghana',
            'contact_hours'    => "Mon – Fri: 8:00 AM – 7:00 PM\nSaturday: 9:00 AM – 5:00 PM\nSunday: 10:00 AM – 3:00 PM",

            'contact_ig_handle' => '@thehealing_room26',
            'contact_ig_url'    => 'https://instagram.com/thehealing_room26',
            'contact_tt_handle' => '@thehealing_room26',
            'contact_tt_url'    => 'https://tiktok.com/@thehealing_room26',
            'contact_fb_handle' => '@thehealing_room',
            'contact_fb_url'    => 'https://facebook.com/thehealing_room',
            'contact_sc_handle' => '@thehealingroom2',
            'contact_sc_url'    => 'https://snapchat.com/add/thehealingroom2',

            'contact_map_embed' => null,
        ];

        foreach ($contactSettings as $key => $value) {
            SiteSetting::firstOrCreate(['key' => $key], ['value' => $value]);
        }

        // ── Core Values ───────────────────────────────────────────────────
        $values = [
            ['number' => '01', 'title' => 'Compassion First',          'body' => 'Every client who walks through our doors is treated with warmth, empathy, and respect — no judgment, ever.',                                                                                      'sort_order' => 1],
            ['number' => '02', 'title' => 'Evidence-Based Excellence', 'body' => 'We only use treatments backed by science. Our protocols are continuously updated with the latest in aesthetic medicine.',                                                                         'sort_order' => 2],
            ['number' => '03', 'title' => 'Radical Transparency',      'body' => 'We tell you exactly what to expect, what\'s in our products, and what results are realistic — always honest, always clear.',                                                                      'sort_order' => 3],
            ['number' => '04', 'title' => 'Inclusive Beauty',          'body' => 'Beauty and wellness have no one face. We celebrate and serve all skin tones, body types, genders, and backgrounds.',                                                                              'sort_order' => 4],
        ];

        foreach ($values as $v) {
            AboutValue::firstOrCreate(
                ['title' => $v['title']],
                array_merge($v, ['is_active' => true])
            );
        }

        // ── Certifications ────────────────────────────────────────────────
        $certs = [
            ['icon' => 'fa-certificate',   'label' => 'Certified Aesthetic Practitioners',       'sort_order' => 1],
            ['icon' => 'fa-shield-alt',    'label' => 'Ghana Health Service Registered',         'sort_order' => 2],
            ['icon' => 'fa-star',          'label' => 'International Aesthetics Federation Member', 'sort_order' => 3],
            ['icon' => 'fa-leaf',          'label' => 'Organic & Safe-Product Certified',        'sort_order' => 4],
            ['icon' => 'fa-graduation-cap','label' => 'Continuing Education Certified',          'sort_order' => 5],
        ];

        foreach ($certs as $c) {
            AboutCertification::firstOrCreate(
                ['label' => $c['label']],
                array_merge($c, ['is_active' => true])
            );
        }
    }
}
