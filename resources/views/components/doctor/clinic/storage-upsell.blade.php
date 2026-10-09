@props(['stats'])

@php
    // الإعلان بيظهر بس لما يتبقى جيجا واحدة أو أقل، وبيتحول لأحمر لما المساحة تخلص.
    $show = $stats['remaining_bytes'] <= 1024 ** 3;
    $isFull = $stats['remaining_bytes'] <= 0;

    $ex = config('clinic.extra_storage');
    $extraGb = (int) $ex['unit_gb'];
    $monthlyPrice = (int) $ex['plans']['monthly']['price'];
    $yearlyPrice = (int) $ex['plans']['yearly']['price'];

    // رسالة الواتساب الجاهزة، فيها مساحة الدكتور الحالية عشان الدعم يرد بسرعة.
    $waText = "مرحبًا، أرغب في زيادة مساحة ملفات المرضى (+{$extraGb} GB: {$monthlyPrice} ج.م شهريًا أو {$yearlyPrice} ج.م سنويًا).\n"
        . "المساحة الحالية: {$stats['limit_label']}\n"
        . "المستخدم: {$stats['used_label']}\n"
        . "المتبقي: {$stats['remaining_label']}";
@endphp

@if ($show)
    <aside class="pf-upsell {{ $isFull ? 'pf-upsell--full' : '' }}" role="alert">

        <div class="pf-upsell__main">

            <span class="pf-upsell__icon">
                <i data-lucide="{{ $isFull ? 'alert-octagon' : 'alert-triangle' }}" class="size-5"></i>
            </span>

            <div class="min-w-0">

                <h3 class="pf-upsell__title">
                    {{ $isFull ? 'امتلأت مساحة ملفات المرضى' : 'مساحة ملفات المرضى على وشك الانتهاء' }}
                </h3>

                <p class="pf-upsell__text">
                    @if ($isFull)
                        لن تتمكن من رفع ملفات جديدة حتى تزيد المساحة أو تحذف ملفات قديمة.
                    @else
                        المتبقي لك
                        <b dir="ltr">{{ $stats['remaining_label'] }}</b>
                        فقط. زوّد مساحتك الآن حتى لا يتوقف رفع الملفات.
                    @endif
                </p>

                <div class="pf-upsell__chips">
                    <span class="pf-upsell__chip">كل {{ $extraGb }} جيجا إضافية</span>
                    <span class="pf-upsell__chip">{{ $monthlyPrice }} ج.م شهريًا</span>
                    <span class="pf-upsell__chip">{{ $yearlyPrice }} ج.م سنويًا</span>
                </div>

            </div>

        </div>

        <a href="{{ \App\Support\Whatsapp::link($waText) }}" target="_blank" rel="noopener noreferrer"
            class="pf-upsell__btn">
            <i data-lucide="message-circle" class="size-5"></i>
            <span>اضغط لزيادة المساحة</span>
        </a>

    </aside>
@endif
