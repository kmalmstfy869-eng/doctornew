@extends('admin.layout.app')

@section('title', 'لوحة التحكم | رسائل المستخدمين')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/admin/message.css') }}">
@endpush

@section('content')

    <div class="doctor-reviews-page">

        <div class="doctor-reviews-header">
            <div class="doctor-reviews-title">
                <div class="reviews-title-icon">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div class="reviews-title-content">
                    <span class="reviews-title-small">تواصل معنا</span>
                    <h1>رسائل المستخدمين</h1>
                    <p>عرض الرسائل التي أرسلها المستخدمون من صفحة تواصل معنا</p>
                </div>
            </div>

            <div class="reviews-header-stats">
                <div class="reviews-count-badge">
                    <i class="fa-solid fa-comments"></i>
                    <span>{{ method_exists($messages, 'total') ? $messages->total() : $messages->count() }} رسالة</span>
                </div>
            </div>
        </div>

        <div class="reviews-card">

            <div class="reviews-card-header">
                <div>
                    <h2><i class="fa-solid fa-envelope-open-text"></i> آخر الرسائل</h2>
                    <p>الرسائل الواردة من المستخدمين</p>
                </div>
            </div>

            @if ($messages->isEmpty())

                <div class="reviews-empty">
                    <div class="reviews-empty-icon">
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                    <h3>لا توجد رسائل</h3>
                    <p>لم يتم استلام أي رسائل من المستخدمين حتى الآن.</p>
                </div>
            @else
                <div class="reviews-list">

                    @foreach ($messages as $message)
                        <div class="review-item cm-item">

                            {{-- الاسم + الهاتف --}}
                            <div class="review-user">
                                <div class="review-user-avatar">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <div class="review-user-info">
                                    <span class="review-label">المرسل</span>
                                    <strong>{{ filled($message->name) ? $message->name : 'لم يدخل اسم' }}</strong>
                                    @if (filled($message->phone))
                                        <small dir="ltr">{{ $message->phone }}</small>
                                    @else
                                        <small>لم يدخل رقم هاتف</small>
                                    @endif
                                </div>
                            </div>

                            {{-- الرسالة --}}
                            <div class="review-comment">
                                <span class="review-label">الرسالة</span>
                                <div class="comment-box">
                                    <i class="fa-solid fa-quote-right"></i>
                                    <p>{{ $message->message }}</p>
                                </div>
                            </div>

                            {{-- التاريخ --}}
                            <div class="review-date">
                                <i class="fa-regular fa-calendar"></i>
                                <div>
                                    <span class="review-label">التاريخ</span>
                                    <strong>{{ $message->created_at?->format('Y/m/d') }}</strong>
                                </div>
                            </div>

                            {{-- حذف --}}
                            <div class="review-actions">
                                <span class="review-label">الإجراءات</span>
                                <div class="review-actions-buttons">
                                    <form action="{{ route('admin.contact.destroy', $message->id) }}" method="POST"
                                        onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="review-action-btn delete" title="حذف">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    @endforeach

                </div>

                @if (method_exists($messages, 'links'))
                    <div class="reviews-pagination">
                        {{ $messages->links('vendor.pagination.custom') }}
                    </div>
                @endif

            @endif

        </div>

    </div>

@endsection
