<?php

namespace App\Mail;

use App\Models\Firm;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FirmAccountCreated extends Mailable
{
    use Queueable, SerializesModels;

    public Firm $firm;
    public string $password;

    public function __construct(Firm $firm, string $password)
    {
        $this->firm = $firm;
        $this->password = $password;
    }

    public function build()
    {
        return $this
            ->subject('Dostęp do panelu firmy – Peitho')
            ->view('emails.firm-created');
    }
}
