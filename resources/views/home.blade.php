@extends('layouts.app')
@section('content')
    <div class="content-body">
        <div class="timer-banner">
            <div class="timer-info">
                <h3>⏳ 5-hafta boshlanishigacha</h3>
                <p>Ushbu haftadagi masalalarni ishlashga shoshiling!</p>
            </div>
            <div class="countdown" id="countdown">
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
        <div class="widgets-grid">
            <div class="widget-card">
                <div class="widget-icon">🏆</div>
                <div class="widget-title">Joriy pozitsiya</div>
                <div class="widget-value">#{{ $position }} <span>/ {{ $positions }}</span></div>
            </div>

            <div class="widget-card">
                <div class="widget-icon">⭐</div>
                <div class="widget-title">To‘plangan ball</div>
                <div class="widget-value">{{ $points }} <span>ball</span></div>
            </div>

            <div class="widget-card">
                <div class="widget-icon">✅</div>
                <div class="widget-title">Muvofaqqiyatli masalalar</div>
                <div class="widget-value">{{ $problems }} <span>ta</span></div>
            </div>

            <div class="widget-card">
                <div class="widget-icon">⚡</div>
                <div class="widget-title">Aniqlilik ko‘rsatkichi</div>
                <div class="widget-value">{{ $coefficient }}<span>%</span></div>
            </div>
        </div>

        <div class="section-header">
            <h2>Joriy turnir reytingi</h2>
            <a href="#" style="color: var(--primary-neon); text-decoration: none; font-size: 0.9rem;">
                Ro‘yxatni ko‘rish →
            </a>
        </div>

        <div class="leaderboard-card">
            <table style="text-align: center">
                <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="text-align: left">Ishtirokchi</th>
                    <th>Guruh</th>
                    <th style="width: 15%;">Hafta ko‘rsatkichlari</th>
                    <th style="width: 10%;">Umumiy</th>
                </tr>
                </thead>
                <tbody>
                @php($pos = 1)
                @forelse($users as $user)
                    <tr @if(auth()->id() == $user->id)class="active-user-row"@endif>
                        <td class="rank">#{{ $pos++ }}</td>
                        <td class="user-info" style="text-align: left">
                            <span class="name"
                                  style="text-transform: uppercase">{{ json_decode($user->name)->short }}</span>
                            <span class="sub-text">
                                {{ $user->university->name }}
                            </span>
                        </td>
                        <td>KI-21-04</td>
                        <td>
                            <span class="week-badge">4</span>
                            <span class="week-badge">5</span>
                            <span class="week-badge">4</span>
                            <span class="week-badge missed">0</span>
                        </td>
                        <td class="total-score">13</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="font-size: 12px">
                            Turnirdan ro‘yxatdan o‘tganlar topilmadi.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }

        document.addEventListener('click', function (event) {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.querySelector('.menu-toggle');

            if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target) && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
        const deadline = new Date("March 5, 2026 23:59:59").getTime();
        const x = setInterval(function () {
            const now = new Date().getTime();
            const distance = deadline - now;
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.getElementById("days").innerHTML = days.toString().padStart(2, '0');
            document.getElementById("hours").innerHTML = hours.toString().padStart(2, '0');
            document.getElementById("minutes").innerHTML = minutes.toString().padStart(2, '0');
            document.getElementById("seconds").innerHTML = seconds.toString().padStart(2, '0');

            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown").innerHTML = "<div style='color: var(--danger-red); font-weight: bold; font-size: 1.2rem; letter-spacing: 2px;'>VAQT TUGADI!</div>";
            }
        }, 1000);
    </script>
@endsection
