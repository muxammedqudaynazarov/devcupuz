<!DOCTYPE html>
@php
    $locale = app()->getLocale();
@endphp
<html lang="{{ $locale }}">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @auth
        <link rel="stylesheet" href="{{ asset('assets/themes/'.auth()->user()->theme) }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/themes/dark.css') }}">
    @endauth
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <style>
        /* Dropdown uchun CSS (Buni style.css ga o'tkazishingiz ham mumkin) */
        .profile-dropdown {
            position: relative;
            display: inline-block;
        }

        .profile-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background-color: var(--panel-bg, #1e293b);
            min-width: 200px;
            box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.3);
            z-index: 100;
            border-radius: 10px;
            border: 1px solid var(--border-light, rgba(255, 255, 255, 0.05));
            overflow: hidden;
            margin-top: 15px;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .profile-dropdown:hover .profile-dropdown-content {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .profile-dropdown-content a, .profile-dropdown-content .role-item {
            color: var(--text-color, #f1f5f9);
            padding: 12px 16px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            transition: 0.2s;
        }

        .profile-dropdown-content a:hover, .profile-dropdown-content .role-item:hover {
            background-color: rgba(56, 189, 248, 0.1);
            color: var(--primary-neon, #38bdf8);
        }
    </style>
    @yield('style')
</head>
<body>

@php
    $user = auth()->user();
    $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode(json_decode($user->name)->short) . '&background=38bdf8&color=fff&bold=true';
    $latestMedal = $user->medals()->orderByPivot('created_at', 'desc')->first();
    $activeApp = \DB::table('tournament_users')->where('user_id', $user->id)->where('status', '1')->where('active', '1')->first();
@endphp
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>
<aside class="sidebar" id="sidebar">
    <a href="/" class="sidebar-logo">Dev<span>Cup</span></a>
    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('home') }}" class="{{ Request::is('home') || Request::is('/') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Asosiy panel
            </a>
        </li>
        @can('user.tournaments.view')
            <li>
                <a href="{{ route('student.tournaments.index') }}"
                   class="{{ Request::is('home/tournaments*') || Request::is('student/tournaments*') ? 'active' : '' }}">
                    <i class="fas fa-trophy"></i> Turnirlar
                </a>
            </li>
        @endcan
        @if($activeApp)
            @can('user.problems.view')
                <li>
                    <a href="{{ route('problems.index') }}" class="{{ Request::is('home/problems*') ? 'active' : '' }}">
                        <i class="fas fa-code"></i> Masalalar
                    </a>
                </li>
            @endcan
            @can('user.submissions.view')
                <li>
                    <a href="{{ route('submissions.index') }}"
                       class="{{ Request::is('home/submissions*') ? 'active' : '' }}">
                        <i class="fas fa-history"></i> Urinishlar
                    </a>
                </li>
            @endcan
            @can('user.ratings.view')
                <li>
                    <a href="{{ route('ratings.index') }}" class="{{ Request::is('home/ratings*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i> Reyting
                    </a>
                </li>
            @endcan
        @endif
        @can('user.settings.view')
            <li>
                <a href="{{ route('options.index') }}" class="{{ Request::is('home/options*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> Sozlamalar
                </a>
            </li>
        @endcan
    </ul>
</aside>

<main class="main-content">
    <nav class="navbar navbar-top">
        <div style="display: flex; align-items: center; gap: 15px;">
            <button class="menu-toggle-btn" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="page-title">
                <div style="margin: 0; font-size: 1.25rem; font-weight: 600;">
                    @yield('page_title')
                </div>
                <div style="font-size: small; font-weight: normal">
                    @yield('page_title_desc')
                </div>
            </h1>
        </div>

        <div class="user-menu" style="display: flex; align-items: center; gap: 20px;">
            @php
                $rawRoles = $user->rol;
                $userRoles = is_string($rawRoles) ? [$rawRoles] : (is_array($rawRoles) ? $rawRoles : []);
            @endphp

            @if(count($userRoles) > 1)
                <div class="profile-dropdown">
                    <div class="user-profile" style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <img class="avatar" src="{{ $avatarUrl }}" alt="{{ $user->name }}"
                             style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary-neon, #38bdf8);">
                        <div style="font-size: 0.95rem; text-transform: capitalize; color: var(--text-color)">
                            {{ json_decode(auth()->user()->name)->short }}
                            <i class="fas fa-chevron-down"
                               style="font-size: 0.75rem; margin-left: 5px; color: var(--text-muted);"></i>
                        </div>
                        @if($latestMedal)
                            <img src="{{ asset($latestMedal->image) }}"
                                 alt="{{ $latestMedal->name }}" title="{{ $latestMedal->name }}"
                                 style="width: 20px; height: 20px; object-fit: contain; filter: drop-shadow(0 0 5px rgba(255, 215, 0, 0.4));">
                        @endif
                    </div>

                    <div class="profile-dropdown-content" style="margin-top: 0">
                        <a href="{{ route('user.show', $user->username) }}">
                            <i class="fas fa-user-circle" style="color: var(--primary-neon);"></i> Mening profilim
                        </a>
                        <hr style="border-color: var(--background-error)">
                        @foreach($userRoles as $role)
                            <a class="role-item" href="{{ route('switch.role', $role) }}">
                                {{ $role }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <a href="{{ route('user.show', $user->username) }}" class="user-profile"
                   style="display: flex; align-items: center; gap: 10px; text-decoration: none">
                    <img class="avatar" src="{{ $avatarUrl }}" alt="{{ $user->name }}"
                         style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary-neon, #38bdf8);">
                    <div style="font-size: 0.95rem; text-transform: capitalize; color: var(--text-color)">
                        {{ json_decode($user->name)->short }}
                    </div>
                    @if($latestMedal)
                        <img src="{{ asset($latestMedal->image) }}"
                             alt="{{ $latestMedal->name }}"
                             title="{{ $latestMedal->name }}"
                             style="width: 20px; height: 20px; object-fit: contain; filter: drop-shadow(0 0 5px rgba(255, 215, 0, 0.4)); cursor: pointer;">
                    @endif
                </a>
            @endif
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout-neon" onclick="localStorage.clear();">
                    <i class="fas fa-sign-out-alt"></i> Chiqish
                </button>
            </form>
        </div>
    </nav>

    <div>
        @yield('content')
    </div>
    <div id="toast-container" class="toast-container"></div>

</main>

<script>
    function toggleSidebar() {
        var sidebar = document.getElementById('sidebar');
        var overlay = document.getElementById('sidebar-overlay');

        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    }

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
@yield('script')</body>
</html>
