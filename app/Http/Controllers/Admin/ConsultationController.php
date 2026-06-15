<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ConsultationResponse as ConsultationResponseMail;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::withCount('images')->orderByDesc('created_at')->get();
        return view('admin.consultations.index', compact('consultations'));
    }

    public function show(Consultation $consultation)
    {
        $consultation->load('images');
        return view('admin.consultations.show', compact('consultation'));
    }

    public function respond(Request $request, Consultation $consultation)
    {
        $validated = $request->validate([
            'admin_response' => 'required|string|max:5000',
        ]);

        $consultation->update([
            'admin_response' => $validated['admin_response'],
            'status'         => 'responded',
            'responded_by'   => session('admin_name'),
            'responded_at'   => now(),
        ]);

        Mail::to($consultation->email)->send(new ConsultationResponseMail($consultation));

        return redirect()->route('admin.consultations.show', $consultation)
            ->with('success', 'Response sent to ' . $consultation->email . '.');
    }

    public function destroy(Consultation $consultation)
    {
        foreach ($consultation->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $consultation->delete();

        return redirect()->route('admin.consultations')->with('success', 'Consultation request removed.');
    }
}
