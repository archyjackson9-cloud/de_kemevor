<?php

return [
    /*
    |--------------------------------------------------------------------------
    | The Healing Room — Application Config
    |--------------------------------------------------------------------------
    */

    'reminders' => [
        'sms_enabled'   => true,
        'email_enabled' => true,
    ],

    'admin' => [
        'email'    => 'admin@thehealingroom.com',
        'password' => 'HealAdmin2025',
    ],

    'booking' => [
        'loyalty_points_per_booking' => 100,
        'loyal_tier_threshold'       => 5,   // bookings needed to reach loyal tier
    ],
];
