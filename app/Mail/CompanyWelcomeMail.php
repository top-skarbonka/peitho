<?php

namespace App\Mail;

use App\Models\Firm;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public Firm $firm;
    public string $plainPassword;

    public function __construct(Firm $firm, string $plainPassword)
    {
        $this->firm = $firm;
        $this->plainPassword = $plainPassword;
    }

    public function build()
    {
        return $this
            ->subject('🎉 Witaj w Looply!')
            ->view('emails.company-welcome');
    }
}
