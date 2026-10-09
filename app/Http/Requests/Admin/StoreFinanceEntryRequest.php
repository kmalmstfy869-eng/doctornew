<?php

namespace App\Http\Requests\Admin;

use App\Models\FinanceEntry;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFinanceEntryRequest extends FormRequest
{
    // الأخطاء بتتحط في bag مخصوص عشان تظهر في المودال بس.
    protected $errorBag = 'financeStore';

    public function authorize(): bool
    {
        return true; // الحماية من middleware الأدمن
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => is_string($this->title) ? trim($this->title) : $this->title,
            'note' => is_string($this->note) ? trim($this->note) : $this->note,
        ]);
    }

    public function rules(): array
    {
        $allowed = array_keys(FinanceEntry::CATEGORIES[$this->input('type')] ?? []);

        return [
            'type' => ['required', 'in:income,expense'],
            'category' => ['required', 'string', Rule::in($allowed)],
            'title' => ['required', 'string', 'max:150'],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:100000000'],
            'entry_date' => ['required', 'date_format:Y-m-d'],
            'note' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'اختار نوع الحركة.',
            'type.in' => 'نوع الحركة غير صحيح.',

            'category.required' => 'اختار التصنيف.',
            'category.string' => 'التصنيف غير صحيح.',
            'category.in' => 'التصنيف مش مناسب لنوع الحركة.',

            'title.required' => 'اكتب البيان.',
            'title.string' => 'البيان لازم يكون نص.',
            'title.max' => 'البيان طويل جدًا (الحد الأقصى 150 حرف).',

            'amount.required' => 'اكتب المبلغ.',
            'amount.numeric' => 'المبلغ لازم يكون رقم.',
            'amount.min' => 'المبلغ لازم يكون أكبر من صفر.',
            'amount.max' => 'المبلغ كبير أوي، راجع الرقم.',

            'entry_date.required' => 'اختار التاريخ.',
            'entry_date.date_format' => 'التاريخ غير صحيح.',

            'note.string' => 'الملاحظة لازم تكون نص.',
            'note.max' => 'الملاحظة طويلة جدًا (الحد الأقصى 1000 حرف).',
        ];
    }
}
