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
            <h1 class="section-title">Top 100 Reyting</h1>
            <p class="section-subtitle">Marafonning 4-haftasi natijalari</p>

            <div class="leaderboard-card">
                <table style="text-align: center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th style="text-align: left">Ishtirokchi</th>
                        <th>Mutaxassislik</th>
                        <th>Guruh</th>
                        <th>Haftalik natijalar</th>
                        <th>Umumiy ball</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="rank">#1</td>
                        <td class="user-info" style="text-align: left">
                            <span class="name">Asadov Dilshod</span>
                            <span class="sub-text">
                            Qoraqalpoq davlat universiteti
                        </span>
                        </td>
                        <td>Kompyuter injiniringi</td>
                        <td>KI-21-04</td>
                        <td>
                            <span class="week-badge">5</span><span class="week-badge">4</span><span
                                class="week-badge">5</span><span class="week-badge">5</span>
                        </td>
                        <td class="total-score">19</td>
                    </tr>
                    <tr>
                        <td class="rank">#2</td>
                        <td class="user-info" style="text-align: left">
                            <span class="name">Ibragimova Malika</span>
                            <span class="sub-text">
                            Qoraqalpoq davlat universiteti
                        </span>
                        </td>
                        <td>Dasturiy injiniring</td>
                        <td>DI-22-01</td>
                        <td>
                            <span class="week-badge">5</span><span class="week-badge">5</span><span
                                class="week-badge">4</span><span class="week-badge">4</span>
                        </td>
                        <td class="total-score">18</td>
                    </tr>
                    </tbody>
                </table>
            </div>
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
