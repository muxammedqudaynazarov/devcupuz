@extends('layouts.app')

@section('page_title', '🧩 Masalalar')
@section('page_title_desc', $activeTournament->name . ' musobaqasi masalalari')

@section('content')
    <style>
        .header-rows-container {
            display: flex;
            flex-direction: column;
            width: 100%;
            margin-bottom: 30px;
        }

        .weeks-row {
            width: 100%;
            margin-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05); /* Qatorlarni ajratuvchi chiziq */
        }

        .weeks-wrapper {
            width: 100%;
            overflow-x: auto;
            padding-bottom: 5px;
            scrollbar-width: thin;
            scrollbar-color: var(--primary-neon, #38bdf8) rgba(255, 255, 255, 0.05);
        }

        .weeks-scroll {
            display: flex;
            width: max-content;
        }

        .week-item {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 45px;
            height: 45px;
            border-radius: 12px;
            background: var(--bg-dark);
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: var(--text-color);
            font-weight: 700;
            text-decoration: none;
            position: relative;
        }

        .week-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .week-item.active {
            background: var(--card-bg);
            color: #fff;
        }

        .week-item.locked {
            opacity: 0.5;
            cursor: not-allowed;
            background: var(--bg-dark);
            border: 1px solid var(--text-color);
        }

        .tournament-info-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .countdown-wrapper {
            background: rgba(30, 41, 59, 0.4);
            border: 1px dashed rgba(56, 189, 248, 0.3);
            border-radius: 16px;
            padding: 40px;
            text-align: center;
        }

        .countdown-icon {
            font-size: 3rem;
            color: #38bdf8;
            margin-bottom: 15px;
        }

        .countdown-timer {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-top: 25px;
        }

        .time-box {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 15px 20px;
            min-width: 90px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .time-box span {
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            font-variant-numeric: tabular-nums;
        }

        .time-box small {
            color: #94a3b8;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px;
        }

        .separator {
            font-size: 2rem;
            font-weight: 800;
            color: #38bdf8;
        }

        .problems-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .problem-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--bg-color);
            border-radius: 12px;
            padding: 20px 25px;
        }

        .problem-card:hover {
            background: var(--card-bg);
            border-color: transparent;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .problem-main {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .problem-status {
            width: 14px;
            height: 14px;
            border-radius: 50%;
        }

        .problem-status.accepted {
            background: #10b981;
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);
        }

        .problem-status.pending {
            background: #64748b;
            border: 2px solid #334155;
        }

        .problem-title {
            color: var(--text-color);
            font-size: 1.15rem;
            font-weight: 700;
            margin: 0 0 5px 0;
        }

        .problem-meta {
            color: #94a3b8;
            font-size: 0.85rem;
        }

        .problem-action {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .point-badge {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.2);
            padding: 5px 12px;
            border-radius: 8px;
            font-weight: 800;
            font-size: 1.1rem;
        }

        .point-badge span {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .btn-open {
            background: transparent;
            color: #38bdf8;
            border: 1px solid #38bdf8;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-open:hover {
            background: #38bdf8;
            color: #0f172a;
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.4);
        }

        @keyframes blink {
            50% {
                opacity: 0;
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
    </style>

    <div class="content-body">

        <div class="header-rows-container">

            <div class="weeks-row">
                <div class="weeks-wrapper">
                    <div class="weeks-scroll">
                        @foreach($weeks as $week)
                            @php
                                $isLocked = now()->lessThan($week->started);
                                $isActive = $currentWeek && $currentWeek->id == $week->id;
                            @endphp

                            <a href="?week={{ $week->id }}"
                               class="week-item {{ $isActive ? 'active' : ($isLocked ? 'locked' : 'past') }}"
                               title="{{ $week->name }}">

                                @if($isLocked)
                                    <i class="fas fa-lock"
                                       style="font-size: 0.7rem; position: absolute; top: 6px; right: 6px; color: rgba(255,255,255,0.4);"></i>
                                @endif
                                <span class="week-number">{{ $week->week_number }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="tournament-info-row">
                <div class="header-info">
                    <h1 style="margin: 0; font-size: 1.8rem; color: var(--text-color); font-weight: 800;">
                        {{ $activeTournament->name }}
                    </h1>
                    <div style="display: flex; align-items: center; gap: 10px; margin-top: 5px;">
                        @if($currentWeek)
                            <div style="color: var(--text-color); font-size: 0.95rem;">
                                {{ $currentWeek->week_number }}-tur: {{ $currentWeek->name }}
                                ({{ $currentWeek->started->format('d.m.Y H:i') }} -
                                {{ $currentWeek->finished->format('d.m.Y H:i') }})
                            </div>
                        @else
                            <span style="color: #64748b; font-size: 0.9rem;"><i class="fas fa-info-circle"></i> Hali turlar boshlanmagan</span>
                        @endif
                    </div>
                </div>
                @if(now()->greaterThanOrEqualTo($currentWeek->started))
                    <div class="header-actions">
                        <a href="{{ route('ratings.show', $currentWeek->id) }}" class="btn-create"
                           style="text-decoration: none; display: inline-flex; align-items: center; gap: 10px; padding: 12px 24px; background: #3b82f6; color: #fff; border-radius: 10px; font-weight: 700; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3); white-space: nowrap; transition: 0.3s;">
                            <i class="fas fa-trophy"></i>
                            Hafta reytingi
                        </a>
                    </div>
                @endif
            </div>
        </div>
        @if($currentWeek && now()->lessThan($currentWeek->started))
            <div class="countdown-wrapper">
                <i class="fas fa-hourglass-half countdown-icon"></i>
                <h3 style="color: #fff; font-size: 1.5rem; margin-bottom: 10px;">{{ $currentWeek->week_number }}-tur
                    hali boshlanmagan</h3>
                <p style="color: #94a3b8; font-size: 1rem;">Ushbu turdagi masalalar ochilishiga qoldi:</p>

                <div class="countdown-timer" id="countdown-timer"
                     data-time="{{ $currentWeek->started->format('Y-m-d\TH:i:s') }}">
                    <div class="time-box"><span id="days">00</span><small>Kun</small></div>
                    <div class="separator">:</div>
                    <div class="time-box"><span id="hours">00</span><small>Soat</small></div>
                    <div class="separator">:</div>
                    <div class="time-box"><span id="minutes">00</span><small>Daqiqa</small></div>
                    <div class="separator">:</div>
                    <div class="time-box"><span id="seconds">00</span><small>Soniya</small></div>
                </div>
            </div>
        @else
            <div class="problems-container">
                @forelse($problems as $problem)
                    <div class="problem-card">
                        <div class="problem-main">
                            <div class="problem-status {{ $problem->is_solved > 0 ? 'accepted' : 'pending' }}"
                                 title="{{ $problem->is_solved > 0 ? 'Yechilgan' : 'Yechilmagan' }}"></div>
                            <div class="problem-details">
                                <h3 class="problem-title">
                                    #M{{ sprintf('%04d', $problem->id) }} - {{ $problem->name }}
                                </h3>
                                <div class="problem-meta">
                                <span
                                    style="font-family: 'Courier New', Courier, monospace; padding: 3px 8px; border-radius: 4px; border: 1px solid var(--border-light)">
                                    <i class="fas fa-stopwatch"></i> {{ $problem->runtime }}s
                                </span>
                                    <span
                                        style="font-family: 'Courier New', Courier, monospace; padding: 3px 8px; border-radius: 4px;  border: 1px solid var(--border-light)">
                                    <i class="fas fa-memory"></i> {{ $problem->memory }}MB
                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="problem-action">
                            <div class="point-badge">
                                {{ $problem->point }} <span>ball</span>
                            </div>
                            <a href="{{ route('problems.show', $problem->id) }}" class="btn-open">
                                Yechish
                                <i class="fas fa-arrow-right" style="margin-left: 5px; font-size: 0.8rem;"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div
                        style="text-align: center; width: 100%; padding: 60px 20px; color: #64748b; background: rgba(30, 41, 59, 0.3); border-radius: 16px; border: 1px dashed rgba(255, 255, 255, 0.1);">
                        <div
                            style="width: 80px; height: 80px; background: rgba(15, 23, 42, 0.5); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto;">
                            <i class="fas fa-code" style="font-size: 2.5rem; color: #475569;"></i>
                        </div>
                        <h3 style="color: #cbd5e1; font-size: 1.2rem; margin-bottom: 10px;">
                            Masalalar topilmadi
                        </h3>
                        <p style="margin: 0;">
                            Ushbu turda hozircha masalalar mavjud emas yoki admin tomonidan qo'shilmoqda.
                        </p>
                    </div>
                @endforelse
            </div>
        @endif

    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const timerElement = document.getElementById('countdown-timer');
            if (!timerElement) return;
            const targetDate = new Date(timerElement.getAttribute('data-time')).getTime();
            const interval = setInterval(function () {
                const now = new Date().getTime();
                const distance = targetDate - now;
                if (distance < 0) {
                    clearInterval(interval);
                    window.location.reload();
                    return;
                }
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                document.getElementById("days").innerText = days.toString().padStart(2, '0');
                document.getElementById("hours").innerText = hours.toString().padStart(2, '0');
                document.getElementById("minutes").innerText = minutes.toString().padStart(2, '0');
                document.getElementById("seconds").innerText = seconds.toString().padStart(2, '0');
            }, 1000);
        });
    </script>
@endsection
