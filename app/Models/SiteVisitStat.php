<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class SiteVisitStat extends Model
{
    public const HOME = 'home';
    public const DOCTOR_PROFILE = 'doctor_profile';

    protected $fillable = [];

    protected $casts = ['stat_date' => 'date'];

    /** إجمالي الموقع (للأدمن)، مع فترة اختيارية Y-m-d */
    public static function totals(?string $from = null, ?string $to = null): array
    {
        return self::sums(static::query(), $from, $to);
    }

    /** أرقام دكتور واحد (للوحته) */
    public static function forDoctor(int $doctorId, ?string $from = null, ?string $to = null): array
    {
        $query = static::query()
            ->where('page_type', self::DOCTOR_PROFILE)
            ->where('doctor_id', $doctorId);

        return self::sums($query, $from, $to);
    }

    /** سلسلة يومية للموقع كله، أو لدكتور معيّن لو مرّرت $doctorId */
    public static function dailySeries(string $from, string $to, ?int $doctorId = null): Collection
    {
        return static::query()
            ->whereBetween('stat_date', [$from, $to])
            ->when($doctorId !== null, fn (Builder $q) => $q
                ->where('page_type', self::DOCTOR_PROFILE)
                ->where('doctor_id', $doctorId))
            ->selectRaw('stat_date, SUM(views) AS views, SUM(unique_visitors) AS unique_visitors')
            ->groupBy('stat_date')
            ->orderBy('stat_date')
            ->get();
    }

    private static function sums(Builder $query, ?string $from, ?string $to): array
    {
        $row = $query
            ->when($from, fn (Builder $q) => $q->where('stat_date', '>=', $from))
            ->when($to, fn (Builder $q) => $q->where('stat_date', '<=', $to))
            ->selectRaw('COALESCE(SUM(views), 0) AS views, COALESCE(SUM(unique_visitors), 0) AS unique_visitors')
            ->first();

        return ['views' => (int) $row->views, 'unique_visitors' => (int) $row->unique_visitors];
    }
}

