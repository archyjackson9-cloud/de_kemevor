<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\PromoCode;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Database\Seeders\PageSettingsSeeder;
use Database\Seeders\AdminUserSeeder;

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

            // ── Body Enhancement (draft — placeholder pricing, review & activate via Admin → Services) ──
            ['name' => 'Non-Invasive Body Shaping & Fat Burning Contouring', 'slug' => 'body-shaping-fat-burning-contouring', 'category' => 'body_enhancement',
             'short_description' => "Advanced non-invasive contouring technology that targets stubborn fat pockets and reshapes your silhouette — no surgery, no downtime.",
             'description' => "Many people carry stubborn pockets of fat that don't respond to diet and exercise alone — around the abdomen, flanks, thighs, or arms. Our Non-Invasive Body Shaping & Fat Burning Contouring treatment uses targeted technology to break down fat cells and support your body's natural elimination process, helping you achieve a more sculpted, confident silhouette without surgery or extended recovery time.\n\nEach session is customized to your body's unique contours and goals. Whether you're working toward your pre-pregnancy shape, refining results after weight loss, or simply want to feel more confident in your clothes, our specialists design a treatment plan that fits your timeline and lifestyle — with no needles, incisions, or downtime required.\n\nAt The Healing Room, we combine proven contouring techniques with a warm, judgment-free environment. You'll leave every session with clear guidance on how to maintain and enhance your results, backed by a team that treats your goals with the same seriousness you do.",
             'meta_title' => 'Non-Invasive Body Shaping & Fat Burning Contouring in Ghana | The Healing Room',
             'meta_description' => 'Sculpt and contour your body without surgery. Non-invasive fat-burning body shaping at The Healing Room, Lashibi, Ghana. Book your consultation today.',
             'duration' => '60 minutes', 'price_from' => 400.00, 'sort_order' => 15, 'is_active' => false],

            ['name' => 'Weight Management', 'slug' => 'weight-management', 'category' => 'body_enhancement',
             'short_description' => 'A personalized, whole-body approach to sustainable weight management — combining expert guidance, body treatments, and ongoing support.',
             'description' => "Sustainable weight management is rarely about a single treatment — it's about a plan that fits your body, your schedule, and your life. Our Weight Management program at The Healing Room brings together professional guidance, targeted body treatments, and consistent follow-up to help you work toward your goals in a healthy, realistic way.\n\nEvery client begins with a one-on-one consultation where we discuss your history, lifestyle, and goals before building a personalized plan. From there, we combine in-clinic treatments with practical, everyday guidance — no extreme measures, no one-size-fits-all programs.\n\nWhat sets our approach apart is the ongoing relationship: we track your progress, adjust your plan as needed, and celebrate every milestone with you. If you're ready for a weight management journey built around real support rather than quick fixes, our team is here to walk it with you.",
             'meta_title' => 'Weight Management Program in Ghana | The Healing Room Esthetic Clinic',
             'meta_description' => 'Personalized weight management support in Lashibi, Ghana — expert guidance, body treatments, and ongoing accountability. Book a consultation today.',
             'duration' => '45 minutes', 'price_from' => 300.00, 'sort_order' => 16, 'is_active' => false],

            ['name' => 'Non-Invasive Lipo 380', 'slug' => 'non-invasive-lipo-380', 'category' => 'body_enhancement',
             'short_description' => 'Our signature Non-Invasive Lipo 380 treatment uses focused technology to target fat cells in problem areas — no surgery, no needles, no downtime.',
             'description' => "Non-Invasive Lipo 380 is designed for clients who want visible, targeted fat reduction without the risks and recovery time of surgical liposuction. The treatment uses focused energy to target fat cells beneath the skin, working with your body's own processes to gradually reduce the appearance of stubborn areas like the abdomen, waist, and thighs.\n\nBecause it's non-surgical, most clients return to their normal routine immediately after each session — no incisions, no anesthesia, and no extended recovery. Results build gradually over a course of sessions, which our specialists will map out based on your goals and problem areas during your consultation.\n\nWe understand that trying a new treatment can feel like a big decision, which is why every Non-Invasive Lipo 380 journey at The Healing Room starts with an honest consultation about what the treatment can realistically achieve for you — followed by expert care every step of the way.",
             'meta_title' => 'Non-Invasive Lipo 380 Treatment in Ghana | The Healing Room',
             'meta_description' => 'Target stubborn fat without surgery. Non-Invasive Lipo 380 at The Healing Room, Lashibi, Ghana — no downtime, expert-led. Book your consultation.',
             'duration' => '60 minutes', 'price_from' => 550.00, 'sort_order' => 17, 'is_active' => false],

            ['name' => 'After Sports Muscle Recovery', 'slug' => 'after-sports-muscle-recovery', 'category' => 'body_enhancement',
             'short_description' => 'Targeted recovery treatments for athletes and active individuals — easing muscle soreness, reducing tension, and speeding up recovery between training sessions.',
             'description' => "Whether you're a competitive athlete or simply committed to an active lifestyle, intense training takes a toll on your muscles. Our After Sports Muscle Recovery treatment is designed to ease post-exercise soreness, release built-up tension, and support your body's natural recovery process — so you can get back to training sooner and perform at your best.\n\nEach session focuses on the muscle groups you've been working hardest, using techniques that improve circulation, reduce stiffness, and promote relaxation. It's an ideal addition to any training routine, whether you're recovering from a big event or maintaining a demanding weekly schedule.\n\nOur team works with athletes and active clients across Ghana who want recovery care that's as disciplined as their training. Book a session after your next big workout, race, or competition and feel the difference expert recovery care makes.",
             'meta_title' => 'After Sports Muscle Recovery Treatment in Ghana | The Healing Room',
             'meta_description' => 'Ease soreness and speed up recovery after training or competition. After Sports Muscle Recovery treatments at The Healing Room, Lashibi, Ghana.',
             'duration' => '45 minutes', 'price_from' => 280.00, 'sort_order' => 18, 'is_active' => false],

            ['name' => 'Targeted Muscle Building & Toning', 'slug' => 'targeted-muscle-building-toning', 'category' => 'body_enhancement',
             'short_description' => "Non-invasive treatments that target specific muscle groups to build tone and definition — a complement to your fitness routine, not a replacement for it.",
             'description' => "Some areas of the body are simply harder to tone through exercise alone — whether due to time constraints, injury, or a stubborn muscle group that doesn't respond as quickly as the rest. Our Targeted Muscle Building & Toning treatment uses focused technology to stimulate deep, consistent muscle contractions, helping to build tone and definition in specific areas.\n\nThis treatment works best as part of an active lifestyle, complementing the effort you already put in at the gym or in daily movement. Common focus areas include the abdomen, glutes, and arms, though your specialist will tailor each session to the areas that matter most to you.\n\nAt The Healing Room, we set realistic expectations from the start and build a session plan that matches your goals and timeline. If you're looking to add definition where it counts, our specialists are ready to help you get there.",
             'meta_title' => 'Targeted Muscle Building & Toning in Ghana | The Healing Room',
             'meta_description' => 'Build tone and definition in stubborn areas with targeted muscle treatments at The Healing Room, Lashibi, Ghana. Book your consultation today.',
             'duration' => '45 minutes', 'price_from' => 380.00, 'sort_order' => 19, 'is_active' => false],

            ['name' => 'Lactation Consultation', 'slug' => 'lactation-consultation', 'category' => 'body_enhancement',
             'short_description' => 'One-on-one lactation support for new and expecting mothers — practical guidance on breastfeeding, latch, milk supply, and comfort.',
             'description' => "Breastfeeding doesn't always come easily, and every mother-baby pair is different. Our Lactation Consultation service offers dedicated, judgment-free support to help you navigate latch difficulties, milk supply concerns, discomfort, and the everyday questions that come with feeding your baby.\n\nSessions are personal and unhurried — we take the time to understand your specific situation, observe a feeding where helpful, and offer practical, evidence-informed guidance you can put into practice right away. Whether you're preparing before birth or troubleshooting a few weeks in, our team meets you where you are.\n\nYou don't have to navigate breastfeeding alone. The Healing Room is here to support you with the same warmth and expertise we bring to every stage of your motherhood journey.",
             'meta_title' => 'Lactation Consultation in Ghana | The Healing Room Esthetic Clinic',
             'meta_description' => 'One-on-one breastfeeding support for new and expecting mothers at The Healing Room, Lashibi, Ghana. Book a lactation consultation today.',
             'duration' => '60 minutes', 'price_from' => 250.00, 'sort_order' => 20, 'is_active' => false],

            ['name' => 'Body & Image Counseling Services', 'slug' => 'body-image-counseling', 'category' => 'body_enhancement',
             'short_description' => 'Supportive, private counseling sessions to help you build a healthier relationship with your body and rebuild confidence at your own pace.',
             'description' => "How we see ourselves matters — especially during major life transitions like postpartum recovery, weight changes, or after a cosmetic procedure. Our Body & Image Counseling Services offer a private, compassionate space to talk through the emotional side of these changes with a supportive professional.\n\nSessions are entirely client-led. Some clients come in to process changes after childbirth or surgery, others simply want support building a healthier relationship with their body and self-image. Wherever you're starting from, our approach is patient, respectful, and completely confidential.\n\nTrue confidence goes beyond appearance. The Healing Room is committed to supporting the whole person — mind and body — because we believe every client deserves to feel truly at home in themselves.",
             'meta_title' => 'Body & Image Counseling Services in Ghana | The Healing Room',
             'meta_description' => 'Private, supportive counseling to help you rebuild confidence and a healthier body image. The Healing Room, Lashibi, Ghana. Book a session today.',
             'duration' => '60 minutes', 'price_from' => 220.00, 'sort_order' => 21, 'is_active' => false],

            ['name' => 'Pre and Post Natal Support Services', 'slug' => 'pre-post-natal-support', 'category' => 'body_enhancement',
             'short_description' => 'Compassionate, personalized support through every stage of pregnancy and the fourth trimester — from prenatal wellness to postpartum recovery.',
             'description' => "Pregnancy and the months that follow bring enormous physical and emotional change. Our Pre and Post Natal Support Services are designed to walk alongside you through every stage — from prenatal wellness and skin care to postpartum recovery, body changes, and emotional adjustment after birth.\n\nWe tailor every plan to where you are in your journey. Expecting mothers receive safe, bump-friendly guidance and treatments, while new mothers get dedicated postpartum support that respects the pace of their recovery — physically and emotionally.\n\nYou don't have to figure out this season alone. The Healing Room's Pre and Post Natal Support Services bring together expert care and genuine compassion, so you feel supported from the first trimester through your postpartum recovery and beyond.",
             'meta_title' => 'Pre and Post Natal Support Services in Ghana | The Healing Room',
             'meta_description' => 'Compassionate prenatal and postpartum support at The Healing Room, Lashibi, Ghana — from pregnancy wellness to fourth-trimester recovery.',
             'duration' => '60 minutes', 'price_from' => 320.00, 'sort_order' => 22, 'is_active' => false],
        ];

        foreach ($services as $s) {
            Service::firstOrCreate(['slug' => $s['slug']], array_merge(['is_active' => true], $s));
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

        // ── Hero Slides ───────────────────────────────────────────────
        $this->call(HeroSlideSeeder::class);

        // ── Admin User ────────────────────────────────────────────────
        $this->call(AdminUserSeeder::class);

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
