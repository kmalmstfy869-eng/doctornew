@if (session()->has('success') || session()->has('error'))

    @php
        $isSuccess = session()->has('success');
        $message = session('success') ?? session('error');
    @endphp

    <div
        class="flash-message {{ $isSuccess ? 'flash-success' : 'flash-error' }}"
        role="alert"
    >

        {{-- Icon --}}
        <div class="flash-icon">

            @if ($isSuccess)

                <i class="fa-solid fa-check"></i>

            @else

                <i class="fa-solid fa-xmark"></i>

            @endif

        </div>


        {{-- Content --}}
        <div class="flash-content">

            <strong>
                {{ $isSuccess ? 'تمت العملية بنجاح' : 'حدث خطأ' }}
            </strong>

            <span>
                {{ $message }}
            </span>

        </div>


        {{-- Close --}}
        <button
            type="button"
            class="flash-close"
            aria-label="إغلاق الرسالة"
        >
            <i class="fa-solid fa-xmark"></i>
        </button>


        {{-- Progress --}}
        <div class="flash-progress"></div>

    </div>

@endif
