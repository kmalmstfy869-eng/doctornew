@props(['doctor'])

<template id="bq-print-header-tpl">
    <header class="bq-sheet-header">

        <div class="bq-sheet-strip"></div>

        <div class="bq-sheet-head-inner">

            {{-- اسم العيادة --}}
            @if (!blank($doctor?->clinic_name))
                <p class="bq-sheet-clinic">
                    {{ $doctor->clinic_name }}
                </p>
            @endif

            {{-- اسم الدكتور --}}
            <h1 class="bq-sheet-dr-name">
                <span>
                    د. {{ $doctor?->user?->name ?? Auth::user()?->name ?? '' }}
                </span>
            </h1>

            {{-- التخصص --}}
            @if (!blank($doctor?->specialty?->title))
                <p class="bq-sheet-spec">
                    {{ $doctor->specialty->title }}
                </p>
            @endif

        </div>

        {{-- بيانات التواصل --}}
        <div class="bq-sheet-contact">

            @if (!blank($doctor?->phone))
                <span>
                    <svg viewBox="0 0 24 24" width="12" height="12"
                        fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07
                            19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67
                            A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72
                            c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11
                            L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27
                            a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7
                            A2 2 0 0 1 22 16.92z" />
                    </svg>

                    <span>{{ $doctor->phone }}</span>
                </span>
            @endif

            @if (!blank($doctor?->whatsapp))
                <span>
                    <svg viewBox="0 0 24 24" width="12" height="12"
                        fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M21 11.5a8.38 8.38 0 0 1-.9 3.8
                            8.5 8.5 0 0 1-7.6 4.7
                            8.38 8.38 0 0 1-3.8-.9
                            L3 21l1.9-5.7
                            a8.38 8.38 0 0 1-.9-3.8
                            8.5 8.5 0 0 1 4.7-7.6
                            8.38 8.38 0 0 1 3.8-.9h.5
                            a8.48 8.48 0 0 1 8 8z" />
                    </svg>

                    <span>{{ $doctor->whatsapp }}</span>
                </span>
            @endif

            @if (!blank($doctor?->address))
                <span>
                    <svg viewBox="0 0 24 24" width="12" height="12"
                        fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 0 1 16 0Z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>

                    <span>{{ $doctor->address }}</span>
                </span>
            @endif

        </div>

    </header>
</template>


<template id="bq-print-footer-tpl">
    <footer class="bq-sheet-footer">

        <div class="bq-sheet-footer-bar">

            <div class="bq-sheet-footer-text">

                <strong>
                    دليل الأطباء
                </strong>

                <span>
                    شركة MK
                </span>

            </div>

            <div class="bq-sheet-footer-icon">
                <svg viewBox="0 0 24 24" width="20" height="20"
                    fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">

                    <path d="M11 2v2" />
                    <path d="M5 2v2" />

                    <path
                        d="M5 3H4a2 2 0 0 0-2 2v4a6 6 0 0 0 12 0V5a2 2 0 0 0-2-2h-1" />

                    <path d="M8 15a6 6 0 0 0 12 0v-3" />

                    <circle cx="20" cy="10" r="2" />

                </svg>
            </div>

        </div>

    </footer>
</template>
