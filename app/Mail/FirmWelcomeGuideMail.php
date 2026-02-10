<?php

namespace App\Mail;

use App\Models\Firm;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FirmWelcomeGuideMail extends Mailable
{
    use Queueable, SerializesModels;

    public Firm $firm;

    /**
     * Create a new message instance.
     */
    public function __construct(Firm $firm)
    {
        $this->firm = $firm;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
            ->subject('Jak zacząć z Looply – krótki przewodnik 🚀')
            ->view('emails.firm-welcome-guide')
            ->with([
                'firm' => $this->firm,
            ]);
    }
}
