<?php

namespace App\Http\Controllers;

use App\Mail\NewConsultationNotification;
use App\Models\Consultation;
use App\Models\ConsultationImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EConsultationController extends Controller
{
    public function index()
    {
        return view('econsultation');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                => 'required|string|max:100',
            'email'               => 'required|email|max:150',
            'phone'               => 'nullable|string|max:20',
            'age'                 => 'nullable|integer|min:0|max:120',
            'gender'              => 'nullable|in:female,male,other',
            'concern_area'        => 'nullable|string|max:50',
            'problem_description' => 'required|string|max:3000',
            'images'              => 'nullable|array|max:5',
            'images.*'            => 'image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $validated['reference_number'] = Consultation::generateReferenceNumber();
        $validated['status'] = 'pending';

        $consultation = Consultation::create($validated);

        foreach ($request->file('images', []) as $image) {
            $path = $image->store('consultations', 'public');
            ConsultationImage::create([
                'consultation_id' => $consultation->id,
                'path'            => $path,
            ]);
        }

        $adminEmails = User::pluck('email');
        if ($adminEmails->isNotEmpty()) {
            Mail::to($adminEmails->all())->send(new NewConsultationNotification($consultation));
        }

        return redirect()->route('econsultation')->with('success',
            'Thank you! Your e-consultation request has been submitted. Reference: ' . $consultation->reference_number .
            '. Our specialists will review your case and email you a response soon.');
    }
}
