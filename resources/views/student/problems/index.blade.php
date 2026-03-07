@extends('layouts.app')

@section('style')
    <style>
        /* --- TAYMER DIZAYNI --- */
        .countdown-wrapper {
            text-align: center;
            background: rgba(15, 23, 42, 0.4);
            border: 1px solid rgba(56, 189, 248, 0.2);
            border-radius: 16px;
            padding: 50px 20px;
            margin-top: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }

        .countdown-icon {
            font-size: 3.5rem;
            color: var(--primary-neon, #38bdf8);
            margin-bottom: 20px;
            animation: pulse-neon 2s infinite;
            filter: drop-shadow(0 0 10px rgba(56, 189, 248, 0.5));
        }

        .countdown-timer {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-top: 30px;
        }

        .time-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: rgba(30, 41, 59, 0.8);
            padding: 15px 20px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            min-width: 90px;
            box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.5);
        }

        .time-box span {
            font-family: 'Fira Code', monospace;
            font-size: 2.5rem;
            font-weight: 700;
            color: #fff;
            line-height: 1;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        .time-box small {
            color: #94a3b8;
            font-size: 0.85rem;
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .separator {
            font-family: 'Fira Code', monospace;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-neon, #38bdf8);
            margin-bottom: 25px; /* Kichik yozuvlarga moslash uchun */
            animation: blink 1s infinite;
        }

        @keyframes pulse-neon {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes blink {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.3;
            }
        }

        @media (max-width: 576px) {
            .countdown-timer {
                gap: 8px;
            }

            .time-box {
                min-width: 65px;
                padding: 10px;
            }

            .time-box span {
                font-size: 1.8rem;
            }

            .separator {
                font-size: 1.8rem;
                margin-bottom: 20px;
            }
        }

        .problem-status {
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: help;
            position: relative;
        }

        /* PENDING - Oddiy holat */
        .problem-status.pending {
            background: rgba(255, 255, 255, 0.03);
            color: #475569;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .problem-status.pending::before {
            content: "\f111";
            font-family: "Font Awesome 6 Free";
            font-weight: 400;
            font-size: 0.7rem;
        }

        /* ACCEPTED - Oltin rangli (Gold Shadow) */
        .problem-status.accepted {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.1), rgba(218, 165, 32, 0.2));
            color: #ffd700;
            border: 1px solid rgba(255, 215, 0, 0.4);

            /* Oltin rangli ko'p qatlamli soya */
            box-shadow: 0 0 5px rgba(255, 215, 0, 0.2),
            0 0 15px rgba(255, 215, 0, 0.15),
            inset 0 0 8px rgba(255, 215, 0, 0.1);

            text-shadow: 0 0 8px rgba(255, 215, 0, 0.6);
        }

        .problem-status.accepted::before {
            content: "\f058";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
        }

        /* Hover qilinganda oltin effekt kuchayishi */
        .problem-status.accepted:hover {
            transform: scale(1.15) rotate(5deg);
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.4),
            0 0 25px rgba(255, 215, 0, 0.3);
            border-color: rgba(255, 215, 0, 0.8);
        }
    </style>
@endsection

@section('content')
    <div class="content-body">
        <div class="section-header">
            <div>
                <div class="weeks-wrapper">
                    <div class="weeks-scroll">
                        @foreach($weeks as $week)
                            @php
                                $isLocked = now()->lessThan($week->started);
                                $isActive = $currentWeek && $currentWeek->id == $week->id;
                            @endphp

                            <a href="?week={{ $week->id }}"
                               class="week-item {{ $isActive ? 'active' : ($isLocked ? 'locked' : 'past') }}">

                                @if($isLocked)
                                    <i class="fas fa-lock"
                                       style="font-size: 0.6rem; position: absolute; top: 4px; right: 4px; color: rgba(255,255,255,0.3);"></i>
                                @endif
                                <span class="week-number">{{ $week->week_number }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <h2>{{ $activeTournament->name }}</h2>
                <p style="color: #94a3b8; font-size: 0.8rem; margin-top: 5px;">
                    @if($currentWeek)
                        {{ $currentWeek->week_number }}-tur: {{ $currentWeek->name }}
                    @else
                        Hali turlar boshlanmagan
                    @endif
                </p>
            </div>
        </div>

        @if($currentWeek && now()->lessThan($currentWeek->started))

            <div class="countdown-wrapper">
                <i class="fas fa-hourglass-half countdown-icon"></i>
                <h3 style="color: #fff; font-size: 1.5rem; margin-bottom: 10px;">{{ $currentWeek->week_number }}-tur
                    hali boshlanmagan</h3>
                <p style="color: #94a3b8; font-size: 1rem;">Tur boshlanishiga qadar qoldi:</p>

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
                            <div class="problem-status {{ $problem->is_solved > 0 ? 'accepted' : 'pending' }}"></div>
                            <div class="problem-details">
                                <h3 class="problem-title">#M{{ sprintf('%04d', $problem->id) }}
                                    - {{ $problem->name }}</h3>
                                <div class="problem-meta">
                                    <span style="font-size: 11px; font-family: 'Courier New'">
                                        Vaqt: {{ $problem->runtime }}s, Xotira: {{ $problem->memory }}MB
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="problem-action">
                            <div class="point-badge" style="text-align: center">
                                {{ $problem->point }} <span>ball</span>
                            </div>
                            <a href="{{ route('problems.show', $problem->id) }}" class="btn-open">Yechish</a>
                        </div>
                    </div>
                @empty
                    <div
                        style="text-align: center; width: 100%; padding: 40px; color: #64748b; background: rgba(30, 41, 59, 0.4); border-radius: 12px; border: 1px dashed rgba(255, 255, 255, 0.1);">
                        <i class="fas fa-code" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.3;"></i>
                        <p>Ushbu turda hozircha masalalar mavjud emas yoki qo'shilmoqda.</p>
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
