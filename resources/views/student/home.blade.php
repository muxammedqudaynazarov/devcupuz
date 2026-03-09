@extends('layouts.app')
@section('page_title', '🏠 Asosiy sahifa')
@section('page_title_desc', 'Sizning shaxsiy ma’lumot va natijalaringiz dashboardi')
@section('content')
    <div class="content-body">

        {{-- 1 & 4 - SHART: Turnir aktiv bo'lsa va keyingi tur (hafta) mavjud bo'lsa taymer chiqadi --}}
        @if(isset($activeTournament) && isset($nextWeek))
            <div class="timer-banner">
                <div class="timer-info">
                    <h3>⏳ {{ $nextWeek->week_number ?? '' }}-tur boshlanishigacha</h3>
                    <p>{{ $activeTournament->name }} musobaqasining yangi masalalarini ishlashga tayyor turing!</p>
                </div>
                {{-- JS uchun vaqtni data-time orqali beramiz --}}
                <div class="countdown" id="countdown" data-time="{{ $nextWeek->started->format('M d, Y H:i:s') }}">
                    <div class="time-box">
                        <span id="days">00</span>
                        <small>Kun</small>
                    </div>
                    <div class="time-box">
                        <span id="hours">00</span>
                        <small>Soat</small>
                    </div>
                    <div class="time-box">
                        <span id="minutes">00</span>
                        <small>Daqiqa</small>
                    </div>
                    <div class="time-box">
                        <span id="seconds">00</span>
                        <small>Soniya</small>
                    </div>
                </div>
            </div>
        @endif

        {{-- 2 - SHART: Widgetlar statistikasi --}}
        <div class="widgets-grid">
            <div class="widget-card">
                <div class="widget-icon">🏆</div>
                <div class="widget-title">Joriy pozitsiya</div>
                <div class="widget-value">#{{ $position ?? 0 }} <span>/ {{ $positions ?? 0 }}</span></div>
            </div>

            <div class="widget-card">
                <div class="widget-icon">⭐</div>
                <div class="widget-title">To‘plangan ball</div>
                <div class="widget-value">{{ $points ?? 0 }} <span>ball</span></div>
            </div>

            <div class="widget-card">
                <div class="widget-icon">✅</div>
                <div class="widget-title">Muvofaqqiyatli masalalar</div>
                <div class="widget-value">{{ $problems ?? 0 }} <span>ta</span></div>
            </div>

            <div class="widget-card">
                <div class="widget-icon">⚡</div>
                <div class="widget-title">Aniqlilik ko‘rsatkichi</div>
                <div class="widget-value">{{ $coefficient ?? 0 }}<span>%</span></div>
            </div>
        </div>

        {{-- 3 - SHART: Turnir reytingi (Faqat turnir tanlangan va reyting mavjud bo'lsa chiqadi) --}}
        @if(isset($activeTournament) && isset($topUsers) && $topUsers->count() > 0)
            <div class="section-header">
                <h2>Turniri reytingi (TOP5)</h2>
                <a href="{{ route('ratings.index') }}"
                   style="color: var(--primary-neon); text-decoration: none; font-size: 0.9rem; font-weight: 600;">
                    To‘liq ro‘yxatni ko‘rish →
                </a>
            </div>

            <div class="leaderboard-card">
                <table class="admin-table" style="text-align: center">
                    <thead>
                    <tr>
                        <th style="width: 5%;">O‘rin</th>
                        <th style="text-align: left">Ishtirokchi</th>
                        <th style="width: 15%;">Ball</th>
                        <th style="width: 15%;">Urinishlar</th>
                        <th style="width: 15%;">Jarima</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($topUsers as $index => $rating)
                        <tr @if(auth()->id() == $rating->user_id) class="active-user-row" @endif>
                            <td class="rank">
                                @if($index == 0)
                                    🥇
                                @elseif($index == 1)
                                    🥈
                                @elseif($index == 2)
                                    🥉
                                @else
                                    #{{ $index + 1 }}
                                @endif
                            </td>
                            <td class="user-info" style="text-align: left">
                                <a href="{{ route('user.show', $rating->user->username) }}" class="name"
                                   style="color: var(--text-color);font-weight: bold; text-decoration: none ">
                                    {{ json_decode($rating->user->name)->full }}
                                </a>
                                <div class="sub-text" style="font-size: x-small">
                                    {{ $rating->user->university->name }}
                                </div>
                            </td>
                            <td>
                                {{ $rating->score }}
                            </td>
                            <td>
                                {{ $rating->attempts }}
                            </td>
                            <td>
                                {{ $rating->penalty > 0 ? '-' . $rating->penalty : 0 }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script>
        // Sidebar toggle logic
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }

        document.addEventListener('click', function (event) {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.querySelector('.menu-toggle');

            if (sidebar && toggleBtn) {
                if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target) && sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                }
            }
        });

        // Dinamik Taymer (Faqatgina taymer HTMLda mavjud bo'lsagina ishlaydi)
        document.addEventListener("DOMContentLoaded", function () {
            const countdownEl = document.getElementById("countdown");
            if (!countdownEl) return; // Agar taymer sahifada yo'q bo'lsa JS xato bermay to'xtaydi

            const targetTimeStr = countdownEl.getAttribute("data-time");
            if (!targetTimeStr) return;

            const deadline = new Date(targetTimeStr).getTime();

            const x = setInterval(function () {
                const now = new Date().getTime();
                const distance = deadline - now;

                if (distance < 0) {
                    clearInterval(x);
                    countdownEl.innerHTML = "<div style='color: var(--danger-red); font-weight: bold; font-size: 1.2rem; letter-spacing: 2px;'>TUR BOSHLANDI!</div>";
                    // Agar avtomat yangilanishni xohlasangiz pastdagi kodni izohdan chiqaring:
                    // window.location.reload();
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("days").innerHTML = days.toString().padStart(2, '0');
                document.getElementById("hours").innerHTML = hours.toString().padStart(2, '0');
                document.getElementById("minutes").innerHTML = minutes.toString().padStart(2, '0');
                document.getElementById("seconds").innerHTML = seconds.toString().padStart(2, '0');
            }, 1000);
        });
    </script>
@endsection
