<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceEntry extends Model
{
    // تصنيفات الداخل والخارج. تقدر تزود أو تعدل هنا بس.
    public const CATEGORIES = [
        'income' => [
            'subscription' => 'اشتراك أطباء',
            'extra_storage' => 'مساحة إضافية',
            'other_income' => 'إيراد آخر',
        ],
        'expense' => [
            'hosting' => 'استضافة',
            'cloud_storage' => 'تخزين Cloudflare',
            'domain' => 'دومين',
            'marketing' => 'تسويق وإعلانات',
            'salaries' => 'مرتبات',
            'other_expense' => 'مصروف آخر',
        ],
    ];

    protected $fillable = ['type', 'category', 'title', 'amount', 'entry_date', 'note', 'created_by'];

    protected $casts = ['amount' => 'decimal:2', 'entry_date' => 'date'];

    public static function allCategories(): array
    {
        return self::CATEGORIES['income'] + self::CATEGORIES['expense'];
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::allCategories()[$this->category] ?? $this->category;
    }
}
