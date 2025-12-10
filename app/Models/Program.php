public function cards()
{
    return $this->hasMany(LoyaltyCard::class);
}

public function vouchers()
{
    return $this->hasMany(GiftVoucher::class);
}
