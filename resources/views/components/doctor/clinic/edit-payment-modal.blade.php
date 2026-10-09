@props([
    'booking' => null,
])

{{-- يتحمّل مرة واحدة بس مهما اتستدعى الـ component أو غيره --}}
@once('modal-variants-css')
    @push('extra_style')
        <link rel="stylesheet" href="{{ asset('css/clinic/modal_variants.css') }}">
    @endpush
@endonce

{{-- Edit Payment Modal --}}
<div
    id="edit-payment-modal"
    class="modal-overlay @if ($errors->payment->any()) open @endif"
    data-edit-payment-modal>

    <div class="modal-panel max-w-lg modal-panel--edit">

        {{-- Header --}}
        <div class="modal-head">

            <span class="modal-head__icon">
                <i
                    data-lucide="wallet"
                    class="h-5 w-5">
                </i>
            </span>

            <div class="min-w-0 flex-1">

                <h3 class="modal-head__title">
                    تعديل الدفع
                </h3>

                <p
                    id="edit-payment-patient"
                    class="modal-head__sub truncate">
                </p>

            </div>

            <button
                type="button"
                class="btn btn-icon shrink-0"
                data-modal-close
                aria-label="إغلاق">

                <i
                    data-lucide="x"
                    class="h-5 w-5">
                </i>

            </button>

        </div>


        {{-- Form --}}
        <form
            method="POST"
            id="edit-payment-form"
            data-edit-payment-form
            action="{{ $errors->payment->any() && old('_payment_booking_id') ? route('clinic.bookings.payment', old('_payment_booking_id')) : '' }}">

            @csrf

            @method('PATCH')

            <input
                type="hidden"
                name="_payment_booking_id"
                value="{{ old('_payment_booking_id') }}">


            {{-- السعر الإجمالي --}}
            <div>

                <label
                    for="edit-payment-price"
                    class="field-label">

                    السعر الإجمالي

                </label>

                <input
                    name="price"
                    id="edit-payment-price"
                    type="number"
                    min="0"
                    step="0.01"
                    inputmode="decimal"
                    class="field-input mt-2 @error('price', 'payment') border-red-500 @enderror"
                    value="{{ old('price') }}"
                    required>

                @error('price', 'payment')

                    <p class="bq-field-error">

                        <i
                            data-lucide="circle-alert"
                            class="h-4 w-4 shrink-0">
                        </i>

                        <span>
                            {{ $message }}
                        </span>

                    </p>

                @enderror

            </div>


            {{-- المدفوع --}}
            <div class="mt-4">

                <label
                    for="edit-payment-paid"
                    class="field-label">

                    إجمالي المدفوع حتى الآن

                </label>

                <input
                    name="paid"
                    id="edit-payment-paid"
                    type="number"
                    min="0"
                    step="0.01"
                    inputmode="decimal"
                    class="field-input mt-2 @error('paid', 'payment') border-red-500 @enderror"
                    value="{{ old('paid') }}"
                    required>

                @error('paid', 'payment')

                    <p class="bq-field-error">

                        <i
                            data-lucide="circle-alert"
                            class="h-4 w-4 shrink-0">
                        </i>

                        <span>
                            {{ $message }}
                        </span>

                    </p>

                @enderror

            </div>


            {{-- توضيح --}}
            <p class="mt-3 text-xs leading-5 text-muted-foreground">

                المبلغ المدفوع هو إجمالي ما دفعه المريض حتى الآن،
                وليس قيمة الدفعة الجديدة فقط.

            </p>


            {{-- Preview --}}
            <div class="bq-pay-row mt-5">

                {{-- الإجمالي --}}
                <div>

                    <span class="text-sm text-muted-foreground">
                        إجمالي السعر
                    </span>

                    <strong
                        id="edit-payment-total-preview"
                        class="text-foreground">

                        0 ج.م

                    </strong>

                </div>


                {{-- المدفوع --}}
                <div>

                    <span class="text-sm text-muted-foreground">
                        المدفوع
                    </span>

                    <strong
                        id="edit-payment-paid-preview"
                        class="text-success">

                        0 ج.م

                    </strong>

                </div>


                {{-- المتبقي --}}
                <div>

                    <span class="text-sm text-muted-foreground">
                        المتبقي
                    </span>

                    <strong
                        id="edit-payment-remaining-preview"
                        class="text-warning">

                        0 ج.م

                    </strong>

                </div>

            </div>


            {{-- Footer --}}
            <div class="bq-modal-footer">

                <button
                    type="button"
                    class="btn btn-ghost"
                    data-modal-close>

                    إلغاء

                </button>

                <button
                    type="submit"
                    class="btn btn-primary btn-submit">

                    <i
                        data-lucide="save"
                        class="h-4 w-4">
                    </i>

                    <span>
                        حفظ التعديل

                    </span>

                </button>

            </div>

        </form>

    </div>

</div>