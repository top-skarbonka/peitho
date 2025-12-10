<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrService
{
    public static function generate($value)
    {
        return base64_encode(
            QrCode::format('png')
                ->size(300)
                ->margin(1)
                ->generate($value)
        );
    }
}
