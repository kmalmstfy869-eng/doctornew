<aside id="clinic-sidebar"
    class="clinic-no-print fixed inset-y-0 right-0 z-50 w-64 border-l border-sidebar-border bg-sidebar shadow-raised translate-x-full transition-transform duration-300 lg:translate-x-0 lg:shadow-none">

    @php
        $isAssistant = (bool) Auth::user()?->doctorAssistant;
    @endphp

    <button id="drawer-close" type="button" aria-label="إغلاق القائمة"
        class="absolute left-3 top-3 z-10 grid size-8 place-items-center rounded-lg bg-muted text-muted-foreground lg:hidden">
        <i data-lucide="x" class="size-4"></i>
    </button>

    <div class="flex h-full flex-col">

        <div class="flex items-center gap-3 border-b border-sidebar-border px-4 py-4">

            <span
                class="grid size-10 shrink-0 place-items-center rounded-xl bg-sidebar-primary text-sidebar-primary-foreground">
                <i data-lucide="stethoscope" class="size-5"></i>
            </span>

            <div class="min-w-0">

                <p class="truncate text-sm font-bold text-sidebar-foreground">
                    دليل الأطباء
                </p>

                <p class="truncate text-xs text-muted-foreground">
                    نظام إدارة العيادة
                </p>

            </div>

        </div>

        <nav class="clinic-scroll-y flex-1 px-2.5 py-3">

            <div class="mb-3">

                <p class="px-2.5 pb-1.5 text-[11px] font-bold tracking-wide text-muted-foreground">
                    الرئيسية
                </p>

                <ul class="space-y-0.5">

                    <li>
                        <a href="{{ route('clinic.dashboard') }}"
                            class="flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm font-medium transition-colors {{ request()->routeIs('clinic.dashboard') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : 'text-sidebar-foreground hover:bg-sidebar-accent/60' }}">
                            <i data-lucide="layout-dashboard" class="size-4 shrink-0"></i>
                            <span class="truncate">لوحة التحكم</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('clinic.bookings.index') }}"
                            class="flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm font-medium transition-colors {{ request()->routeIs('clinic.bookings.*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : 'text-sidebar-foreground hover:bg-sidebar-accent/60' }}">
                            <i data-lucide="list-checks" class="size-4 shrink-0"></i>
                            <span class="truncate">إدارة الحجوزات لليوم</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('clinic.history') }}"
                            class="flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm font-medium transition-colors {{ request()->routeIs('clinic.history') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : 'text-sidebar-foreground hover:bg-sidebar-accent/60' }}">
                            <i data-lucide="activity" class="size-4 shrink-0"></i>
                            <span class="truncate">سجل كل الحجوزات</span>
                        </a>
                    </li>

                </ul>

            </div>

            @can('use-clinic-system')
                <div class="mb-3">

                    <p class="px-2.5 pb-1.5 text-[11px] font-bold tracking-wide text-muted-foreground">
                        كل ما يخص المرضى
                    </p>

                    <ul class="space-y-0.5">

                        <li>
                            <a href="{{ route('clinic.patients') }}"
                                class="flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm font-medium transition-colors {{ request()->routeIs('clinic.patients.*') || request()->routeIs('clinic.patients') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : 'text-sidebar-foreground hover:bg-sidebar-accent/60' }}">
                                <i data-lucide="activity" class="size-4 shrink-0"></i>
                                <i data-lucide="users" class="size-4 shrink-0"></i>
                                <span class="truncate">كل المرضى</span>
                            </a>
                        </li>

                        {{-- الملف الطبي (زيارات/روشتات/ملفات): ممنوع على مساعد الطبيب --}}
                        @unless ($isAssistant)
                            <li>
                                <a href="{{ route('clinic.visits.index') }}"
                                    class="flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm font-medium transition-colors {{ request()->routeIs('clinic.visits.*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : 'text-sidebar-foreground hover:bg-sidebar-accent/60' }}">

                                    <i data-lucide="stethoscope" class="size-4 shrink-0"></i>
                                    <span class="truncate">الزيارات</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('clinic.prescriptions.index') }}"
                                    class="flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm font-medium transition-colors {{ request()->routeIs('clinic.prescriptions.*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : 'text-sidebar-foreground hover:bg-sidebar-accent/60' }}">

                                    <i data-lucide="file-text" class="size-4 shrink-0"></i>
                                    <span class="truncate">الروشتات</span>
                                </a>
                            </li>

                            <li>
                                <a href="documents.html"
                                    class="flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm font-medium text-sidebar-foreground transition-colors hover:bg-sidebar-accent/60">
                                    <i data-lucide="folder" class="size-4 shrink-0"></i>
                                    <span class="truncate">الملفات الطبية</span>
                                </a>
                            </li>
                        @endunless

                    </ul>

                </div>
            @endcan

            <div class="mb-3">

                <p class="px-2.5 pb-1.5 text-[11px] font-bold tracking-wide text-muted-foreground">
                    الجدول
                </p>

                <ul class="space-y-0.5">

                    <li>
                        <a href="{{ route('clinic.schedules.index') }}"
                            class="flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm font-medium transition-colors {{ request()->routeIs('clinic.schedules.*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : 'text-sidebar-foreground hover:bg-sidebar-accent/60' }}">
                            <i data-lucide="calendar-days" class="size-4 shrink-0"></i>
                            <span class="truncate">مواعيد العيادة الاونلاين</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('clinic.slots.index') }}"
                            class="flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm font-medium transition-colors {{ request()->routeIs('clinic.slots.*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : 'text-sidebar-foreground hover:bg-sidebar-accent/60' }}">
                            <i data-lucide="calendar-clock" class="size-4 shrink-0"></i>
                            <span class="truncate">اداره مواعيد الاونلاين لكل يوم</span>
                        </a>
                    </li>

                </ul>

            </div>

            {{-- المالية: مقفولة تمامًا عن مساعد الطبيب --}}
            @if (Auth::user()?->doctor?->hasFeature('clinic_system') && !$isAssistant)
                <div class="mb-3">

                    <p class="px-2.5 pb-1.5 text-[11px] font-bold tracking-wide text-muted-foreground">
                        المالية
                    </p>

                    <ul class="space-y-0.5">

                        <li>
                            <a href="{{ route('clinic.payments.index') }}"
                                class="flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm font-medium transition-colors {{ request()->routeIs('clinic.payments.*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : 'text-sidebar-foreground hover:bg-sidebar-accent/60' }}">

                                <i data-lucide="receipt" class="size-4 shrink-0"></i>
                                <span class="truncate">المدفوعات والإيرادات</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('clinic.reports.index') }}"
                                class="flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm font-medium transition-colors {{ request()->routeIs('clinic.reports.*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : 'text-sidebar-foreground hover:bg-sidebar-accent/60' }}">

                                <i data-lucide="wallet" class="size-4 shrink-0"></i>
                                <span class="truncate">التقارير</span>
                            </a>
                        </li>

                    </ul>

                </div>
            @endif

            @if (Auth::user()?->doctor?->hasFeature('clinic_system'))
                <div class="mb-3">

                    <p class="px-2.5 pb-1.5 text-[11px] font-bold tracking-wide text-muted-foreground">
                        النظام
                    </p>

                    <ul class="space-y-0.5">

                        <li>
                            <a href="settings.html"
                                class="flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm font-medium text-sidebar-foreground transition-colors hover:bg-sidebar-accent/60">
                                <i data-lucide="settings" class="size-4 shrink-0"></i>
                                <span class="truncate">اعدادات الطباعه</span>
                            </a>
                        </li>

                        {{-- فريق العيادة (إدارة المساعدين): مقفول تمامًا عن مساعد الطبيب --}}
                        <li>
                            <a href="{{ route('clinic.assistants.index') }}"
                                class="flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm font-medium text-sidebar-foreground transition-colors hover:bg-sidebar-accent/60">
                                <i data-lucide="user-round-cog" class="size-4 shrink-0"></i>
                                <span class="truncate">فريق العيادة</span>
                            </a>
                        </li>

                    </ul>

                </div>
            @endif

        </nav>

        <div class="shrink-0 border-t border-sidebar-border p-3">

            <div class="flex items-center gap-2.5 rounded-xl bg-sidebar-accent/50 p-2.5">

                <span
                    class="grid size-9 shrink-0 place-items-center rounded-full bg-sidebar-primary text-sm font-bold text-sidebar-primary-foreground">
                    {{ mb_substr(Auth::user()->name, 0, 2) }}
                </span>

                <div class="min-w-0">

                    <p class="truncate text-xs font-bold text-sidebar-foreground">
                        {{ Auth::user()->name ?? 'مدير النظام' }}
                    </p>

                    <p class="truncate text-[11px] text-muted-foreground">
                        {{ Auth::user()?->doctor?->specialty?->name ?? '' }}
                    </p>

                </div>

            </div>

            @if (Auth::user()?->doctor?->hasFeature('clinic_system'))
                <a href="{{ route('doctor.dashboard', Auth::user()->doctor) }}"
                    class="group mt-2 flex w-full items-center justify-between rounded-xl border border-sidebar-border
                    bg-sidebar-accent/30 px-3 py-2.5 text-sidebar-foreground
                    transition-all duration-200
                    hover:border-sidebar-primary/30 hover:bg-sidebar-accent">

                    <div class="flex min-w-0 items-center gap-2.5">

                        <span
                            class="grid size-8 shrink-0 place-items-center rounded-lg
                            bg-sidebar-primary/10 text-sidebar-primary
                            transition-all duration-200
                            group-hover:bg-sidebar-primary group-hover:text-sidebar-primary-foreground">

                            <i data-lucide="external-link" class="size-4"></i>

                        </span>

                        <div class="min-w-0">

                            <p class="text-xs font-bold">
                                عرض ملفك على الموقع
                            </p>

                            <p class="mt-0.5 truncate text-[10px] text-muted-foreground">
                                الانتقال إلى صفحتك العامة
                            </p>

                        </div>

                    </div>

                    <i data-lucide="chevron-left"
                        class="size-4 shrink-0 text-muted-foreground transition-transform duration-200 group-hover:-translate-x-1">
                    </i>

                </a>
            @endif

            <form action="{{ route('logout') }}" method="POST" class="sidebar-logout-form mt-3">
                @csrf

                <button type="submit" class="sidebar-logout">
                    <span class="sidebar-logout-icon">
                        <i data-lucide="log-out" class="size-4"></i>
                    </span>

                    <span class="sidebar-logout-text">
                        تسجيل الخروج
                    </span>
                </button>
            </form>

        </div>

    </div>

</aside>
