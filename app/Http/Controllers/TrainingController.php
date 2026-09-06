<?php

namespace App\Http\Controllers;

use App\Mail\NewTrainingInquiryNotification;
use App\Models\SiteSetting;
use App\Models\TrainingGainItem;
use App\Models\TrainingInquiry;
use App\Models\TrainingLearnPoint;
use App\Models\TrainingPhase;
use App\Models\TrainingWhoFor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TrainingController extends Controller
{
    public function index()
    {
        $s          = SiteSetting::forPage('training_');
        $phases     = TrainingPhase::where('is_active', true)->orderBy('sort_order')->orderBy('phase_number')->get();
        $whoFor     = TrainingWhoFor::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();
        $learnPoints= TrainingLearnPoint::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();
        $gainItems  = TrainingGainItem::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();

        return view('training', compact('s', 'phases', 'whoFor', 'learnPoints', 'gainItems'));
    }

    public function enroll(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:100',
            'email'          => 'required|email|max:150',
            'phone'          => 'nullable|string|max:20',
            'phase_interest' => 'nullable|string|max:150',
            'message'        => 'nullable|string|max:2000',
        ]);

        $validated['reference_number'] = TrainingInquiry::generateReferenceNumber();
        $validated['status'] = 'pending';

        $inquiry = TrainingInquiry::create($validated);

        $adminEmails = User::pluck('email');
        if ($adminEmails->isNotEmpty()) {
            Mail::to($adminEmails->all())->send(new NewTrainingInquiryNotification($inquiry));
        }

        return redirect()->route('training')->with('success',
            'Thank you for your interest! Your enrollment inquiry has been received. Reference: ' . $inquiry->reference_number .
            '. Our team will get back to you shortly.');
    }
}
