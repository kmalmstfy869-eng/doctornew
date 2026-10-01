```blade
@extends('admin.layout.app')

@section('title', 'لوحة الإدارة | المستخدمون')

@section('page-title', 'المستخدمون')

@section('page-description', 'عرض وإدارة المستخدمين ومعرفة الوظائف التي قاموا بنشرها')

@section('content')

    <div class="users-page">

        {{-- =====================================================
             HEADER
        ====================================================== --}}


        <div class="users-header">

            <div class="users-title">

                <div class="title-icon">
                    <i class="fa-solid fa-users"></i>
                </div>

                <div>

                    <h2>
                        المستخدمون
                    </h2>

                    <p>
                        جميع المستخدمين المسجلين على المنصة
                    </p>

                </div>

            </div>


            <div class="users-count-card">

                <div class="users-count-icon">

                    <i class="fa-solid fa-users"></i>

                </div>

                <div class="users-count-data">

                    <span>
                        إجمالي المستخدمين
                    </span>

                    <strong>
                        {{ $users->total() }}
                    </strong>

                </div>

            </div>

        </div>




        {{-- =====================================================
             USERS TABLE
        ====================================================== --}}

        <div class="users-card">

            <div class="table-responsive">

                <table class="users-table">

                    <thead>

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                المستخدم
                            </th>

                            <th>
                                البريد الإلكتروني
                            </th>

                            <th>
                                رقم الهاتف
                            </th>

                            <th>
                                الوظائف
                            </th>

                            <th>
                                عدد الوظائف
                            </th>

                            <th>
                                تاريخ التسجيل
                            </th>

                            <th>
                                الإجراءات
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($users as $user)
                            <tr>

                                {{-- ID --}}

                                <td>
                                    {{ $users->firstItem() + $loop->index }}
                                </td>


                                {{-- USER --}}

                                <td>

                                    <div class="user-info">

                                        <div class="user-avatar">

                                            <i class="fa-solid fa-user"></i>

                                        </div>

                                        <div class="user-data">

                                            <strong>
                                                {{ $user->name }}
                                            </strong>

                                        </div>

                                    </div>

                                </td>


                                {{-- EMAIL --}}

                                <td>

                                    {{ $user->email }}

                                </td>


                                {{-- PHONE --}}

                                <td>

                                    {{ $user->phone ?? 'غير مسجل' }}

                                </td>


                                {{-- HAS JOBS --}}

                                <td>

                                    @if ($user->jobs->count() > 0)
                                        <span class="status-badge has-jobs">

                                            <i class="fa-solid fa-briefcase"></i>

                                            نشر وظائف

                                        </span>
                                    @else
                                        <span class="status-badge no-jobs">

                                            <i class="fa-solid fa-minus"></i>

                                            لم ينشر

                                        </span>
                                    @endif

                                </td>


                                {{-- JOBS COUNT --}}

                                <td>

                                    <span class="jobs-count">

                                        {{ $user->jobs->count() }}

                                    </span>

                                </td>


                                {{-- CREATED AT --}}

                                <td>

                                    {{ $user->created_at?->format('Y-m-d') }}

                                </td>


                                {{-- ACTIONS --}}

                                <td>

                                    <div class="user-actions">

                                        @if ($user->jobs->count() > 0)
                                            <a href="{{ route('admin.user.jobs', $user->id) }}" class="action-btn"
                                                title="عرض الوظائف">

                                                <i class="fa-solid fa-briefcase"></i>

                                            </a>
                                        @else
                                            <span class="action-disabled">

                                                <i class="fa-solid fa-briefcase"></i>

                                            </span>
                                        @endif


                                        {{-- DELETE USER --}}

                                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                                            onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">

                                            @csrf

                                            @method('DELETE')

                                            <button type="submit" class="action-btn delete-btn" title="حذف المستخدم">

                                                <i class="fa-solid fa-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8">

                                    <x-home.banner.no_results logo="fa-solid fa-users" title="لا يوجد مستخدمون"
                                        content="لم يتم العثور على أي مستخدمين." />

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{ $users->withQueryString()->links('vendor.pagination.custom') }}


        </div>

    </div>

@endsection

