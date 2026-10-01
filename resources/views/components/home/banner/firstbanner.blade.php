@props(['nav', 'title', 'link','route'])
<section class="home-section">

    <div class="site-container">

        <div class="home-jobs-banner">

            <div>

                <span>

                    {{ $nav }}
                </span>

                <h2>

                    {{ $title }}

                </h2>

                <p>

                    {{ $slot }}

                </p>

            </div>

            <a href="{{ $route }}" class="home-jobs-button">

                {{ $link }}

                <i class="fa-solid fa-arrow-left"></i>

            </a>

        </div>

    </div>

</section>
