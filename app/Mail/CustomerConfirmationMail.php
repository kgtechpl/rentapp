<?php

namespace App\Mail;

use App\Models\ContactInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;

    public function __construct(ContactInquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    public function build()
    {
        return $this->subject('Potwierdzenie otrzymania zapytania')
            ->view('emails.customer-confirmation');
    }
}
