<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE services MODIFY COLUMN category ENUM(
            'maternity_postop', 'body_treatments', 'skin_treatments', 'rejuvenation', 'body_enhancement', 'massage'
        ) NOT NULL");

        Schema::table('services', function (Blueprint $table) {
            $table->text('ideal_for')->nullable()->after('description');      // one item per line
            $table->text('highlights')->nullable()->after('ideal_for');       // one item per line ("What's included")
        });

        $now = now();

        $rows = [
            [
                'name' => 'The Executive Reset', 'slug' => 'the-executive-reset', 'sort_order' => 30,
                'short_description' => 'A focused, tension-melting massage for busy professionals — releasing the neck, shoulders and back, and resetting a stressed mind.',
                'description' => "Long hours at a desk, back-to-back meetings, and constant screen time leave most professionals carrying tension in the same places: the neck, shoulders, upper back and jaw. The Executive Reset is a customized massage built around exactly those pressure points, combining firm, targeted work with slow, calming strokes to release tightness and quiet an overworked mind.\n\nYour therapist begins with a short conversation about where you hold stress and how much pressure you prefer, then tailors the session to you. Expect focused attention on the neck, shoulders, upper back, arms and scalp, with gentle stretching to ease the postural strain that comes from sitting and typing all day.\n\nMassage can offer short-term relief for neck and shoulder discomfort and helps many people feel noticeably calmer. It is a wellness treatment, not a replacement for medical care. If you have persistent pain, numbness or tingling, please speak to your doctor as well.\n\nSchedule it before a big week, after a deadline, or as a regular monthly reset. You will leave feeling lighter, clearer and ready to perform at your best.",
                'ideal_for' => "Executives, business owners and desk-based professionals\nAnyone with neck, shoulder or upper-back tension\nHeadaches linked to stress and posture\nPeople who struggle to switch off after work",
                'highlights' => "Pre-session consultation and pressure preference check\nTargeted neck, shoulder and upper-back work\nScalp and arm release\nGentle posture-relieving stretches\nPrivate, quiet treatment room",
                'meta_title' => 'The Executive Reset Massage in Ghana | The Healing Room',
                'meta_description' => 'Release neck, shoulder and back tension with The Executive Reset, a customized stress-relief massage for busy professionals at The Healing Room, Lashibi, Ghana.',
                'duration' => '60 minutes',
            ],
            [
                'name' => 'The Nurture & Glow', 'slug' => 'the-nurture-and-glow', 'sort_order' => 31,
                'short_description' => 'A gentle, restorative massage for new mothers and anyone craving deep nurturing — easing tired muscles while leaving skin soft and radiant.',
                'description' => "The Nurture & Glow is designed for the moments when your body has given a lot and deserves something in return. Slow, flowing strokes and warming, nourishing massage oils soothe tired muscles, calm the nervous system and leave your skin soft, supple and glowing.\n\nIt is especially loved by new mothers in the postpartum season, when carrying, feeding and sleepless nights place constant strain on the back, shoulders and arms. Pressure is gentle to moderate and fully adjustable, and your therapist will always respect your comfort, recovery stage and any areas to avoid.\n\nBeyond physical relief, this massage is about care. A quiet, unhurried hour in a private space helps you breathe out, rest and reconnect with yourself. Massage cannot treat medical conditions, so if you are recovering from a caesarean section or have any complications, please tell us at booking so we can adapt your session or advise you to check with your doctor first.\n\nLeave feeling nurtured, restored and glowing from the inside out.",
                'ideal_for' => "New mothers in the postpartum season\nAnyone who is exhausted, run-down or emotionally drained\nClients wanting a soothing, skin-nourishing treatment\nGift for someone who deserves a break",
                'highlights' => "Slow, flowing full-body relaxation strokes\nNourishing massage oils for soft, glowing skin\nExtra care for back, shoulders and arms\nAdjustable, gentle-to-moderate pressure\nCalming atmosphere designed for rest",
                'meta_title' => 'The Nurture & Glow Massage in Ghana | The Healing Room',
                'meta_description' => 'Restore tired muscles and glowing skin with The Nurture & Glow, a gentle nurturing massage at The Healing Room, Lashibi, Ghana. Ideal for new mothers.',
                'duration' => '60 minutes',
            ],
            [
                'name' => 'The Bliss & Bump', 'slug' => 'the-bliss-and-bump', 'sort_order' => 32,
                'short_description' => 'A safe, comforting prenatal massage that eases back, hip and leg discomfort while you and your growing bump relax.',
                'description' => "Pregnancy changes your body quickly, and aching lower back, tight hips, swollen-feeling legs and poor sleep are very common. The Bliss & Bump is a prenatal massage created to bring comfort during this season, using gentle, supportive techniques that suit your changing body.\n\nYou are positioned comfortably on your side with pillows and bolsters supporting your bump, which is the standard recommended position for prenatal massage. Your therapist works on the back, hips, legs, feet, shoulders and neck with light to moderate pressure, and avoids deep work on the abdomen.\n\nMost pregnancy providers recommend waiting until the second trimester (around 12 weeks) before starting massage. Before your first session we will ask a few questions about your pregnancy, and we ask that you check with your doctor or midwife first if you have a high-risk pregnancy, high blood pressure, unexplained bleeding or any complication. Prenatal massage may help with stress, back and leg discomfort and sleep, but it does not replace antenatal care.\n\nTake an hour to breathe, unwind and enjoy being cared for while you prepare to welcome your baby.",
                'ideal_for' => "Expectant mothers from the second trimester (around 12 weeks) with doctor or midwife clearance\nBack, hip and leg discomfort during pregnancy\nSwollen-feeling legs and tired feet\nMothers wanting to relax and sleep better",
                'highlights' => "Side-lying positioning with full pillow and bolster support\nGentle work on back, hips, legs, feet, shoulders and neck\nNo deep abdominal pressure\nPregnancy screening questions before your first visit\nSafe, calm and private setting",
                'meta_title' => 'The Bliss & Bump Prenatal Massage in Ghana | The Healing Room',
                'meta_description' => 'Ease pregnancy aches with The Bliss & Bump, a safe prenatal massage for expectant mothers at The Healing Room, Lashibi, Ghana. Book your session.',
                'duration' => '60 minutes',
            ],
            [
                'name' => 'The Rebound & Restore', 'slug' => 'the-rebound-and-restore', 'sort_order' => 33,
                'short_description' => 'A deep, recovery-focused massage for athletes and active bodies — easing soreness, loosening tight muscles and restoring movement.',
                'description' => "Hard training, long runs, gym sessions and weekend sport all leave your muscles tight, sore and short on recovery time. The Rebound & Restore is a firmer, recovery-focused massage that targets the muscle groups you work hardest, helping you feel looser and ready to move again.\n\nThrough a blend of deep tissue and sports massage techniques, your therapist works on knots and tight areas, improves flexibility and eases post-exercise soreness. Research on sports massage shows modest benefits for muscle soreness and flexibility, so think of it as a way to feel better and move more freely rather than a shortcut to faster tissue repair.\n\nIt works equally well before a big event as light preparation, and afterwards as recovery. We will ask about your training, any injuries and your preferred pressure, and we will never push beyond what is comfortable. Some tenderness the following day is normal, and drinking plenty of water helps.\n\nWhether you are a competitive athlete or simply an active person, let your body rebound and restore.",
                'ideal_for' => "Athletes and gym-goers\nRunners and weekend sports players\nPeople with tight, sore or stiff muscles\nAnyone recovering from heavy training or physical work",
                'highlights' => "Deep tissue and sports massage techniques\nFocus on your most-used muscle groups\nStretching to improve flexibility and range of movement\nTraining and injury check before your session\nAftercare advice on hydration and recovery",
                'meta_title' => 'The Rebound & Restore Sports Massage in Ghana | The Healing Room',
                'meta_description' => 'Ease sore muscles and restore movement with The Rebound & Restore, a deep recovery massage for active bodies at The Healing Room, Lashibi, Ghana.',
                'duration' => '60 minutes',
            ],
        ];

        foreach ($rows as $row) {
            DB::table('services')->insertOrIgnore(array_merge($row, [
                'category'   => 'massage',
                'price_from' => 0, // price on request — to be set later via Admin → Services
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }

    public function down(): void
    {
        DB::table('services')->where('category', 'massage')->delete();

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['ideal_for', 'highlights']);
        });

        DB::statement("ALTER TABLE services MODIFY COLUMN category ENUM(
            'maternity_postop', 'body_treatments', 'skin_treatments', 'rejuvenation', 'body_enhancement'
        ) NOT NULL");
    }
};
