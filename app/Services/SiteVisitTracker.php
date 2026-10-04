<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteVisitTracker
{
    public function __construct(private VisitGate $gate) {}

    public function record(string $pageType, Request $request, int $doctorId = 0): void
    {
        if (! $this->gate->isTrackable($request)) {
            return;
        }

        $scope = "{$pageType}:{$doctorId}";

        $claim = $this->gate->claim(
            "site_view:{$scope}",
            "site_unique:{$scope}",
            $this->gate->fingerprint($request)
        );

        $updates = [];
        if ($claim['view']) {
            $updates['views'] = DB::raw('views + 1');
        }
        if ($claim['unique']) {
            $updates['unique_visitors'] = DB::raw('unique_visitors + 1');
        }
        if ($updates === []) {
            return;
        }

        $today = now()->toDateString();

        $query = fn () => DB::table('site_visit_stats')
            ->where('page_type', $pageType)
            ->where('doctor_id', $doctorId)
            ->where('stat_date', $today);

        if ($query()->update($updates) === 0) {
            DB::table('site_visit_stats')->insertOrIgnore([
                'page_type' => $pageType,
                'doctor_id' => $doctorId,
                'stat_date' => $today,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $query()->update($updates);
        }
    }
}
