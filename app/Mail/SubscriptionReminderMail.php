<?php

namespace App\Mail;

use App\Models\Firm;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $firm;

    public function __construct(Firm $firm)
    {
        $this->firm = $firm;
    }

    public function build()
    {
        return $this->subject('Twój abonament w Looply wkrótce wygasa')
            ->view('emails.subscription-reminder');
    }
}
