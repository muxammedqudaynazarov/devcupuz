<!DOCTYPE html>
@php
    $options = \App\Models\Option::all();
    $title = 'Dasturchi talabalar maktabi';
    $desc = 'Dasturlash bo‘yicha turnirlarda qatnash, o‘z mahoratingni ko‘rsat va eng yaxshilardan bo‘l!';
    $metaDesc = 'Talabalar o‘rtasida dasturlash bo‘yicha haftalik marafoni. O‘z mahoratingizni ko‘rsating va eng yaxshilardan bo‘ling! Turnirda g‘olib bo‘lib qimmat baho sovg‘alar va vaucherlar yutib oling.';
    $pPage = 15;
    foreach ($options as $option) {
        if ($option->key == 'description') $desc = $option->translate;
        if ($option->key == 'meta_description') $metaDesc = $option->translate;
        if ($option->key == 'title') $title = $option->translate;
        if ($option->key == 'per_page') $pPage = $option->value;
    }
    $locale = app()->getLocale();
@endphp
<html lang="{{ $locale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', $title) | DevCUP.uz</title>
    <meta name="description" content="@yield('meta_desc', $metaDesc)">
    <meta name="keywords"
          content="@yield('meta_keywords', 'dasturlash, marafon, talabalar, it ta’lim, devcup, codecup, dasturchilar, algoritm, musobaqa, reyting, turnir, qoraqalpoq davlat universiteti, karsu, qmu')">
    <meta name="author" content="DevCUP Jamoasi | Kalbayev Allambergen, Qudaynazarov Muxammed">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#0f172a">
    <meta name="google-site-verification" content="lNl5nLJL_88FLMykqNXax1GC50RUc7bE0L9qVWx4G84"/>
    <meta name="yandex-verification" content="6714ff0cc2d660ca"/>
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="DevCUP.uz">
    <meta property="og:title" content="@yield('title', $title) | DevCUP.uz">
    <meta property="og:description" content="@yield('meta_desc', $metaDesc)">
    <meta property="og:image" content="@yield('meta_image', asset('assets/og_banner_min.jpg'))">
    <meta property="og:image:width" content="600">
    <meta property="og:image:height" content="317">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $title }} | DevCUP.uz">
    <meta name="twitter:description" content="@yield('meta_desc', $metaDesc)">
    <meta name="twitter:image" content="@yield('meta_image', asset('assets/og_banner_min.jpg'))">
    <link rel="shortcut icon" href="{{ asset('assets/favicon128.png') }}" type="image/x-icon">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon128.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon128.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon128.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;600;700&family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/welcome.css') }}">
    @yield('style')
</head>
<body>

<nav>
    <div class="container nav-container">
        <a href="{{ url('/') }}" class="logo">Dev<span>Cup.uz</span></a>
        <ul class="nav-links">
            <li>
                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
                    {{ __('welcome.Main') }}
                </a>
            </li>
            <li>
                <a href="{{ url('/#reyting') }}">
                    {{ __('welcome.Rating') }}
                </a>
            </li>
            <li>
                <a href="{{ url('/faqs') }}" class="{{ request()->is('faqs') ? 'active' : '' }}">
                    FAQ
                </a>
            </li>
            <li>
                <a href="{{ url('/documents') }}" class="{{ request()->is('documents') ? 'active' : '' }}">
                    {{ __('welcome.Documents') }}
                </a>
            </li>
        </ul>

        @php
            $active_languages = \App\Models\Language::where('status', '1')->get();
            $current_locale = session('locale', config('app.locale'));
            $current_language = $active_languages->where('locale', $current_locale)->first();
        @endphp

        @if($active_languages->count() > 1)
            <div class="lang-dropdown">
                <button class="lang-btn">
                    <i class="fas fa-globe"></i>
                    {{ $current_language ? strtoupper($current_language->locale) : 'UZ' }}
                </button>
                <div class="lang-content">
                    @foreach($active_languages as $lang)
                        <a href="{{ route('lang.switch', $lang->locale) }}"
                           class="{{ $current_locale == $lang->locale ? 'active-lang' : '' }}">
                            {{ $lang->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
        @auth
            <a href="{{ route('home') }}" class="btn-login">{{ __('welcome.Personal') }}</a>
        @else
            <a href="{{ route('login') }}" class="btn-login">{{ __('welcome.Login') }}</a>
        @endauth
    </div>
</nav>

<main class="container">
    @yield('content')
</main>

<footer>
    <div class="container footer-container">
        <div class="footer-left">
            <a href="{{ url('/') }}" class="logo">Dev<span>Cup.uz</span></a>
            <p class="footer-text" style="text-align: justify; font-size: small">
                {{ $desc }}
            </p>
        </div>
        <div class="footer-right">
            <div class="social-links">
                <a href="https://t.me/KarSU_Tournament" class="social-link-item" title="Telegram" target="_blank">
                    <i class="fab fa-telegram-plane"></i>
                </a>

                <a href="#" class="social-link-item" title="GitHub">
                    <i class="fab fa-github"></i>
                </a>

                <a href="#" class="social-link-item" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>

            <p class="copyright">
                &copy; 2026 <span
                    style="color: var(--primary-neon)">DevCUP.uz</span>. {{ __('welcome.All rights reserved') }}
            </p>
        </div>
    </div>
</footer>
@yield('script')
</body>
</html>
