<?php

namespace App\Support;

class PhoneNumber
{
    public static function normalize(?string $phone): ?string
    {
        if ($phone === null) {
            return null;
        }

        // أرقام عربية/فارسية -> إنجليزي
        $phone = str_replace(
            ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩','۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'],
            [0,1,2,3,4,5,6,7,8,9,0,1,2,3,4,5,6,7,8,9],
            $phone
        );

        $phone = preg_replace('/\D+/', '', $phone);

        if (str_starts_with($phone, '0020')) {
            $phone = '0' . substr($phone, 4);
        } elseif (str_starts_with($phone, '20') && strlen($phone) === 12) {
            $phone = '0' . substr($phone, 2);
        }

        return $phone !== '' ? $phone : null;
    }
}
