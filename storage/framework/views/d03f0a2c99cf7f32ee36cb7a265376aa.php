        <header class="clinic-no-print sticky top-0 z-20 border-b border-border bg-surface/85"
            style="backdrop-filter:blur(8px)">
            <div class="flex h-16 items-center gap-2 px-3 sm:px-5">

                <button id="drawer-open" class="btn btn-ghost btn-icon lg:hidden" aria-label="القائمة">
                    <i data-lucide="menu" class="size-5"></i>
                </button>


                <div class="me-auto min-w-0">
                    <p class="truncate text-sm font-bold text-foreground">
                        نظام إدارة العيادة
                    </p>
                    <p class="hidden truncate text-xs text-muted-foreground sm:block">
                        دليل الأطباء
                    </p>
                </div>

                <button id="theme-toggle" class="btn btn-ghost btn-icon" aria-label="تبديل الوضع الليلي">
                    <i data-lucide="sun" id="theme-icon-sun" class="size-5" style="display:none"></i>
                    <i data-lucide="moon" id="theme-icon-moon" class="size-5"></i>
                </button>
                <a href="<?php echo e(route("clinic.dashboard")); ?>" aria-label="الحساب">
                    <span
                        class="grid size-9 place-items-center rounded-full bg-primary-soft text-sm font-bold text-primary">
                        <i data-lucide="user-round" class="size-4"></i>
                    </span>
                </a>
            </div>
        </header>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/doctor/clinic/header.blade.php ENDPATH**/ ?>