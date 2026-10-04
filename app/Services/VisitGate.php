<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VisitGate
{
    private const BOT_PATTERN = '/bot|crawler|spider|slurp|curl|wget|python|headless/i';

    public function isTrackable(Request $request): bool
    {
        $userAgent = (string) $request->userAgent();

        return $request->isMethod('GET')
            && ! $request->ajax()
            && $userAgent !== ''
            && ! preg_match(self::BOT_PATTERN, $userAgent);
    }

    public function fingerprint(Request $request): string
    {
        return hash_hmac('sha256', $request->ip() . '|' . $request->userAgent(), config('app.key'));
    }


    public function claim(string $viewKeyBase, string $uniqueKeyBase, string $fingerprint): array
    {
        return [
            'view' => Cache::add("{$viewKeyBase}:{$fingerprint}", true, now()->addMinutes(30)),
            'unique' => Cache::add(
                "{$uniqueKeyBase}:" . now()->format('Y-m-d') . ":{$fingerprint}",
                true,
                now()->endOfDay()
            ),
        ];
    }
}
