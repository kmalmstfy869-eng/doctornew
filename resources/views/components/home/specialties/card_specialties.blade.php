@props(['link', 'number', 'name', 'title', 'logo'])
<a href="{{ $link }}" class="specialty-card">

    <div class="card-top">

        <div class="specialty-icon">

            <i class="{{ $logo }}"></i>

        </div>

        <span class="specialty-number">

            {{ $number }}

        </span>

    </div>

    <h3>

        {{ $name }}

    </h3>

    <p>

        {{ $title }}
    </p>

    <div class="card-bottom">

        <span class="doctor-count">

            <i class="fa-solid fa-user-doctor"></i>

            عرض الأطباء

        </span>

        <span class="arrow">

            <i class="fa-solid fa-arrow-left"></i>

        </span>

    </div>

</a>
