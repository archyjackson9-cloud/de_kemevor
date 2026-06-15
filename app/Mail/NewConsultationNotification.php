<?php

namespace App\Mail;

use App\Models\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewConsultationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Consultation $consultation)
    {
    }

    public function build()
    {
        return $this->subject('New E-Consultation Request – ' . $this->consultation->reference_number)
            ->view('emails.new-consultation-notification');
    }
}
