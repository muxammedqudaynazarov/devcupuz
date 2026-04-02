@extends('layouts.welcome')

@section('style')
    <style>
        .hero-carousel {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            background: var(--card-bg, #1e293b);
            border: 1px solid var(--border-light, rgba(255, 255, 255, 0.05));
            margin-bottom: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .hero-track {
            display: flex;
            transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .hero-slide {
            min-width: 100%;
            display: flex;
            align-items: center;
        }

        /* KATTA RASMLI SLAYD DIZAYNI (Rasmdagidek) */
        .hero-slide.large-layout {
            padding: 0;
            min-height: 350px;
            background: #161e2e;
        }

        /* Fon rangi rasmdagidek qoramtir-ko'k */
        .hero-slide.large-layout .hero-img-container {
            flex: 0 0 50%;
            height: 100%;
            min-height: 350px;
        }

        .hero-slide.large-layout .hero-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .hero-slide.large-layout .hero-info {
            flex: 0 0 50%;
            padding: 40px;
            text-align: left;
        }

        /* AVATARLI SLAYD DIZAYNI (2-slayd uchun) */
        .hero-slide.avatar-layout {
            padding: 30px;
            justify-content: center;
            gap: 20px;
            min-height: 350px;
            text-align: center;
        }

        .hero-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid var(--primary-neon, #38bdf8);
            object-fit: cover;
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.3);
        }

        .hero-info h3 {
            color: var(--text-color, #fff);
            font-size: 1.8rem;
            margin-bottom: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .hero-info .badge {
            background: rgba(56, 189, 248, 0.1);
            color: var(--primary-neon, #38bdf8);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.95rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 15px;
            border: 1px solid rgba(56, 189, 248, 0.3);
        }

        .hero-info p {
            color: var(--text-muted, #94a3b8);
            font-size: 1rem;
            font-style: italic;
            line-height: 1.6;
        }

        .hero-indicators {
            position: absolute;
            bottom: 15px;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 8px;
            z-index: 10;
        }

        .hero-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: 0.3s;
        }

        .hero-dot.active {
            background: var(--primary-neon, #38bdf8);
            box-shadow: 0 0 10px var(--primary-neon, #38bdf8);
            transform: scale(1.3);
        }

        @media (max-width: 768px) {
            .hero-slide.large-layout {
                flex-direction: column;
            }

            .hero-slide.large-layout .hero-img-container {
                width: 100%;
                height: 250px;
                min-height: 250px;
            }

            .hero-slide.large-layout .hero-info {
                width: 100%;
                padding: 25px;
                text-align: center;
            }

            .hero-slide.avatar-layout {
                flex-direction: column;
            }
        }
    </style>
@endsection
@section('content')
    <main class="container">
        @if($prize)
            <section class="promo-banner">
                <img src="{{ asset('storage/' . $prize->image) }}" alt="Banner" class="banner-img">
                <div class="banner-content">
                    <span class="banner-badge">🏆 {{ __('welcome.Tournament main prize') }}</span>
                    <h2>{{ $prize->title }}</h2>
                    <p style="text-align: justify">
                        {{ $prize->desc }}
                    </p>
                    <a class="btn-join" href="{{ route('login') }}" style="font-size: small; text-decoration: none">
                        {{ __('welcome.Join the tournament') }}
                    </a>
                </div>
            </section>
        @endif
        {{--@if(isset($topUsers) && $topUsers->count() > 0)--}}
        <section id="hafta-qahramonlari">
            <h2 class="section-title">
                {{ __('welcome.Heroes of the week') }}
            </h2>
            <p class="section-subtitle">{{ __('welcome.Participants with the best results each week') }}</p>
            <div class="hero-carousel">
                <div class="hero-track" id="heroTrack">
                    @forelse($heroes as $heroe)
                        <div class="hero-slide large-layout">
                            <div class="hero-img-container">
                                <img src="{{ $heroe->image }}"
                                     alt="{{ $heroe->user->name['full'] }}">
                            </div>
                            <div class="hero-info">
                                <h3>{{ $heroe->user->name['full'] }}</h3>
                                <div style="font-size: small" class="badge">
                                    {{ __('welcome.Week :week winner (:pts points)', ['week' => $heroe->week->week_number, 'pts' => $heroe->points]) }}
                                </div>
                                <p style="text-align: justify">{{ $heroe->desc }}</p>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
                <div class="hero-indicators" id="heroIndicators">
                    <span class="hero-dot active" data-slide="0"></span>
                    @if(count($heroes) > 1)
                        @for($i = 1; $i < count($heroes); $i++)
                            <span class="hero-dot" data-slide="{{ $i }}"></span>
                        @endfor
                    @endif
                </div>
            </div>
        </section>

        <section id="reyting">
            <h2 class="section-title">{{ __('welcome.Tournament ranking') }} (TOP 5)</h2>
            <p class="section-subtitle">
                {{ $activeTournament->name ?? __('welcome.Tournament results') }}
            </p>
            <div class="leaderboard-card" style="padding-left: 0; padding-right: 0">
                <table style="text-align: center; width: 100%;">
                    <thead>
                    <tr>
                        <th style="width: 10%;">{{ __('welcome.Rank') }}</th>
                        <th style="text-align: left">{{ __('welcome.Participant') }}</th>
                        <th style="width: 20%;">{{ __('welcome.Point') }}</th>
                        <th style="width: 20%;">{{ __('welcome.Attempts') }}</th>
                        <th style="width: 20%;">{{ __('welcome.Penalty') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($topUsers as $index => $rating)
                        <tr>
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
                                   style="font-weight: bold; text-decoration: none; color: var(--text-color)">
                                    {{ $rating->user->name['full'] }}
                                </a>
                                <div class="sub-text"
                                     style="font-size: x-small; color: var(--text-color); opacity: 0.7;">
                                    {{ $rating->user->university->name ?? '' }}
                                </div>
                            </td>
                            <td class="total-score">
                                {{ $rating->score }}
                            </td>
                            <td>
                                {{ $rating->attempts }}
                            </td>
                            <td>
                                {{ $rating->penalty > 0 ? '-' . $rating->penalty : 0 }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="color: #777; font-size: 12px">
                                {{ __('welcome.No results are available yet.') }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>
        {{--@endif--}}
        @if(count($comments))
            <section id="fikrlar">
                <h2 class="section-title" style="font-size: 2rem;">{{ __('welcome.Participants’ opinions') }}</h2>
                <p class="section-subtitle">{{ __('welcome.Participants’ impressions of the tournament') }}</p>

                <div class="feedback-grid">
                    @forelse($comments as $comment)
                        <div class="feedback-card">
                            <p class="feedback-text">"{{ $comment->text }}"</p>
                            <div class="feedback-author">
                                <div class="author-avatar">A</div>
                                <div class="author-info">
                                    <h4>{{ $comment->user->name['full'] }}</h4>
                                    <p style="font-size: 10px">
                                        {{ $comment->user_work }}
                                        <br>
                                        @for($i = 1; $i<= $comment->rating; $i++)
                                            <i class="fa fa-star" style="color: yellow"></i>
                                        @endfor
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </section>
        @endif
    </main>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const track = document.getElementById('heroTrack');
            const dots = document.querySelectorAll('.hero-dot');
            let currentIndex = 0;
            let slideCount = dots.length;

            function goToSlide(index) {
                track.style.transform = `translateX(-${index * 100}%)`;
                dots.forEach(d => d.classList.remove('active'));
                dots[index].classList.add('active');
                currentIndex = index;
            }

            // 10 soniyada avtomatik aylanadi
            let slideInterval = setInterval(() => {
                let nextIndex = (currentIndex + 1) % slideCount;
                goToSlide(nextIndex);
            }, 10000);

            // Nuqtalarni bosganda o'tish
            dots.forEach((dot, idx) => {
                dot.addEventListener('click', () => {
                    goToSlide(idx);
                    // Bosilganda taymerni qayta ishga tushirish (pauza qilib)
                    clearInterval(slideInterval);
                    slideInterval = setInterval(() => {
                        let nextIndex = (currentIndex + 1) % slideCount;
                        goToSlide(nextIndex);
                    }, 10000);
                });
            });
        });
    </script>
@endsection
