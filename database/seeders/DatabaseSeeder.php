<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\PromoCode;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Database\Seeders\PageSettingsSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Services ────────────────────────────────────────────────
        $services = [
            ['name' => 'Post-Partum Care – C-Section', 'slug' => 'postpartum-csection', 'category' => 'maternity_postop',
             'short_description' => 'Specialized recovery care for mothers after caesarean delivery. We focus on scar healing, abdominal toning, and full-body restoration.',
             'duration' => '90 minutes', 'price_from' => 450.00, 'sort_order' => 1],
            ['name' => 'Post-Partum Care – Natural Birth', 'slug' => 'postpartum-natural', 'category' => 'maternity_postop',
             'short_description' => 'Holistic recovery support for mothers after natural delivery. Includes pelvic floor care, body contouring, and skin rejuvenation.',
             'duration' => '90 minutes', 'price_from' => 380.00, 'sort_order' => 2],
            ['name' => 'Pregnancy Skincare', 'slug' => 'pregnancy-skincare', 'category' => 'maternity_postop',
             'short_description' => 'Safe, bump-friendly skincare treatments designed for expectant mothers. Addresses stretch marks, pigmentation, and hydration.',
             'duration' => '60 minutes', 'price_from' => 300.00, 'sort_order' => 3],
            ['name' => 'Surgery Aftercare', 'slug' => 'surgery-aftercare', 'category' => 'maternity_postop',
             'short_description' => 'Professional post-surgical care to support healing, reduce swelling, and minimize scarring after any procedure.',
             'duration' => '75 minutes', 'price_from' => 500.00, 'sort_order' => 4],
            ['name' => 'BBL Consultation & Aftercare', 'slug' => 'bbl-aftercare', 'category' => 'maternity_postop',
             'short_description' => 'Expert consultation and dedicated aftercare protocols for Brazilian Butt Lift procedures. Ensures optimal results and safe recovery.',
             'duration' => '90 minutes', 'price_from' => 650.00, 'sort_order' => 5],
            ['name' => 'Body Slimming & Shaping', 'slug' => 'body-slimming', 'category' => 'body_treatments',
             'short_description' => 'Non-invasive body contouring treatments to slim, tone, and reshape your figure. Uses advanced technology for visible, lasting results.',
             'duration' => '60 minutes', 'price_from' => 350.00, 'sort_order' => 6],
            ['name' => 'Body Scrubbing', 'slug' => 'body-scrubbing', 'category' => 'body_treatments',
             'short_description' => 'Luxurious full-body exfoliation using premium organic scrubs. Removes dead skin cells, brightens complexion, and deeply moisturizes.',
             'duration' => '45 minutes', 'price_from' => 200.00, 'sort_order' => 7],
            ['name' => 'Skincare Treatment & Coaching', 'slug' => 'skincare-coaching', 'category' => 'skin_treatments',
             'short_description' => 'Personalized skincare treatment paired with expert coaching on your daily routine. Walk away with a custom skincare plan that works.',
             'duration' => '75 minutes', 'price_from' => 280.00, 'sort_order' => 8],
            ['name' => 'Acne Treatment', 'slug' => 'acne-treatment', 'category' => 'skin_treatments',
             'short_description' => 'Targeted acne-clearing treatments using medical-grade products. Addresses active breakouts, acne scars, and prevents future flare-ups.',
             'duration' => '60 minutes', 'price_from' => 250.00, 'sort_order' => 9],
            ['name' => 'Wrinkle Treatment', 'slug' => 'wrinkle-treatment', 'category' => 'skin_treatments',
             'short_description' => 'Advanced anti-wrinkle therapies that smooth fine lines and restore a youthful appearance. Results visible within weeks.',
             'duration' => '60 minutes', 'price_from' => 400.00, 'sort_order' => 10],
            ['name' => 'Anti-Aging Treatment', 'slug' => 'anti-aging', 'category' => 'skin_treatments',
             'short_description' => 'Comprehensive anti-aging protocols targeting loss of elasticity, dark spots, and dullness. Reclaim your radiant, youthful glow.',
             'duration' => '75 minutes', 'price_from' => 450.00, 'sort_order' => 11],
            ['name' => 'Skin Tightening', 'slug' => 'skin-tightening', 'category' => 'skin_treatments',
             'short_description' => 'Non-surgical skin tightening for face and body. Stimulates collagen production to firm, lift, and rejuvenate sagging skin.',
             'duration' => '60 minutes', 'price_from' => 380.00, 'sort_order' => 12],
            ['name' => 'Female Rejuvenation', 'slug' => 'female-rejuvenation', 'category' => 'rejuvenation',
             'short_description' => 'Intimate wellness treatments designed exclusively for women. Restores confidence, comfort, and vitality in a safe, private environment.',
             'duration' => '90 minutes', 'price_from' => 600.00, 'sort_order' => 13],
            ['name' => 'Male Rejuvenation', 'slug' => 'male-rejuvenation', 'category' => 'rejuvenation',
             'short_description' => 'Tailored rejuvenation treatments designed for men. Addresses specific wellness and aesthetic concerns in a discreet, professional setting.',
             'duration' => '90 minutes', 'price_from' => 600.00, 'sort_order' => 14],
        ];

        foreach ($services as $s) {
            Service::firstOrCreate(['slug' => $s['slug']], array_merge($s, ['is_active' => true]));
        }

        // ── Sample Customers ─────────────────────────────────────────
        $customers = [
            ['first_name' => 'Abena', 'last_name' => 'Mensah', 'email' => 'abena.mensah@gmail.com',
             'phone' => '0244123456', 'gender' => 'female', 'date_of_birth' => '1992-05-14',
             'health_notes' => 'Sensitive skin, prefers fragrance-free products.', 'total_bookings' => 6,
             'discount_tier' => 'loyal', 'loyalty_points' => 600],
            ['first_name' => 'Efua', 'last_name' => 'Asante', 'email' => 'efua.asante@yahoo.com',
             'phone' => '0271987654', 'gender' => 'female', 'date_of_birth' => '1988-11-30',
             'health_notes' => '6 weeks post C-section, needs gentle care.', 'total_bookings' => 3,
             'discount_tier' => 'none', 'loyalty_points' => 300],
            ['first_name' => 'Kwame', 'last_name' => 'Boateng', 'email' => 'kwame.boateng@outlook.com',
             'phone' => '0551234567', 'gender' => 'male', 'date_of_birth' => '1985-08-22',
             'health_notes' => 'Interested in anti-aging and skin tightening.', 'total_bookings' => 2,
             'discount_tier' => 'new_client', 'loyalty_points' => 200],
            ['first_name' => 'Ama', 'last_name' => 'Darko', 'email' => 'ama.darko@gmail.com',
             'phone' => '0201456789', 'gender' => 'female', 'date_of_birth' => '1995-03-07',
             'health_notes' => 'Acne-prone skin, currently pregnant (2nd trimester).', 'total_bookings' => 1,
             'discount_tier' => 'new_client', 'loyalty_points' => 100],
            ['first_name' => 'Kofi', 'last_name' => 'Agyemang', 'email' => 'kofi.agyemang@gmail.com',
             'phone' => '0261876543', 'gender' => 'male', 'date_of_birth' => '1990-12-19',
             'health_notes' => 'Post BBL surgery aftercare required.', 'total_bookings' => 5,
             'discount_tier' => 'loyal', 'loyalty_points' => 500],
        ];

        foreach ($customers as $c) {
            Customer::firstOrCreate(['email' => $c['email']], $c);
        }

        // ── Sample Bookings ───────────────────────────────────────────
        $sampleBookings = [
            ['customer' => 'abena.mensah@gmail.com',    'service' => 'body-slimming',      'date' => now()->addDays(2),   'time' => '10:00', 'status' => 'confirmed'],
            ['customer' => 'efua.asante@yahoo.com',      'service' => 'postpartum-csection','date' => now()->addDays(3),   'time' => '14:00', 'status' => 'pending'],
            ['customer' => 'kwame.boateng@outlook.com',  'service' => 'anti-aging',         'date' => now()->addDays(5),   'time' => '11:00', 'status' => 'confirmed'],
            ['customer' => 'ama.darko@gmail.com',        'service' => 'pregnancy-skincare', 'date' => now()->addDays(1),   'time' => '09:00', 'status' => 'confirmed'],
            ['customer' => 'kofi.agyemang@gmail.com',    'service' => 'bbl-aftercare',      'date' => now()->addDays(7),   'time' => '15:00', 'status' => 'pending'],
            ['customer' => 'abena.mensah@gmail.com',     'service' => 'skin-tightening',    'date' => now()->subDays(3),   'time' => '10:30', 'status' => 'completed'],
            ['customer' => 'efua.asante@yahoo.com',      'service' => 'body-scrubbing',     'date' => now()->subDays(7),   'time' => '13:00', 'status' => 'completed'],
            ['customer' => 'kofi.agyemang@gmail.com',    'service' => 'male-rejuvenation',  'date' => now()->subDays(14),  'time' => '16:00', 'status' => 'completed'],
        ];

        foreach ($sampleBookings as $b) {
            $customer = Customer::where('email', $b['customer'])->first();
            $service  = Service::where('slug', $b['service'])->first();
            if (!$customer || !$service) continue;

            $existing = Booking::where('customer_id', $customer->id)
                ->where('service_id', $service->id)
                ->where('booking_date', Carbon::parse($b['date'])->toDateString())
                ->first();

            if (!$existing) {
                $discPct  = $customer->getApplicableDiscountPercentage();
                $original = $service->price_from;
                $discAmt  = round($original * $discPct / 100, 2);
                $final    = $original - $discAmt;

                Booking::create([
                    'customer_id'         => $customer->id,
                    'service_id'          => $service->id,
                    'booking_date'        => Carbon::parse($b['date'])->toDateString(),
                    'booking_time'        => $b['time'],
                    'status'              => $b['status'],
                    'confirmation_number' => Booking::generateConfirmationNumber(),
                    'consent_reminders'   => true,
                    'original_price'      => $original,
                    'discount_amount'     => $discAmt,
                    'final_price'         => $final,
                    'discount_label'      => $discPct > 0 ? "{$discPct}% discount applied" : null,
                ]);
            }
        }

        // ── Page Settings ─────────────────────────────────────────────
        $this->call(PageSettingsSeeder::class);

        // ── Promo Codes ───────────────────────────────────────────────
        PromoCode::firstOrCreate(['code' => 'HEAL10'], [
            'percentage' => 10, 'expiry_date' => now()->addMonths(3),
            'usage_limit' => 50, 'used_count' => 3, 'is_active' => true,
        ]);
        PromoCode::firstOrCreate(['code' => 'GLOW20'], [
            'percentage' => 20, 'expiry_date' => now()->addMonths(1),
            'usage_limit' => 20, 'used_count' => 7, 'is_active' => true,
        ]);
        PromoCode::firstOrCreate(['code' => 'VIP30'], [
            'percentage' => 30, 'expiry_date' => now()->addMonths(6),
            'usage_limit' => 10, 'used_count' => 1, 'is_active' => true,
        ]);
    }
}
