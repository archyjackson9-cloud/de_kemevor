<?php

namespace App\Mail;

use App\Models\TrainingInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewTrainingInquiryNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public TrainingInquiry $inquiry)
    {
    }

    public function build()
    {
        return $this->subject('New Training Enrollment Inquiry – ' . $this->inquiry->reference_number)
            ->view('emails.new-training-inquiry-notification');
    }
}
