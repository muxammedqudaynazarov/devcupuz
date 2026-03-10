<!DOCTYPE html>
@php
    $locale = app()->getLocale();
@endphp
<html lang="{{ $locale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ json_decode($user->name)->full }} - Profil | DevCup.UZ</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;600;700&family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-dark: #0f172a;
            --panel-bg: #1e293b;
            --primary-neon: #38bdf8;
            --accent-green: #4ade80;
            --danger-red: #f87171;
            --warning-yellow: #facc15;
            --border-color: rgba(255, 255, 255, 0.08);
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
        }

        /* Maxsus Navbar - Faqat Logotip uchun */
        .public-navbar {
            height: 60px;
            background: rgba(15, 23, 42, 0.95);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
        }

        .public-navbar .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-main);
            text-decoration: none;
            letter-spacing: 1px;
        }

        .public-navbar .logo span {
            color: var(--primary-neon);
        }

        /* Container */
        .container {
            max-width: 1500px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        /* Card (Panel) dizayni */
        .card-panel {
            background: var(--panel-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-panel:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        /* Profil layout Grid */
        .profile-layout {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 25px;
            margin-bottom: 25px;
        }

        .profile-avatar-wrapper {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-avatar {
            width: 100%;
            max-width: 300px;
            aspect-ratio: 1/1;
            object-fit: cover;
            border-radius: 12px;
            border: 4px solid var(--border-color);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .info-list-profile {
            list-style: none;
            padding: 0;
            margin: 20px 0 0 0;
        }

        .info-list-profile li {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.9rem;
        }

        .info-list-profile span:first-child {
            color: var(--text-muted);
            font-weight: 500;
        }

        .info-list-profile span:last-child {
            color: var(--text-main);
            font-weight: 600;
            text-align: right;
            max-width: 60%;
        }

        /* Medallar */
        .medals-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 15px;
        }

        .medal-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            min-width: 90px;
            transition: 0.3s;
            position: relative;
            cursor: pointer;
        }

        .medal-item:hover {
            border-color: var(--warning-yellow);
            box-shadow: 0 5px 15px rgba(245, 158, 11, 0.15);
            z-index: 50;
        }

        .medal-name {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-main);
            text-align: center;
        }

        /* Tooltip */
        .medal-item::after, .heatmap-cell::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: calc(100% + 10px);
            left: 50%;
            transform: translateX(-50%) translateY(5px);
            width: max-content;
            max-width: 150px;
            padding: 6px 12px;
            background-color: var(--text-main);
            color: var(--bg-dark);
            border-radius: 6px;
            font-size: 0.65rem;
            font-weight: 600;
            text-align: center;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: 0.2s ease-in-out;
            z-index: 1000;
            pointer-events: none;
        }

        .medal-item::before, .heatmap-cell::before {
            content: '';
            position: absolute;
            bottom: calc(100% + 4px);
            left: 50%;
            transform: translateX(-50%) translateY(5px);
            border-width: 6px;
            border-style: solid;
            border-color: var(--text-main) transparent transparent transparent;
            opacity: 0;
            visibility: hidden;
            transition: 0.2s ease-in-out;
            z-index: 1000;
            pointer-events: none;
        }

        .medal-item:hover::after, .medal-item:hover::before,
        .heatmap-cell:hover::after, .heatmap-cell:hover::before {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }

        /* Urinishlar (Tillar) */
        .lang-stats-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .lang-stats-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .lang-stats-list li:last-child {
            border-bottom: none;
        }

        .lang-info {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .lang-icon-wrapper {
            width: 36px;
            height: 36px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #fff;
        }

        .stats-pills {
            display: flex;
            gap: 6px;
        }

        .stat-pill {
            padding: 4px 10px;
            border-radius: 4px;
            color: #fff;
            font-size: 0.8rem;
            font-weight: 600;
            min-width: 60px;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .pill-success {
            background: #22c55e;
        }

        .pill-total {
            background: #3b82f6;
        }

        .pill-error {
            background: #ef4444;
        }

        .total-row {
            font-size: 1.1rem !important;
            padding-top: 15px !important;
            border-top: 2px solid var(--border-color) !important;
        }

        /* Heatmap */
        .heatmap-container {
            display: grid;
            grid-template-rows: repeat(7, 1fr);
            grid-auto-columns: 1fr;
            grid-auto-flow: column;
            gap: 4px;
            width: 100%;
            padding-bottom: 5px;
        }

        .heatmap-cell {
            width: 100%;
            aspect-ratio: 1 / 1;
            border-radius: 2px;
            background-color: rgba(255, 255, 255, 0.05);
            transition: 0.2s;
            cursor: pointer;
            position: relative;
            font-size: 0.65rem;
        }

        .heatmap-cell:hover {
            border: 1px solid var(--primary-neon);
            z-index: 50;
        }

        .heatmap-months {
            display: flex;
            justify-content: space-between;
            padding-bottom: 10px;
            font-size: 0.8rem;
            color: var(--text-muted);
            width: 100%;
        }

        /* Neon Heatmap Ranglar */
        .level-1 {
            background-color: rgba(56, 189, 248, 0.3);
        }

        .level-2 {
            background-color: rgba(56, 189, 248, 0.6);
        }

        .level-3 {
            background-color: rgba(56, 189, 248, 0.85);
        }

        .level-4 {
            background-color: rgba(56, 189, 248, 1);
            box-shadow: 0 0 6px rgba(56, 189, 248, 0.4);
        }

        @media (max-width: 992px) {
            .profile-layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<nav class="public-navbar">
    <a href="/" class="logo">Dev<span>Cup</span></a>
</nav>

<div class="container">
    <div class="profile-layout">
        {{-- CHAP TOMON: Profil ma'lumotlari --}}
        <div class="left-column">
            <div class="card-panel">
                <div class="profile-avatar-wrapper">
                    <img
                        src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(json_decode($user->name)->full).'&background=38bdf8&color=fff&size=250' }}"
                        alt="Avatar" class="profile-avatar">
                </div>

                <div style="text-align: center;">
                    <h2 style="color: var(--text-main); font-size: 1.4rem; margin-bottom: 5px;">{{ json_decode($user->name)->full }}</h2>
                    <p style="color: var(--text-muted); font-size: 1rem; margin-bottom: 10px;">{{ '@' . $user->username }}</p>
                    <p style="font-size: 0.85rem; color: var(--primary-neon); font-weight: 500;">
                        {{ __('welcome.With us since :date', ['date' => $user->created_at->format('d.m.Y')]) }}
                    </p>
                </div>

                <ul class="info-list-profile">
                    <li>
                        <span>{{ __('welcome.Educational institution') }}</span>
                        <span style="font-weight: lighter; font-size: small; text-align: right;">
                            {{ $user->university->name ?? '-' }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- O'NG TOMON: Statistika va Medallar --}}
        <div class="right-column" style="display: flex; flex-direction: column; gap: 25px;">

            <div class="card-panel"
                 style="display: grid; grid-template-columns: 1fr 1fr; text-align: center; padding: 30px;">
                <div style="border-right: 1px solid var(--border-color);">
                    <i class="fas fa-medal"
                       style="font-size: 2.5rem; color: var(--primary-neon); margin-bottom: 10px;"></i>
                    <h2 style="font-size: 2.5rem;">{{ $user->rating ?? '0' }}</h2>
                    <p style="color: var(--text-muted); font-weight: 500;">DevCup Rating</p>
                </div>
                <div>
                    <i class="fas fa-tasks"
                       style="font-size: 2.5rem; color: var(--primary-neon); margin-bottom: 10px;"></i>
                    <h2 style="font-size: 2.5rem;">{{ $totalSolved }}</h2>
                    <p style="color: var(--text-muted); font-weight: 500;">{{ __('welcome.Solved issues') }}</p>
                </div>
            </div>

            {{-- URINISHLAR STATISTIKASI --}}
            <div class="card-panel">
                <h3 style="font-size: 1.1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; margin-bottom: 10px;">
                    {{ __('welcome.Attempts') }}
                </h3>

                @php
                    $langMap = [
                        'text/x-c++src'   => ['name' => 'C++', 'icon' => 'fa-brands fa-cuttlefish', 'bg' => '#3b82f6'],
                        'text/x-csrc'     => ['name' => 'C', 'icon' => 'fa-solid fa-copyright', 'bg' => '#3b82f6'],
                        'text/x-csharp'   => ['name' => 'C#', 'icon' => 'fa-brands fa-microsoft', 'bg' => '#8b5cf6'],
                        'text/x-python'   => ['name' => 'Python', 'icon' => 'fa-brands fa-python', 'bg' => '#eab308'],
                        'text/javascript' => ['name' => 'JavaScript', 'icon' => 'fa-brands fa-js', 'bg' => '#eab308'],
                        'text/x-java'     => ['name' => 'Java', 'icon' => 'fa-brands fa-java', 'bg' => '#f97316'],
                        'text/x-php'      => ['name' => 'PHP', 'icon' => 'fa-brands fa-php', 'bg' => '#6366f1'],
                        'text/x-go'       => ['name' => 'Go', 'icon' => 'fa-brands fa-golang', 'bg' => '#0ea5e9'],
                        'text/x-rustsrc'  => ['name' => 'Rust', 'icon' => 'fa-brands fa-rust', 'bg' => '#f97316'],
                        'text/x-ruby'     => ['name' => 'Ruby', 'icon' => 'fa-solid fa-gem', 'bg' => '#ef4444'],
                        'text/x-sql'      => ['name' => 'SQL', 'icon' => 'fa-solid fa-database', 'bg' => '#64748b'],
                        'text/x-swift'    => ['name' => 'Swift', 'icon' => 'fa-brands fa-swift', 'bg' => '#f97316'],
                        'text/x-kotlin'   => ['name' => 'Kotlin', 'icon' => 'fa-solid fa-k', 'bg' => '#8b5cf6'],
                    ];

                    $knownLangs = [];
                    $otherLangs = ['accepted' => 0, 'total_attempts' => 0, 'failed' => 0];
                    $totAcc = 0; $totAtt = 0; $totFail = 0;

                    foreach($languageStats as $stat) {
                        $totAcc += $stat->accepted;
                        $totAtt += $stat->total_attempts;
                        $totFail += $stat->failed;

                        if (isset($langMap[$stat->code])) {
                            $knownLangs[] = $stat;
                        } else {
                            $otherLangs['accepted'] += $stat->accepted;
                            $otherLangs['total_attempts'] += $stat->total_attempts;
                            $otherLangs['failed'] += $stat->failed;
                        }
                    }
                @endphp

                <ul class="lang-stats-list">
                    @foreach($knownLangs as $stat)
                        @php $mapped = $langMap[$stat->code]; @endphp
                        <li>
                            <div class="lang-info">
                                <div class="lang-icon-wrapper" style="background-color: {{ $mapped['bg'] }};">
                                    <i class="{{ $mapped['icon'] }}"></i>
                                </div>
                                <span>{{ $mapped['name'] }}</span>
                            </div>
                            <div class="stats-pills">
                                <span class="stat-pill pill-success"><i class="fas fa-check"></i> {{ $stat->accepted }}</span>
                                <span class="stat-pill pill-total"><i class="fas fa-bolt"></i> {{ $stat->total_attempts }}</span>
                                <span class="stat-pill pill-error"><i
                                        class="fas fa-times"></i> {{ $stat->failed }}</span>
                            </div>
                        </li>
                    @endforeach

                    @if($otherLangs['total_attempts'] > 0)
                        <li>
                            <div class="lang-info">
                                <div class="lang-icon-wrapper" style="background-color: #94a3b8;">
                                    <i class="fa-solid fa-puzzle-piece"></i>
                                </div>
                                <span>{{ __('welcome.Other') }}</span>
                            </div>
                            <div class="stats-pills">
                                <span class="stat-pill pill-success"><i class="fas fa-check"></i> {{ $otherLangs['accepted'] }}</span>
                                <span class="stat-pill pill-total"><i class="fas fa-bolt"></i> {{ $otherLangs['total_attempts'] }}</span>
                                <span class="stat-pill pill-error"><i class="fas fa-times"></i> {{ $otherLangs['failed'] }}</span>
                            </div>
                        </li>
                    @endif

                    @if($totAtt > 0)
                        <li class="total-row">
                            <div class="lang-info" style="font-size: 1.1rem;">{{ __('welcome.Total') }}</div>
                            <div class="stats-pills">
                                <span class="stat-pill pill-success"><i class="fas fa-check"></i> {{ $totAcc }}</span>
                                <span class="stat-pill pill-total"><i class="fas fa-bolt"></i> {{ $totAtt }}</span>
                                <span class="stat-pill pill-error"><i class="fas fa-times"></i> {{ $totFail }}</span>
                            </div>
                        </li>
                    @else
                        <p style="color: var(--text-muted); font-size: 0.9rem;">{{ __('welcome.There are no attempts yet.') }}</p>
                    @endif
                </ul>
            </div>

            {{-- MEDALLAR --}}
            <div class="card-panel">
                <h3 style="font-size: 1.1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 15px;">
                    <i class="fas fa-award"
                       style="color: var(--warning-yellow);"></i> {{ __('welcome.Achievements and medals') }}
                </h3>
                @if($user->medals->count() > 0)
                    <div class="medals-grid">
                        @foreach($user->medals as $medal)
                            <div class="medal-item" data-tooltip="{{ $medal->desc }}"
                                 style="border: 1px solid var(--primary-neon)">
                                <img src="{{ asset($medal->image) }}" alt="{{ $medal->name }}"
                                     style="width: 60px; height: 60px;">
                                <div class="medal-name">{{ $medal->name }}</div>
                                <div style="margin-top: -1em; margin-bottom: -0.9em; font-size: x-small">
                                    ({{ $medal->pivot->created_at ? $medal->pivot->created_at->format('d.m.Y') : '-' }})
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 15px;">
                        {{ __('welcome.The user has no medals yet.') }}
                    </p>
                @endif
            </div>

        </div>
    </div>

    {{-- YILLIK FAOLLIK --}}
    <div class="card-panel" style="width: 100%;">
        <h3 style="font-size: 1.1rem; margin-bottom: 15px;">{{ __('welcome.Annual activity') }}</h3>
        <div class="heatmap-months">
            @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                <div>{{ __("welcome.months.{$month}") }}</div>
            @endforeach
        </div>

        <div id="heatmap" class="heatmap-container"></div>

        <div
            style="display: flex; justify-content: flex-end; align-items: center; gap: 8px; margin-top: 15px; font-size: 0.8rem; color: var(--text-muted);">
            0
            <div class="heatmap-cell" style="width: 14px; height: 14px; pointer-events: none;"></div>
            <div class="heatmap-cell level-1" style="width: 14px; height: 14px; pointer-events: none;"></div>
            <div class="heatmap-cell level-2" style="width: 14px; height: 14px; pointer-events: none;"></div>
            <div class="heatmap-cell level-3" style="width: 14px; height: 14px; pointer-events: none;"></div>
            <div class="heatmap-cell level-4" style="width: 14px; height: 14px; pointer-events: none;"></div>
            30+
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const activityData = {!! $activityJson !!};
        const heatmapEl = document.getElementById("heatmap");
        const currentYear = new Date().getFullYear();
        let startDate = new Date(currentYear, 0, 1);
        const startDayOfWeek = startDate.getDay();
        startDate.setDate(startDate.getDate() - startDayOfWeek);

        const weeks = 53;
        const daysInWeek = 7;
        const endOfYear = new Date(currentYear, 11, 31);

        for (let w = 0; w < weeks; w++) {
            for (let d = 0; d < daysInWeek; d++) {
                const cellDate = new Date(startDate);
                cellDate.setDate(startDate.getDate() + (w * daysInWeek) + d);

                if (cellDate > endOfYear) break;

                const offset = cellDate.getTimezoneOffset();
                const localDate = new Date(cellDate.getTime() - (offset * 60 * 1000));
                const isoDate = localDate.toISOString().split('T')[0];
                const dateString = isoDate.split('-').reverse().join('.');

                const count = activityData[isoDate] || 0;
                const cell = document.createElement("div");
                cell.className = "heatmap-cell";

                if (cellDate.getFullYear() < currentYear) {
                    cell.style.visibility = 'hidden';
                    cell.setAttribute('data-tooltip', '');
                } else {
                    if (count > 0 && count <= 5) cell.classList.add("level-1");
                    else if (count > 5 && count <= 15) cell.classList.add("level-2");
                    else if (count > 15 && count <= 30) cell.classList.add("level-3");
                    else if (count > 30) cell.classList.add("level-4");

                    cell.setAttribute('data-tooltip', `${dateString}: ${count} {{ __('welcome.Num attempts') }}`);
                }
                heatmapEl.appendChild(cell);
            }
        }
    });
</script>
</body>
</html>
