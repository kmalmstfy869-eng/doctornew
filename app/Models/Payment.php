<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    public const INCOME = 'income';
    public const EXPENSE = 'expense';

    public const METHODS = [
        'cash' => 'كاش',
        'visa' => 'فيزا',
        'wallet' => 'محفظة إلكترونية',
        'transfer' => 'تحويل بنكي',
    ];

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'type',
        'title',
        'amount',
        'method',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'date',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
