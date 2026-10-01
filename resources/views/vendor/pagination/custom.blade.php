
@if($paginator->hasPages())
<div class="pagination">

    {{-- السابق --}}
    @if ($paginator->onFirstPage())

        <span class="page-button disabled">
            <i class="fa-solid fa-angle-right"></i>
        </span>

    @else

        <a href="{{ $paginator->previousPageUrl() }}" class="page-button">
            <i class="fa-solid fa-angle-right"></i>
        </a>

    @endif


    @php

        $current = $paginator->currentPage();
        $last = $paginator->lastPage();

        $start = max(1, $current - 1);
        $end = min($last, $start + 3);

        $start = max(1, $end - 3);

    @endphp


    @for ($page = $start; $page <= $end; $page++)

        @if ($page == $current)

            <span class="page-button active">
                {{ $page }}
            </span>

        @else

            <a href="{{ $paginator->url($page) }}" class="page-button">
                {{ $page }}
            </a>

        @endif

    @endfor


    @if ($paginator->hasMorePages())

        <a href="{{ $paginator->nextPageUrl() }}" class="page-button">
            <i class="fa-solid fa-angle-left"></i>
        </a>

    @else

        <span class="page-button disabled">
            <i class="fa-solid fa-angle-left"></i>
        </span>

    @endif

</div>
@endif
