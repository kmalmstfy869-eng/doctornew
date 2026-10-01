@props(['title', 'address', 'contet1', 'content_continuation', 'note'])
<section class="doctors-hero">

    <div class="doctors-hero-content">


        <div class="doctors-breadcrumb">

            <a href="{{ route('home') }}">

                الرئيسية

            </a>


            <i class="fa-solid fa-angle-left"></i>


            <span>


                {{ $title }}

            </span>

        </div>


        <div class="doctors-hero-badge">

            <i class="fa-solid fa-user-doctor"></i>

            {{ $address }}

        </div>


        <h1>


            {{ $contet1 }}

            <span>

                {{ $content_continuation }}

            </span>

        </h1>


        <p class="doctors-hero-text">

            {{ $note }}

        </p>


    </div>

</section>
