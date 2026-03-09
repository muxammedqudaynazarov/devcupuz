@extends('layouts.welcome')

@section('title', "Dasturchi talabalar maktabi")

@section('content')
    <main class="container">
        <section class="promo-banner">
            <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=1200&auto=format&fit=crop"
                 alt="Bosh sovrin banneri" class="banner-img">

            <div class="banner-content">
                <span class="banner-badge">🏆 Bosh sovrin</span>
                <h2>Eng yaxshilar uchun maxsus sovrinlar!</h2>
                <p>10 haftalik marafon g‘oliblari noutbuk, stajirovka va maxsus vaucherlar bilan taqdirlanadi. O‘z
                    mahoratingni ko‘rsat!</p>
                <a class="btn-join" href="{{ route('login') }}" style="font-size: small; text-decoration: none">
                    Turnirga qo‘shilish
                </a>
            </div>
        </section>

        <section id="reyting">
            <h1 class="section-title">Turnir Reytingi (TOP 5)</h1>
            <p class="section-subtitle">
                {{ $activeTournament->name ?? 'Mavjud turnir natijalari' }}
            </p>

            @if(isset($topUsers) && $topUsers->count() > 0)
                <div class="leaderboard-card" style="padding-left: 0; padding-right: 0">
                    <table style="text-align: center; width: 100%;">
                        <thead>
                        <tr>
                            <th style="width: 10%;">O‘rin</th>
                            <th style="text-align: left">Ishtirokchi</th>
                            <th style="width: 20%;">Ball</th>
                            <th style="width: 20%;">Urinishlar</th>
                            <th style="width: 20%;">Jarima</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($topUsers as $index => $rating)
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
                                        {{ json_decode($rating->user->name)->full }}
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
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="text-align: center; color: var(--text-color);">Hozircha natijalar mavjud emas.</p>
            @endif
        </section>

        <section id="fikrlar">
            <h2 class="section-title" style="font-size: 2rem;">Ishtirokchilar Fikri</h2>
            <p class="section-subtitle">Turnir haqida talabalarning taassurotlari</p>

            <div class="feedback-grid">
                <div class="feedback-card">
                    <p class="feedback-text">"Ushbu turnir orqali algoritmlash bo'yicha bilimlarimni amalda sinab
                        ko'rish
                        imkoniyatiga ega bo'ldim. Har haftalik qiyinlashib boruvchi masalalar juda qiziqarli!"</p>
                    <div class="feedback-author">
                        <div class="author-avatar">A</div>
                        <div class="author-info">
                            <h4>Azizbek Rahimov</h4>
                            <p>3-bosqich talabasi</p>
                        </div>
                    </div>
                </div>
                <div class="feedback-card">
                    <p class="feedback-text">"Raqobat ruhi juda kuchli. Reytingda o'z ismimni yuqorida ko'rish uchun har
                        kuni qo'shimcha o'qib, o'rganishga harakat qilyapman. Tashkilotchilarga rahmat."</p>
                    <div class="feedback-author">
                        <div class="author-avatar">M</div>
                        <div class="author-info">
                            <h4>Madina Aliyeva</h4>
                            <p>2-bosqich talabasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
