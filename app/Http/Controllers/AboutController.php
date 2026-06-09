<?php

namespace App\Http\Controllers;

use App\Models\AboutCertification;
use App\Models\AboutValue;
use App\Models\SiteSetting;
use App\Models\TeamMember;

class AboutController extends Controller
{
    public function index()
    {
        $s = SiteSetting::forPage('about_');

        $teamMembers = TeamMember::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $values = AboutValue::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $certs = AboutCertification::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('about', compact('s', 'teamMembers', 'values', 'certs'));
    }
}
