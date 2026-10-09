<?php

namespace App\Http\Controllers\Admin\Concerns;

use Carbon\Carbon;

trait ParsesDates
{

    private function dateOrNull($value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        try {
            $d = Carbon::createFromFormat('!Y-m-d', $value);

            return $d && $d->format('Y-m-d') === $value ? $value : null;
        } catch (\Throwable) {
            return null;
        }
    }
}

