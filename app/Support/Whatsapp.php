<?php

namespace App\Support;

class Whatsapp
{
    public static function link(?string $text): string
    {
        return 'https://wa.me/' . config('app.support_whatsapp') . '?text=' . urlencode($text);
    }
}
