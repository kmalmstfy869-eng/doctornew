@if ($bookings->hasPages())
    <div class="border-t border-border px-4 py-4 sm:px-5">

        {{ $bookings->withQueryString()->links('vendor.pagination.custom') }}

    </div>
@endif

