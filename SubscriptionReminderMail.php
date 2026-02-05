public function build()
{
    return $this->subject('⚠️ Twój abonament Looply wkrótce wygaśnie')
        ->view('emails.subscription-reminder')
        ->with([
            'firm' => $this->firm
        ]);
}
