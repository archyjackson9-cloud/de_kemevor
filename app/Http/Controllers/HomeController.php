<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        $featuredServices = Service::where('is_active', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        $partners = Partner::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('home', compact('featuredServices', 'partners'));
    }
}
