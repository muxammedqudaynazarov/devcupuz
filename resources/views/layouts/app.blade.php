<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DevCup.UZ - Shaxsiy Kabinet</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;600;700&family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    @yield('style')
</head>
<body>

@php
    // 1. Ismni xavfsiz o'qib olish (JSON bo'lsa parselash, bo'lmasa o'zini olish)
    $rawName = auth()->user()->name ?? 'Talaba';
    $decoded = json_decode($rawName);
    $displayName = ($decoded && isset($decoded->short)) ? $decoded->short : $rawName;
    [$sName, $fName] = explode(' ', $displayName);
    $sName = substr($sName, 0, 1);
    $fName = substr($fName, 0, 1);
    $wName = $sName.$fName;
    // 2. Avatar uchun rasm yo'q bo'lsa, ismning bosh harfi bilan dinamik rasm yasash
    //$avatarUrl = auth()->user()->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($displayName) . '&background=38bdf8&color=fff&bold=true';
    $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($wName) . '&background=38bdf8&color=fff&bold=true';
@endphp

<aside class="sidebar" id="sidebar">
    <a href="/" class="sidebar-logo">Dev<span>Cup</span></a>
    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('home') }}" class="{{ Request::is('home') || Request::is('/') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Asosiy panel
            </a>
        </li>
        <li>
            <a href="{{ route('student.tournaments.index') }}"
               class="{{ Request::is('home/tournaments*') || Request::is('student/tournaments*') ? 'active' : '' }}">
                <i class="fas fa-trophy"></i> Turnirlar
            </a>
        </li>
        <li>
            <a href="{{ route('problems.index') }}" class="{{ Request::is('home/problems*') ? 'active' : '' }}">
                <i class="fas fa-code"></i> Masalalar
            </a>
        </li>
        <li>
            <a href="{{ route('submissions.index') }}" class="{{ Request::is('home/submissions*') ? 'active' : '' }}">
                <i class="fas fa-history"></i> Urinishlar
            </a>
        </li>
        <li>
            <a href="{{ route('ratings.index') }}" class="{{ Request::is('home/ratings*') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Reyting
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fas fa-user-cog"></i> Sozlamalar
            </a>
        </li>
    </ul>
</aside>

<main class="main-content">

    <nav class="navbar navbar-top">
        <div style="display: flex; align-items: center; gap: 15px;">
            <button class="menu-toggle-btn" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="page-title" style="margin: 0; font-size: 1.25rem; font-weight: 600;">Shaxsiy kabinet</h1>
        </div>

        <div class="user-menu" style="display: flex; align-items: center; gap: 20px;">
            <div class="user-profile" style="display: flex; align-items: center; gap: 10px;">
                <img class="avatar" src="{{ $avatarUrl }}" alt="{{ $displayName }}"
                     style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary-neon, #38bdf8);">
                <span style="font-size: 0.95rem; font-weight: 500; color: #e2e8f0; text-transform: capitalize;">
                    {{ $displayName }}
                </span>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout-neon">
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
        sidebar.classList.toggle('active');
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
