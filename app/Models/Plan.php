<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Model;

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
        return $this->hasmany(Subscription::class);
    }

protected function name(): Attribute
{
    return Attribute::make(
        get: fn (string $value) => strtolower($value)
    );
}

}
