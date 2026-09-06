<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TrainingInquiryResponse;
use App\Models\TrainingInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TrainingInquiryController extends Controller
{
    public function index()
    {
        $inquiries = TrainingInquiry::orderByDesc('created_at')->get();
        return view('admin.training-inquiries.index', compact('inquiries'));
    }

    public function show(TrainingInquiry $trainingInquiry)
    {
        return view('admin.training-inquiries.show', ['inquiry' => $trainingInquiry]);
    }

    public function respond(Request $request, TrainingInquiry $trainingInquiry)
    {
        $validated = $request->validate([
            'admin_response' => 'required|string|max:5000',
        ]);

        $trainingInquiry->update([
            'admin_response' => $validated['admin_response'],
            'status'         => 'responded',
            'responded_by'   => session('admin_name'),
            'responded_at'   => now(),
        ]);

        Mail::to($trainingInquiry->email)->send(new TrainingInquiryResponse($trainingInquiry));

        return redirect()->route('admin.training-inquiries.show', $trainingInquiry)
            ->with('success', 'Response sent to ' . $trainingInquiry->email . '.');
    }

    public function destroy(TrainingInquiry $trainingInquiry)
    {
        $trainingInquiry->delete();
        return redirect()->route('admin.training-inquiries')->with('success', 'Inquiry removed.');
    }
}
