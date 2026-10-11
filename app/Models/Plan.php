<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price',
        'description',
        'duration',
        'features',
        'the_best',
        'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'the_best' => 'boolean',
        'price' => 'decimal:2',
        'duration' => 'integer',
    ];

    public function subscription()
    {
        return $this->hasMany(Subscription::class);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => strtolower($value)
        );
    }

    public function isFree(): bool
    {
        return $this->slug === 'free' || $this->name === 'free';
    }

    /** مفتاح الباقة الأم: free / prime / professional / clinic-system */
    public function tierKey(): string
    {
        return $this->isFree() ? 'free' : Str::slug($this->name);
    }

    public function durationLabel(): string
    {
        return match ((int) $this->duration) {
            30 => 'شهري',
            90 => '3 شهور',
            365 => 'سنوي',
            default => $this->duration . ' يوم',
        };
    }

    /** بصمة الحقول القابلة للتعديل في الباقة (من غير الترتيب) */
    public static function tierToken(Collection $rows): string
    {
        return md5(json_encode(
            $rows->sortBy('id')
                ->map(fn (self $p) => $p->only(['id', 'price', 'description', 'features', 'the_best']))
                ->values()
                ->all()
        ));
    }

    /** بصمة الترتيب الحالي للباقات المدفوعة */
    public static function orderToken(Collection $paid): string
    {
        return md5($paid->sortBy('id')->map(fn (self $p) => $p->id . ':' . $p->sort_order)->implode('|'));
    }

    public static function tierPayload(string $key, Collection $rows): array
    {
        $rows = $rows->sortBy('duration')->values();
        $first = $rows->first();

        return [
            'key' => $key,
            'title' => $key === 'free' ? 'Free' : ucwords($first->name),
            'is_free' => $key === 'free',
            'description' => (string) $first->description,
            'features' => array_values($first->features ?? []),
            'the_best' => $rows->contains('the_best', true),
            'token' => self::tierToken($rows),
            'url' => route('admin.plans.tiers.update', $key),
            'plans' => $rows->map(fn (self $p) => [
                'id' => $p->id,
                'label' => $p->durationLabel(),
                'duration' => (int) $p->duration,
                'price' => (float) $p->price,
            ])->all(),
        ];
    }
}
