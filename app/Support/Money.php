<?php

namespace App\Support;

class Money
{
    public static function fmt($n): string
    {
        return rtrim(rtrim(number_format((float) $n, 2, '.', ','), '0'), '.');
    }
}
