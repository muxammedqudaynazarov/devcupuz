<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dasturchi talabalar maktabi') | DevCUP.uz</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;600;700&family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/welcome.css') }}">
</head>
<body>

<nav>
    <div class="container nav-container">
        <a href="{{ url('/') }}" class="logo">Dev<span>Cup.uz</span></a>
        <ul class="nav-links">
            <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Asosiy</a></li>
            <li><a href="{{ url('/#reyting') }}">Reyting</a></li>
            <li><a href="{{ url('/faqs') }}" class="{{ request()->is('faqs') ? 'active' : '' }}">FAQ</a></li>
        </ul>
        @auth
            <a href="{{ route('home') }}" class="btn-login">Kabinet</a>
        @else
            <a href="{{ route('login') }}" class="btn-login">Kirish</a>
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
                Dasturlash bo‘yicha turnirlarda qatnash, o‘z mahoratingni ko‘rsat va eng
                yaxshilardan bo‘l!
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
                &copy; 2026 <span style="color: var(--primary-neon)">DevCUP.uz</span>. Barcha huquqlar himoyalangan.
            </p>
        </div>
    </div>
</footer>

</body>
</html>
