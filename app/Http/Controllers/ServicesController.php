<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServicesController extends Controller
{
    public function index()
    {
        $categories = [
            'maternity_postop' => ['label' => 'Maternity & Post-Op Care', 'icon' => '🤱', 'color' => 'pink'],
            'body_treatments'  => ['label' => 'Body Treatments',          'icon' => '💆', 'color' => 'teal'],
            'skin_treatments'  => ['label' => 'Skin Treatments',          'icon' => '✨', 'color' => 'amber'],
            'rejuvenation'     => ['label' => 'Rejuvenation',             'icon' => '🌸', 'color' => 'purple'],
        ];

        $servicesByCategory = [];
        foreach ($categories as $key => $meta) {
            $servicesByCategory[$key] = [
                'meta'     => $meta,
                'services' => Service::where('category', $key)
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->get(),
            ];
        }

        return view('services', compact('servicesByCategory'));
    }
}
