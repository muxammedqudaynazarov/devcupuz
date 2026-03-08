@extends('layouts.app')
@section('page_title', '🧩 Masalalar')
@section('page_title_desc', $activeTournament->name . ' musobaqasi masalalari')
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
