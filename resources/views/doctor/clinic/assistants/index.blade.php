@extends('doctor.layouts.app_clinc')

@section('title', 'مساعدو الطبيب | دليل الأطباء')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/doctor/clinic/clinic-assistants.css') }}">
    <link rel="stylesheet" href="{{ asset('css/clinic/modal_variants.css') }}">
@endpush

@section('content')

    <div class="w-full min-w-0 px-4 py-6 sm:px-6 lg:px-8">

        <div class="mx-auto w-full max-w-[1360px]">

            <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                <div>

                    <h1 class="text-2xl font-bold tracking-tight text-foreground sm:text-3xl">
                        مساعدو الطبيب

                    </h1>

                    <p class="mt-1 text-sm text-muted-foreground">
                        إدارة مساعدي الطبيب وحساباتهم داخل نظام العيادة.
                    </p>

                </div>

                @if ($assistants->count() < 5)
                    <div class="flex flex-wrap items-center gap-2">

                        <button type="button" class="btn btn-default" data-modal-open="add-assistant-modal">

                            <i data-lucide="user-plus" class="h-4 w-4"></i>

                            إضافة مساعد

                        </button>

                    </div>
                @endif

            </div>


            {{-- =========================================================
                 فورم تعديل بيانات المساعد
            ========================================================== --}}

            <div id="assistant-edit-panel"
                class="clinic-surface-card modal-panel--edit mb-6 p-4 sm:p-6 {{ old('_form') === 'edit' ? '' : 'hidden' }}">

                <div class="modal-head">

                    <span class="modal-head__icon">
                        <i data-lucide="pencil" class="h-5 w-5"></i>
                    </span>

                    <div class="min-w-0">

                        <h2 class="modal-head__title">
                            تعديل بيانات المساعد
                        </h2>

                        <p id="assistant-edit-subtitle" class="modal-head__sub">
                            {{ old('_form') === 'edit' ? old('name') : '' }}
                        </p>

                    </div>

                    <button type="button" class="btn btn-icon ms-auto" id="assistant-edit-close" title="إغلاق"
                        aria-label="إغلاق">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>

                </div>


                <form method="POST"
                    action="{{ old('_form') === 'edit' && old('assistant_id') ? route('clinic.assistants.update', old('assistant_id')) : '#' }}"
                    id="assistant-edit-form">

                    @csrf
                    @method('PUT')

                    <input type="hidden" name="_form" value="edit">

                    <input type="hidden" name="assistant_id" id="assistant-edit-id"
                        value="{{ old('_form') === 'edit' ? old('assistant_id') : '' }}">

                    <div class="grid gap-4 sm:grid-cols-2">

                        <div>

                            <label class="field-label">
                                الاسم
                            </label>

                            <div class="relative mt-2">

                                <input type="text" name="name" id="assistant-edit-name"
                                    class="field-input pr-10 {{ old('_form') === 'edit' && $errors->has('name') ? 'border-red-500' : '' }}"
                                    value="{{ old('_form') === 'edit' ? old('name') : '' }}">

                            </div>

                            @if (old('_form') === 'edit' && $errors->has('name'))
                                <p class="mt-1.5 text-xs text-red-500">
                                    {{ $errors->first('name') }}
                                </p>
                            @endif

                        </div>


                        <div>

                            <label class="field-label">
                                البريد الإلكتروني
                            </label>

                            <div class="relative mt-2">

                                <input type="email" name="email" id="assistant-edit-email" dir="ltr"
                                    class="field-input pr-10 {{ old('_form') === 'edit' && $errors->has('email') ? 'border-red-500' : '' }}"
                                    value="{{ old('_form') === 'edit' ? old('email') : '' }}">

                            </div>

                            @if (old('_form') === 'edit' && $errors->has('email'))
                                <p class="mt-1.5 text-xs text-red-500">
                                    {{ $errors->first('email') }}
                                </p>
                            @endif

                            <p class="mt-1.5 text-[11px] leading-5 text-muted-foreground">
                                عند تغيير البريد يظل البريد الحالي هو المعتمد حتى يضغط المساعد على رابط التأكيد
                                المرسل إلى البريد الجديد.
                            </p>

                        </div>


                        <div>

                            <label class="field-label">
                                رقم الهاتف
                            </label>

                            <div class="relative mt-2">

                                <input type="text" name="phone" id="assistant-edit-phone" inputmode="tel"
                                    dir="ltr"
                                    class="field-input pr-10 {{ old('_form') === 'edit' && $errors->has('phone') ? 'border-red-500' : '' }}"
                                    value="{{ old('_form') === 'edit' ? old('phone') : '' }}">

                            </div>

                            @if (old('_form') === 'edit' && $errors->has('phone'))
                                <p class="mt-1.5 text-xs text-red-500">
                                    {{ $errors->first('phone') }}
                                </p>
                            @endif

                        </div>


                        <div>

                            <label class="field-label">
                                حالة الحساب
                            </label>

                            <select name="status" id="assistant-edit-status"
                                class="field-select mt-2 {{ old('_form') === 'edit' && $errors->has('status') ? 'border-red-500' : '' }}">

                                <option value="active" @selected(old('_form') === 'edit' && old('status') === 'active')>
                                    نشط
                                </option>

                                <option value="inactive" @selected(old('_form') === 'edit' && old('status') === 'inactive')>
                                    معطل
                                </option>

                            </select>

                            @if (old('_form') === 'edit' && $errors->has('status'))
                                <p class="mt-1.5 text-xs text-red-500">
                                    {{ $errors->first('status') }}
                                </p>
                            @endif

                        </div>

                    </div>


                    <div class="mt-5 rounded-xl border border-border p-4">

                        <button type="button" id="assistant-toggle-password"
                            class="flex w-full items-center justify-between gap-3 text-start">

                            <span>

                                <span class="block text-sm font-semibold text-foreground">
                                    تغيير كلمة المرور
                                </span>

                                <span class="mt-1 block text-xs text-muted-foreground">
                                    اترك الحقول فارغة إذا كنت لا تريد تغيير كلمة المرور.
                                </span>

                            </span>

                            <i data-lucide="chevron-down" class="h-4 w-4 shrink-0 assistant-toggle-icon"
                                id="assistant-toggle-password-icon"></i>

                        </button>


                        <div id="assistant-password-fields"
                            class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 {{ old('_form') === 'edit' && $errors->has('password') ? '' : 'hidden' }}">

                            <div>

                                <label class="field-label">
                                    كلمة المرور الجديدة
                                </label>

                                <div class="relative mt-2">

                                    <input type="password" name="password" id="assistant-edit-password"
                                        class="field-input pr-10 {{ old('_form') === 'edit' && $errors->has('password') ? 'border-red-500' : '' }}"
                                        placeholder="••••••••">

                                    <button type="button" class="password-eye"
                                        data-password-toggle="assistant-edit-password" aria-label="إظهار كلمة المرور">
                                        <i data-lucide="eye" class="h-4 w-4"></i>
                                    </button>

                                </div>

                                @if (old('_form') === 'edit' && $errors->has('password'))
                                    <p class="mt-1.5 text-xs text-red-500">
                                        {{ $errors->first('password') }}
                                    </p>
                                @endif

                            </div>


                            <div>

                                <label class="field-label">
                                    تأكيد كلمة المرور
                                </label>

                                <div class="relative mt-2">

                                    <input type="password" name="password_confirmation"
                                        id="assistant-edit-password-confirmation" class="field-input pr-10"
                                        placeholder="••••••••">

                                    <button type="button" class="password-eye"
                                        data-password-toggle="assistant-edit-password-confirmation"
                                        aria-label="إظهار كلمة المرور">
                                        <i data-lucide="eye" class="h-4 w-4"></i>
                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="bq-modal-footer">

                        <button type="button" class="btn btn-outline" id="assistant-edit-cancel">
                            إلغاء
                        </button>

                        <button type="submit" class="btn btn-default btn-submit">

                            <i data-lucide="save" class="h-4 w-4"></i>

                            حفظ التعديلات

                        </button>

                    </div>

                </form>

            </div>


            @if ($assistants->isNotEmpty())

                {{-- الإحصائيات --}}
                <div class="mb-6">

                    <div class="clinic-surface-card overflow-hidden">

                        <div
                            class="grid grid-cols-1 divide-y divide-border sm:grid-cols-3 sm:divide-x sm:divide-y-0 sm:divide-x-reverse">

                            <div class="flex items-center gap-3 p-4">

                                <div class="badge-info flex h-9 w-9 shrink-0 items-center justify-center rounded-lg">

                                    <i data-lucide="users-round" class="h-4 w-4"></i>

                                </div>

                                <div>

                                    <p class="text-xs text-muted-foreground">
                                        إجمالي المساعدين
                                    </p>

                                    <div class="mt-0.5 flex items-baseline gap-1.5">

                                        <p class="text-lg font-bold text-foreground">
                                            {{ $assistants->count() }}
                                        </p>

                                        <span class="text-xs font-medium text-muted-foreground">
                                            من أصل 5
                                        </span>

                                    </div>

                                    <p class="mt-1 text-[11px] text-muted-foreground">
                                        الحد الأقصى المسموح به 5 مساعدين
                                    </p>

                                </div>

                            </div>


                            <div class="flex items-center gap-3 p-4">

                                <div class="badge-success flex h-9 w-9 shrink-0 items-center justify-center rounded-lg">

                                    <i data-lucide="circle-check-big" class="h-4 w-4"></i>

                                </div>

                                <div>

                                    <p class="text-xs text-muted-foreground">
                                        الحسابات النشطة
                                    </p>

                                    <p class="mt-0.5 text-lg font-bold text-foreground">
                                        {{ $active_assistants }}
                                    </p>

                                </div>

                            </div>


                            <div class="flex items-center gap-3 p-4">

                                <div class="badge-danger flex h-9 w-9 shrink-0 items-center justify-center rounded-lg">

                                    <i data-lucide="circle-x" class="h-4 w-4"></i>

                                </div>

                                <div>

                                    <p class="text-xs text-muted-foreground">
                                        الحسابات المعطلة
                                    </p>

                                    <p class="mt-0.5 text-lg font-bold text-foreground">
                                        {{ $assistants->count() - $active_assistants }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- قائمة المساعدين --}}
                <div class="clinic-surface-card overflow-hidden">

                    <div class="section-card-header">

                        <div>

                            <h2 class="text-lg font-bold text-foreground">
                                قائمة المساعدين
                            </h2>

                            <p class="mt-1 text-sm text-muted-foreground">
                                جميع مساعدي الطبيب المسجلين في النظام.
                            </p>

                        </div>

                        <span class="badge badge-info">

                            {{ $assistants->count() }}

                            {{ $assistants->count() == 1 ? 'مساعد' : 'مساعدين' }}

                        </span>

                    </div>


                    {{-- Desktop --}}
                    <div class="hidden overflow-x-auto lg:block">

                        <table class="clinic-table w-full">

                            <thead>

                                <tr>

                                    <th>الاسم</th>

                                    <th>البريد الإلكتروني</th>

                                    <th>رقم الهاتف</th>

                                    <th>تاريخ الإضافة</th>

                                    <th>الحالة</th>

                                    <th class="text-center">
                                        إجراءات
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($assistants as $assistant)
                                    <tr>

                                        <td>

                                            <div class="flex min-w-[180px] items-center gap-3">

                                                <div
                                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary-soft text-sm font-bold text-primary">

                                                    {{ mb_substr($assistant->user?->name ?? 'مساعد', 0, 2) }}

                                                </div>

                                                <div class="min-w-0">

                                                    <div class="truncate font-semibold text-foreground">
                                                        {{ $assistant->user?->name ?? 'لا يوجد اسم للمساعد' }}
                                                    </div>

                                                    <div class="mt-0.5 text-xs text-muted-foreground">
                                                        مساعد طبيب
                                                    </div>

                                                </div>

                                            </div>

                                        </td>


                                        <td>

                                            <span class="whitespace-nowrap text-sm text-foreground">
                                                {{ $assistant->user?->email ?? 'لا يوجد بريد إلكتروني للمساعد' }}
                                            </span>

                                            @if ($assistant->user?->hasValidPendingEmail())
                                                <div class="max-w-[290px]">

                                                    <div class="assistant-pending-email">

                                                        <i data-lucide="mail-check"
                                                            class="assistant-pending-icon h-4 w-4"></i>

                                                        <div class="min-w-0">

                                                            <p class="text-xs font-bold text-foreground">
                                                                في انتظار تأكيد البريد الجديد
                                                            </p>

                                                            <p class="assistant-pending-address text-xs font-semibold text-foreground"
                                                                dir="ltr">
                                                                {{ $assistant->user->pending_email }}
                                                            </p>

                                                            <p class="text-[11px] leading-5 text-muted-foreground">
                                                                لن يتغير بريد المساعد الحالي إلا بعد أن يفتح الرسالة
                                                                المرسلة إلى هذا البريد ويضغط على رابط التأكيد.
                                                            </p>

                                                            <p class="assistant-pending-time text-[11px]">
                                                                <i data-lucide="clock" class="h-3 w-3"></i>
                                                                ينتهي الطلب
                                                                {{ $assistant->user->pending_email_requested_at->copy()->addMinutes(\App\Models\User::PENDING_EMAIL_TTL_MINUTES)->diffForHumans() }}
                                                            </p>

                                                        </div>

                                                    </div>

                                                </div>
                                            @endif

                                        </td>


                                        <td>

                                            <span class="whitespace-nowrap text-sm text-foreground" dir="ltr">
                                                {{ $assistant->phone ?? 'لا يوجد رقم هاتف للمساعد' }}
                                            </span>

                                        </td>


                                        <td>

                                            <span class="whitespace-nowrap text-sm text-muted-foreground">
                                                {{ $assistant->created_at?->format('Y-m-d') ?? 'لا يوجد تاريخ إضافة' }}
                                            </span>

                                        </td>


                                        <td>

                                            @if ($assistant->is_active)
                                                <span class="badge badge-success">
                                                    نشط
                                                </span>
                                            @else
                                                <span class="badge badge-danger">
                                                    معطل
                                                </span>
                                            @endif

                                        </td>


                                        <td>

                                            <div class="flex items-center justify-center gap-1.5">

                                                <button type="button" class="btn btn-icon-sm" title="تعديل"
                                                    data-edit-assistant data-id="{{ $assistant->id }}"
                                                    data-name="{{ $assistant->user?->name }}"
                                                    data-email="{{ $assistant->user?->email }}"
                                                    data-phone="{{ $assistant->phone }}"
                                                    data-status="{{ $assistant->is_active ? 'active' : 'inactive' }}">

                                                    <i data-lucide="pencil" class="h-4 w-4"></i>

                                                </button>


                                                <form method="POST"
                                                    action="{{ route('clinic.assistants.toggle-status', $assistant) }}"
                                                    onsubmit="return confirm('{{ $assistant->is_active ? 'هل تريد تعطيل حساب هذا المساعد؟' : 'هل تريد تفعيل حساب هذا المساعد؟' }}')">

                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="submit" class="btn btn-icon-sm"
                                                        title="{{ $assistant->is_active ? 'تعطيل الحساب' : 'تفعيل الحساب' }}">

                                                        <i data-lucide="{{ $assistant->is_active ? 'power-off' : 'power' }}"
                                                            class="h-4 w-4"></i>

                                                    </button>

                                                </form>


                                                <button type="button" class="btn btn-icon-sm text-destructive"
                                                    title="حذف" data-delete-assistant data-id="{{ $assistant->id }}"
                                                    data-name="{{ $assistant->user?->name }}">

                                                    <i data-lucide="trash-2" class="h-4 w-4"></i>

                                                </button>

                                            </div>

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    {{-- Mobile --}}
                    <div class="grid gap-3 p-4 lg:hidden">

                        @foreach ($assistants as $assistant)
                            <div class="clinic-surface-card border border-border p-4">

                                <div class="flex items-start justify-between gap-3">

                                    <div class="flex min-w-0 items-center gap-3">

                                        <div
                                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary-soft text-sm font-bold text-primary">

                                            {{ mb_substr($assistant->user?->name ?? 'مساعد', 0, 2) }}

                                        </div>

                                        <div class="min-w-0">

                                            <h3 class="truncate font-bold text-foreground">
                                                {{ $assistant->user?->name ?? 'لا يوجد اسم للمساعد' }}
                                            </h3>

                                            <p class="mt-0.5 text-xs text-muted-foreground">
                                                مساعد طبيب
                                            </p>

                                        </div>

                                    </div>


                                    @if ($assistant->is_active)
                                        <span class="badge badge-success shrink-0">
                                            نشط
                                        </span>
                                    @else
                                        <span class="badge badge-danger shrink-0">
                                            معطل
                                        </span>
                                    @endif

                                </div>


                                <div class="mt-4 grid grid-cols-1 gap-3">

                                    <div class="rounded-xl bg-muted p-3">

                                        <p class="text-xs text-muted-foreground">
                                            البريد الإلكتروني
                                        </p>

                                        <p class="mt-1 truncate text-sm font-semibold text-foreground">
                                            {{ $assistant->user?->email ?? 'لا يوجد بريد إلكتروني للمساعد' }}
                                        </p>

                                        @if ($assistant->user?->hasValidPendingEmail())
                                            <div class="assistant-pending-email">

                                                <i data-lucide="mail-check" class="assistant-pending-icon h-4 w-4"></i>

                                                <div class="min-w-0">

                                                    <p class="text-xs font-bold text-foreground">
                                                        في انتظار تأكيد البريد الجديد
                                                    </p>

                                                    <p class="assistant-pending-address text-xs font-semibold text-foreground"
                                                        dir="ltr">
                                                        {{ $assistant->user->pending_email }}
                                                    </p>

                                                    <p class="text-[11px] leading-5 text-muted-foreground">
                                                        لن يتغير بريد المساعد الحالي إلا بعد أن يفتح الرسالة
                                                        المرسلة إلى هذا البريد ويضغط على رابط التأكيد.
                                                    </p>

                                                    <p class="assistant-pending-time text-[11px]">
                                                        <i data-lucide="clock" class="h-3 w-3"></i>
                                                        ينتهي الطلب
                                                        {{ $assistant->user->pending_email_requested_at->copy()->addMinutes(\App\Models\User::PENDING_EMAIL_TTL_MINUTES)->diffForHumans() }}
                                                    </p>

                                                </div>

                                            </div>
                                        @endif

                                    </div>


                                    <div class="grid grid-cols-2 gap-3">

                                        <div class="rounded-xl bg-muted p-3">

                                            <p class="text-xs text-muted-foreground">
                                                رقم الهاتف
                                            </p>

                                            <p class="mt-1 text-sm font-semibold text-foreground" dir="ltr">
                                                {{ $assistant->phone ?? 'لا يوجد رقم هاتف للمساعد' }}
                                            </p>

                                        </div>


                                        <div class="rounded-xl bg-muted p-3">

                                            <p class="text-xs text-muted-foreground">
                                                تاريخ الإضافة
                                            </p>

                                            <p class="mt-1 text-sm font-semibold text-foreground">
                                                {{ $assistant->created_at?->format('Y-m-d') ?? 'لا يوجد تاريخ إضافة' }}
                                            </p>

                                        </div>

                                    </div>

                                </div>


                                <div class="mt-3 flex items-center gap-2 border-t border-border pt-3">

                                    <button type="button" class="btn btn-outline btn-sm w-full" data-edit-assistant
                                        data-id="{{ $assistant->id }}" data-name="{{ $assistant->user?->name }}"
                                        data-email="{{ $assistant->user?->email }}" data-phone="{{ $assistant->phone }}"
                                        data-status="{{ $assistant->is_active ? 'active' : 'inactive' }}">

                                        <i data-lucide="pencil" class="h-4 w-4"></i>

                                        تعديل

                                    </button>


                                    <form method="POST" class="w-full"
                                        action="{{ route('clinic.assistants.toggle-status', $assistant) }}"
                                        onsubmit="return confirm('{{ $assistant->is_active ? 'هل تريد تعطيل حساب هذا المساعد؟' : 'هل تريد تفعيل حساب هذا المساعد؟' }}')">

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="btn btn-outline btn-sm w-full">

                                            <i data-lucide="{{ $assistant->is_active ? 'power-off' : 'power' }}"
                                                class="h-4 w-4"></i>

                                            {{ $assistant->is_active ? 'تعطيل' : 'تفعيل' }}

                                        </button>

                                    </form>


                                    <button type="button" class="btn btn-destructive btn-sm w-full" data-delete-assistant
                                        data-id="{{ $assistant->id }}" data-name="{{ $assistant->user?->name }}">

                                        <i data-lucide="trash-2" class="h-4 w-4"></i>

                                        حذف

                                    </button>

                                </div>

                            </div>
                        @endforeach

                    </div>

                </div>
            @else
                {{-- لا يوجد مساعدين --}}
                <div class="clinic-surface-card overflow-hidden">

                    <div class="p-4 sm:p-5">

                        <x-home.banner.no_results logo="fa-solid fa-user-nurse" title="لا يوجد مساعدين حتى الآن"
                            content="لم تقم بإضافة أي مساعدين لعيادتك حتى الآن." />

                        <div class="mt-4 flex justify-center">

                            <button type="button" class="btn btn-default" data-modal-open="add-assistant-modal">

                                <i data-lucide="user-round-plus" class="h-4 w-4"></i>

                                إضافة أول مساعد

                            </button>

                        </div>

                    </div>

                </div>

            @endif

        </div>

    </div>



    {{-- =========================================================
     إضافة مساعد
========================================================== --}}
<div id="add-assistant-modal" class="modal-overlay {{ $errors->assistantAdd->any() ? 'open active' : '' }}">

        <div class="modal-panel modal-lg modal-panel--create">

            <div class="modal-head">

                <span class="modal-head__icon">
                    <i data-lucide="user-plus" class="h-5 w-5"></i>
                </span>

                <div class="min-w-0">

                    <h3 class="modal-head__title">
                        إضافة مساعد جديد
                    </h3>

                    <p class="modal-head__sub">
                        أنشئ حسابًا جديدًا لمساعد الطبيب للوصول إلى نظام العيادة.
                    </p>

                </div>

                <button type="button" class="btn btn-icon ms-auto" data-modal-close>
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>

            </div>


            <form method="POST" action="{{ route('clinic.assistants.store') }}" id="add-assistant-form">

                @csrf

                <input type="hidden" name="_form" value="add">


                <div>

                    <label class="field-label">
                        الاسم الكامل
                    </label>

                    <div class="relative mt-2">

                        <input type="text" name="name"
                            class="field-input pr-10 {{ $errors->assistantAdd->has('name') ? 'border-red-500' : '' }}"
                            placeholder="اكتب الاسم الكامل" value="{{ old('_form') === 'add' ? old('name') : '' }}">

                    </div>

                    @if ($errors->assistantAdd->has('name'))
                        <p class="mt-1.5 text-xs text-red-500">
                            {{ $errors->assistantAdd->first('name') }}
                        </p>
                    @endif

                </div>


                <div class="mt-4">

                    <label class="field-label">
                        البريد الإلكتروني
                    </label>

                    <div class="relative mt-2">

                        <input type="email" name="email" dir="ltr"
                            class="field-input pr-10 {{ $errors->assistantAdd->has('email') ? 'border-red-500' : '' }}"
                            placeholder="example@mail.com" value="{{ old('_form') === 'add' ? old('email') : '' }}">

                    </div>

                    @if ($errors->assistantAdd->has('email'))
                        <p class="mt-1.5 text-xs text-red-500">
                            {{ $errors->assistantAdd->first('email') }}
                        </p>
                    @endif

                </div>


                <div class="mt-4">

                    <label class="field-label">
                        رقم الهاتف
                    </label>

                    <div class="relative mt-2">

                        <input type="text" name="phone" inputmode="tel" dir="ltr" maxlength="11"
                            class="field-input pr-10 {{ $errors->assistantAdd->has('phone') ? 'border-red-500' : '' }}"
                            placeholder="01xxxxxxxxx" value="{{ old('_form') === 'add' ? old('phone') : '' }}">

                    </div>

                    @if ($errors->assistantAdd->has('phone'))
                        <p class="mt-1.5 text-xs text-red-500">
                            {{ $errors->assistantAdd->first('phone') }}
                        </p>
                    @endif

                </div>


                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">

                    <div>

                        <label class="field-label">
                            كلمة المرور
                        </label>

                        <div class="relative mt-2">

                            <input type="password" name="password" id="assistant-add-password"
                                class="field-input pr-10 {{ $errors->assistantAdd->has('password') ? 'border-red-500' : '' }}"
                                placeholder="••••••••">

                            <button type="button" class="password-eye" data-password-toggle="assistant-add-password"
                                aria-label="إظهار كلمة المرور">
                                <i data-lucide="eye" class="h-4 w-4"></i>
                            </button>

                        </div>

                        @if ($errors->assistantAdd->has('password'))
                            <p class="mt-1.5 text-xs text-red-500">
                                {{ $errors->assistantAdd->first('password') }}
                            </p>
                        @endif

                    </div>


                    <div>

                        <label class="field-label">
                            تأكيد كلمة المرور
                        </label>

                        <div class="relative mt-2">

                            <input type="password" name="password_confirmation" id="assistant-add-password-confirmation"
                                class="field-input pr-10" placeholder="••••••••">

                            <button type="button" class="password-eye"
                                data-password-toggle="assistant-add-password-confirmation" aria-label="إظهار كلمة المرور">
                                <i data-lucide="eye" class="h-4 w-4"></i>
                            </button>

                        </div>

                    </div>

                </div>


                <div class="bq-modal-footer">

                    <button type="button" class="btn btn-outline" data-modal-close>
                        إلغاء
                    </button>

                    <button type="submit" class="btn btn-default btn-submit">

                        <i data-lucide="user-plus" class="h-4 w-4"></i>

                        إضافة المساعد

                    </button>

                </div>

            </form>

        </div>

    </div>

    {{-- حذف المساعد --}}
    <div id="delete-assistant-modal" class="modal-overlay">

        <div class="modal-panel max-w-lg">

            <div class="bq-modal-header">

                <div>

                    <h3 class="text-lg font-bold text-foreground">
                        حذف المساعد؟
                    </h3>

                </div>

                <button type="button" class="btn btn-icon" data-modal-close>

                    <i data-lucide="x" class="h-5 w-5"></i>

                </button>

            </div>


            <div class="rounded-xl border border-destructive/20 bg-destructive/5 p-4">

                <div class="flex items-start gap-3">

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-destructive/10 text-destructive">

                        <i data-lucide="triangle-alert" class="h-5 w-5"></i>

                    </div>

                    <div>

                        <p class="font-semibold text-foreground">
                            تأكيد حذف
                            <span id="delete-assistant-name"></span>
                        </p>

                        <p class="mt-1 text-sm leading-6 text-muted-foreground">
                            سيتم حذف حساب هذا المساعد نهائيًا ولن يتمكن من الوصول إلى نظام العيادة بعد ذلك، ولا يمكن
                            التراجع عن هذا الإجراء.
                        </p>

                    </div>

                </div>

            </div>


            <form id="delete-assistant-form" method="POST">

                @csrf
                @method('DELETE')

                <div class="bq-modal-footer">

                    <button type="button" class="btn btn-ghost" data-modal-close>
                        إلغاء
                    </button>

                    <button type="submit" class="btn btn-destructive">

                        <i data-lucide="trash-2" class="h-4 w-4"></i>

                        حذف المساعد

                    </button>

                </div>

            </form>

        </div>

    </div>


    @push('extra_java')
        <script>
            window.AssistantsPageConfig = {
                updateUrlTemplate: @json(route('clinic.assistants.update', ['assistant' => '__ASSISTANT_ID__'])),
                destroyUrlTemplate: @json(route('clinic.assistants.destroy', ['assistant' => '__ASSISTANT_ID__'])),
                reopenEdit: @json(old('_form') === 'edit'),
                reopenAdd: @json($errors->assistantAdd->any()),
            };
        </script>

        <script src="{{ asset('js/clinic/assistants.js') }}"></script>
    @endpush

@endsection
