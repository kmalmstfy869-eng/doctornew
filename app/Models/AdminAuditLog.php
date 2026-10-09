<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminAuditLog extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = ['meta' => 'array', 'created_at' => 'datetime'];

    // تسجيل أي عملية إدارية مهمة: مين نفّذها، إيه هي، على إيه، وتفاصيلها.
    public static function record(string $action, ?string $target = null, array $meta = []): void
    {
        static::query()->create([
            'admin_id' => auth()->id(),
            'action' => $action,
            'target' => $target,
            'meta' => $meta ?: null,
        ]);
    }
}
