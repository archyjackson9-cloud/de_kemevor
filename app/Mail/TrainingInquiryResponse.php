<?php

namespace App\Mail;

use App\Models\TrainingInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TrainingInquiryResponse extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public TrainingInquiry $inquiry)
    {
    }

    public function build()
    {
        return $this->subject('Your Training Enrollment Inquiry – The Healing Room')
            ->view('emails.training-inquiry-response');
    }
}
