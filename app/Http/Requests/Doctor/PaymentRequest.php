<?php

namespace App\Http\Requests\Doctor;

use App\Models\Payment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PaymentRequest extends FormRequest
{
protected $errorBag = 'invoice';

    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * قواعد التحقق.
     */
    public function rules(): array
    {
        return [
            'party' => [
                'required',
                Rule::in(['patient', 'clinic']),
            ],

            'patient_id' => [
                'required_if:party,patient',
                'nullable',
                'integer',
            ],

            'type' => [
                'required_if:party,clinic',
                'nullable',
                Rule::in([
                    Payment::INCOME,
                    Payment::EXPENSE,
                ]),
            ],

            'title' => [
                'required',
                'string',
                'max:150',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:9999999',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    /**
     * الرسائل العربية.
     */
    public function messages(): array
    {
        return [
            'party.required' => 'من فضلك اختر جهة الدفع.',
            'party.in' => 'جهة الدفع المحددة غير صحيحة.',

            'patient_id.required_if' => 'من فضلك اختر المريض.',
            'patient_id.integer' => 'المريض المحدد غير صحيح.',

            'type.required_if' => 'من فضلك اختر نوع الدفع.',
            'type.in' => 'نوع الدفع المحدد غير صحيح.',

            'title.required' => 'من فضلك أدخل سبب الدفع.',
            'title.string' => 'سبب الدفع يجب أن يكون نصًا صحيحًا.',
            'title.max' => 'سبب الدفع يجب ألا يتجاوز 150 حرفًا.',

            'amount.required' => 'من فضلك أدخل المبلغ.',
            'amount.numeric' => 'المبلغ يجب أن يكون رقمًا صحيحًا.',
            'amount.min' => 'المبلغ يجب أن يكون أكبر من صفر.',
            'amount.max' => 'المبلغ كبير جدًا.',

            'notes.string' => 'الملاحظات يجب أن تكون نصًا صحيحًا.',
            'notes.max' => 'الملاحظات يجب ألا تتجاوز 1000 حرف.',
        ];
    }

    /**
     * أسماء الحقول بالعربي.
     */
    public function attributes(): array
    {
        return [
            'party' => 'جهة الدفع',
            'patient_id' => 'المريض',
            'type' => 'نوع الدفع',
            'title' => 'سبب الدفع',
            'amount' => 'المبلغ',
            'notes' => 'الملاحظات',
        ];
    }
}
