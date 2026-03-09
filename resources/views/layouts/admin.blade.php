<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dasturchi talabalar maktabi') | DevCUP.uz</title>
    <meta name="description"
          content="@yield('meta_desc', 'Talabalar o‘rtasida dasturlash bo‘yicha haftalik marafoni. O‘z mahoratingizni ko‘rsating va eng yaxshilardan bo‘ling! Turnirda g‘olib bo‘lib qimmat baho sovg‘alar va vaucherlar yutib oling.')">
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
    <meta property="og:title" content="@yield('title', 'Dasturchi talabalar maktabi') | DevCUP.uz">
    <meta property="og:description"
          content="@yield('meta_desc', '10 haftalik dasturlash marafoni. Eng yaxshilar safida bo\'l va qimmatbaho sovrinlarni yutib ol!')">
    <meta property="og:image" content="@yield('meta_image', asset('assets/og_banner_min.jpg'))">
    <meta property="og:image:width" content="600">
    <meta property="og:image:height" content="317">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('title', 'Dasturchi talabalar maktabi') | DevCUP.uz">
    <meta name="twitter:description"
          content="@yield('meta_desc', 'Talabalar o‘rtasida dasturlash bo‘yicha haftalik marafoni. O‘z mahoratingizni ko‘rsating va eng yaxshilardan bo‘ling! Turnirda g‘olib bo‘lib qimmat baho sovg‘alar va vaucherlar yutib oling.')">
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
    <link rel="stylesheet" href="{{ asset('assets/themes/dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @yield('style')
</head>
<body>

@php
    $userName = json_decode(auth()->user()->name ?? '{"short": "Talaba"}');
    $initial = mb_substr($userName->short, 0, 1);
@endphp

<aside class="sidebar">
    <a href="/" class="sidebar-logo">Dev<span>Cup</span></a>
    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('admin') }}" {!! Request::is('admin') ? 'class="active"' : '' !!}>
                <i class="fas fa-chart-line"></i> Admin panel
            </a>
        </li>
        <li>
            <a href="{{ route('tournaments.index') }}" {!! Request::is('admin/tournaments*') ? 'class="active"' : '' !!}>
                <i class="fas fa-trophy"></i> Turnirlar
            </a>
        </li>
        <li>
            <a href="{{ route('admin.problems.index') }}" {!! Request::is('admin/problems*') ? 'class="active"' : '' !!}>
                <i class="fas fa-code"></i> Masalalar
            </a>
        </li>
        <li>
            <a href="#" {!! Request::is('admin/prizes*') ? 'class="active"' : '' !!}>
                <i class="fas fa-users"></i> Foydalanuvchilar
            </a>
        </li>
        <li>
            <a href="#" {!! Request::is('admin/prizes*') ? 'class="active"' : '' !!}>
                <i class="fas fa-gift"></i> Sovrinlar
            </a>
        </li>
        <li>
            <a href="#" {!! Request::is('admin/prizes*') ? 'class="active"' : '' !!}>
                <i class="fas fa-medal"></i> Medallar
            </a>
        </li>
        <li>
            <a href="{{ route('programs.index') }}" {!! Request::is('admin/programs*') ? 'class="active"' : '' !!}>
                <i class="fas fa-microchip"></i> Dasturlash tillari
            </a>
        </li>
        <li>
            <a href="{{ route('ratings.index') }}" {!! Request::is('admin/ratings*') ? 'class="active"' : '' !!}>
                <i class="fas fa-star"></i> Reyting
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fas fa-history"></i> Urinishlar
            </a>
        </li>
        <li>
            <a href="{{ route('admin.faqs.index') }}" {!! Request::is('admin/faqs*') ? 'class="active"' : '' !!}>
                <i class="fas fa-info-circle"></i> FAQ
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fas fa-cog"></i> Sozlamalar
            </a>
        </li>
    </ul>
</aside>

<main class="main-content">
    <nav class="navbar">
        <div style="display: flex; align-items: center;">
            <button class="menu-toggle" style="display: none;" onclick="toggleSidebar()">☰</button>
            <h1 class="page-title">Shaxsiy kabinet</h1>
        </div>
        <div class="user-menu">
            <div class="user-profile">
                <img class="avatar" src="#" alt="Admin">
                <span style="font-size: 0.9rem; font-weight: 500; text-transform: capitalize">
                    Admin F.A.
                </span>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">Chiqish</button>
            </form>
        </div>
    </nav>

    @yield('content')
    <div id="toast-container" class="toast-container"></div>
</main>

<script>
    function showToast(type, message, title = null) {
        const container = document.getElementById('toast-container');
        if (!container) return;
        const toast = document.createElement('div');
        toast.className = `custom-toast toast-${type}`;
        let icon = '';
        let defaultTitle = '';
        switch (type) {
            case 'success':
                icon = 'fa-check-circle';
                defaultTitle = 'Muvaffaqiyatli';
                break;
            case 'error':
                icon = 'fa-exclamation-circle';
                defaultTitle = 'Xatolik';
                break;
            case 'info':
                icon = 'fa-info-circle';
                defaultTitle = 'Ma’lumot';
                break;
            case 'warning':
                icon = 'fa-exclamation-triangle';
                defaultTitle = 'Ogohlantirish';
                break;
        }

        toast.innerHTML = `<div class="toast-icon"><i class="fas ${icon}"></i></div>
            <div class="toast-content">
                <div class="toast-title">${title || defaultTitle}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close" onclick="closeToast(this)">&times;</button>`;
        container.appendChild(toast);
        setTimeout(() => toast.classList.add('show'), 10);
        setTimeout(() => {
            if (toast.parentElement) closeToast(toast.querySelector('.toast-close'));
        }, 5000);
    }

    function closeToast(btn) {
        const toast = btn.parentElement;
        if (toast) {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 400);
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        @if(session('success'))
        showToast('success', `{!! addslashes(session('success')) !!}`);
        @endif
        @if(session('error'))
        showToast('error', `{!! addslashes(session('error')) !!}`);
        @endif
        @if(session('info'))
        showToast('info', `{!! addslashes(session('info')) !!}`);
        @endif
        @if(session('warning'))
        showToast('warning', `{!! addslashes(session('warning')) !!}`);
        @endif
        @if($errors->any())
        @foreach($errors->all() as $error)
        showToast('error', `{!! addslashes($error) !!}`, "Ma’lumotlarda xatolik");
        @endforeach
        @endif
    });
</script>
@yield('script')
</body>
</html>
