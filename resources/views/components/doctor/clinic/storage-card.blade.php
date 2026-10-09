@props(['stats', 'compact' => false])

@php
    $level = $stats['percent'] >= 95 ? 'text-destructive' : ($stats['percent'] >= 80 ? 'text-warning' : 'text-primary');
@endphp

<section class="clinic-surface-card pf-storage {{ $compact ? 'pf-storage--compact' : '' }}" aria-label="مساحة ملفات المرضى">

    <div class="pf-storage__head">
        <div class="pf-storage__title">
            <span class="pf-storage__icon bg-primary-soft text-primary">
                <i data-lucide="hard-drive" class="size-5"></i>
            </span>
            <div class="min-w-0">
                <h2>مساحة ملفات المرضى</h2>
                <p class="pf-storage__sub text-muted-foreground tabular-nums" dir="ltr">
                    {{ $stats['used_label'] }} / {{ $stats['limit_label'] }}
                </p>
            </div>
        </div>

        @if (trim((string) $slot) !== '')
            <div class="pf-storage__action">{{ $slot }}</div>
        @endif
    </div>

    <div class="pf-storage__meter">
        <div class="pf-storage__bar {{ $level }}" role="progressbar" aria-valuemin="0" aria-valuemax="100"
            aria-valuenow="{{ $stats['percent'] }}">
            <span style="width: {{ max($stats['percent'], $stats['used_bytes'] > 0 ? 1 : 0) }}%"></span>
        </div>
        <span class="pf-storage__percent tabular-nums {{ $level }}">{{ $stats['percent'] }}%</span>
    </div>

    <dl class="pf-storage__stats">
        <div>
            <dt class="text-muted-foreground">المستخدم</dt>
            <dd class="tabular-nums" dir="ltr">{{ $stats['used_label'] }}</dd>
        </div>
        <div>
            <dt class="text-muted-foreground">المتبقي</dt>
            <dd class="tabular-nums" dir="ltr">{{ $stats['remaining_label'] }}</dd>
        </div>
        <div>
            <dt class="text-muted-foreground">الإجمالي</dt>
            <dd class="tabular-nums" dir="ltr">{{ $stats['limit_label'] }}</dd>
        </div>
    </dl>

</section>
