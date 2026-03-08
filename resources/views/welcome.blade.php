<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Cup | 10 Haftalik Marafon</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;600;700&family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --bg-color: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --primary-neon: #38bdf8;
            --secondary-neon: #818cf8;
            --accent-green: #4ade80;
            --text-color: #f1f5f9;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* Asosiy shrift qilib Poppins belgilandi */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            background-image: radial-gradient(circle at top right, #1e1b4b, transparent),
            radial-gradient(circle at bottom left, #0f172a, transparent);
            color: var(--text-color);
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* --- Navbar --- */
        nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 15px 0;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-color);
            text-decoration: none;
            letter-spacing: 1px;
        }

        .logo span {
            color: var(--primary-neon);
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 30px;
        }

        .nav-links a {
            color: #94a3b8;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary-neon);
        }

        .btn-login {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary-neon), var(--secondary-neon));
            color: #fff;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(56, 189, 248, 0.3);
            text-decoration: none;
        }

        .btn-login:hover {
            box-shadow: 0 6px 20px rgba(56, 189, 248, 0.6);
        }

        /* --- Asosiy qism --- */
        main {
            padding: 60px 0;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            background: linear-gradient(to right, var(--primary-neon), var(--secondary-neon));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .section-subtitle {
            text-align: center;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 30px;
            font-weight: 100;
            font-size: 11px;
        }

        /* --- Reyting Jadvali --- */
        .leaderboard-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            margin-bottom: 80px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            min-width: 800px;
        }

        th {
            padding: 15px;
            color: var(--primary-neon);
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            text-transform: uppercase;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        tr:hover {
            background: rgba(255, 255, 255, 0.03);
            transition: 0.3s;
        }

        .rank {
            font-family: 'Fira Code', monospace;
            font-weight: 700;
            color: var(--accent-green);
            font-size: 1.1rem;
        }

        .user-info .name {
            display: block;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .user-info .sub-text {
            font-size: 0.8rem;
            color: #94a3b8;
            font-weight: 300;
        }

        .week-badge {
            font-family: 'Fira Code', monospace;
            display: inline-block;
            width: 28px;
            height: 28px;
            line-height: 28px;
            text-align: center;
            background: rgba(56, 189, 248, 0.1);
            border: 1px solid var(--primary-neon);
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-right: 4px;
        }

        .total-score {
            font-family: 'Fira Code', monospace;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary-neon);
        }

        .tag {
            background: var(--secondary-neon);
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.7rem;
            margin-left: 5px;
            font-weight: 500;
        }

        /* --- Fikrlar Section --- */
        .feedback-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feedback-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .feedback-card::before {
            content: '"';
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 4rem;
            color: rgba(56, 189, 248, 0.1);
            font-family: serif;
        }

        .feedback-text {
            text-align: justify;
            font-size: 14px;
            line-height: 1.7;
            color: #cbd5e1;
            margin-bottom: 20px;
            font-weight: 200;
        }

        .feedback-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .author-avatar {
            font-family: 'Poppins', sans-serif;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: var(--primary-neon);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--bg-color);
        }

        .author-info h4 {
            margin-bottom: 3px;
            font-size: 1rem;
            font-weight: 600;
        }

        .author-info p {
            font-size: 0.8rem;
            color: #94a3b8;
            font-weight: 400;
        }

        /* --- Promo Banner --- */
        .promo-banner {
            position: relative;
            width: 100%;
            min-height: 350px;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 60px;
            display: flex;
            align-items: center;
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 1em;
        }

        .banner-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
            opacity: 0.4;
            transition: transform 0.5s ease;
        }

        .promo-banner:hover .banner-img {
            transform: scale(1.05);
        }

        .promo-banner::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.5) 50%, transparent 100%);
            z-index: 2;
        }

        .banner-content {
            position: relative;
            z-index: 3;
            padding: 40px;
            max-width: 600px;
        }

        .banner-badge {
            display: inline-block;
            background: rgba(74, 222, 128, 0.2);
            color: var(--accent-green);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 15px;
            border: 1px solid var(--accent-green);
        }

        .banner-content h2 {
            font-size: 2.2rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 15px;
            color: #fff;
        }

        .banner-content p {
            color: #cbd5e1;
            line-height: 1.6;
            margin-bottom: 25px;
            font-size: 1rem;
        }

        .btn-join {
            font-family: 'Poppins', sans-serif;
            background: transparent;
            color: var(--primary-neon);
            border: 2px solid var(--primary-neon);
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-join:hover {
            background: var(--primary-neon);
            color: var(--bg-color);
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.5);
        }

        /* --- Footer --- */
        footer {
            background: rgba(15, 23, 42, 0.9);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding: 40px 0;
            margin-top: 40px;
        }

        .footer-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-left .logo {
            font-size: 1.5rem;
            margin-bottom: 10px;
            display: inline-block;
        }

        .footer-text {
            color: #94a3b8;
            font-size: 0.9rem;
            max-width: 300px;
            font-weight: 300;
        }

        .footer-right {
            text-align: right;
        }

        .social-links {
            margin-bottom: 15px;
        }

        .social-links a {
            color: var(--primary-neon);
            text-decoration: none;
            margin-left: 20px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .social-links a:hover {
            color: var(--secondary-neon);
            text-shadow: 0 0 10px rgba(129, 140, 248, 0.5);
        }

        .copyright {
            color: #64748b;
            font-size: 0.8rem;
            font-family: 'Fira Code', monospace;
        }

        /* =======================================================
           MOBIL EKRANLAR UCHUN MOSLASHUV (RESPONSIVE)
           ======================================================= */
        @media (max-width: 768px) {
            /* Sarlavhalar */
            .section-title { font-size: 1.8rem; }
            .section-subtitle { font-size: 0.75rem; margin-bottom: 20px; }

            /* Navbar */
            .nav-links { display: none; /* Mobilda markazdagi linklarni yashiramiz */ }
            .nav-container { padding: 5px 0; }
            .logo { font-size: 1.3rem; }
            .btn-login { padding: 8px 18px; font-size: 0.9rem; }

            /* Promo Banner */
            main { padding: 30px 0; }
            .promo-banner {
                min-height: 250px;
                margin-top: 0;
                margin-bottom: 40px;
                border-radius: 15px;
            }
            .banner-content { padding: 25px 20px; }
            .banner-content h2 { font-size: 1.5rem; margin-bottom: 10px; }
            .banner-content p { font-size: 0.9rem; margin-bottom: 20px; }
            .btn-join { width: 100%; text-align: center; } /* Tugma 100% enlikda */

            /* Jadval Qismi */
            .leaderboard-card {
                padding: 15px;
                border-radius: 15px;
                margin-bottom: 40px;
            }
            /* Jadval gorizontal scroll bo'lishi saqlanadi, matnlar maydalashadi */
            th, td { padding: 10px; font-size: 0.85rem; }
            .user-info .name { font-size: 1rem; }
            .total-score { font-size: 1.1rem; }

            /* Fikrlar qismi */
            .feedback-grid { gap: 20px; }
            .feedback-card { padding: 25px 20px; }
            .feedback-card::before { right: 15px; top: 5px; font-size: 3rem; }

            /* Footer */
            .footer-container {
                flex-direction: column;
                text-align: center;
                gap: 30px;
            }
            .footer-text { margin: 0 auto; }
            .footer-right { text-align: center; }
            .social-links a { margin: 0 10px; }
        }
    </style>
</head>
<body>

<nav>
    <div class="container nav-container">
        <a href="#" class="logo">Dev<span>Cup.uz</span></a>
        <ul class="nav-links">
            <li><a href="#">Asosiy</a></li>
            <li><a href="#reyting">Reyting</a></li>
            <li><a href="#qoidalar">Qoidalar</a></li>
            <li><a href="#fikrlar">Fikrlar</a></li>
        </ul>
        @auth
            <a href="{{ route('home') }}" class="btn-login">Kabinet</a>
        @else
            <a href="{{ route('login') }}" class="btn-login">Kirish</a>
        @endauth
    </div>
</nav>

<main class="container">
    <section class="promo-banner">
        <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=1200&auto=format&fit=crop"
             alt="Bosh sovrin banneri" class="banner-img">

        <div class="banner-content">
            <span class="banner-badge">🏆 Bosh sovrin</span>
            <h2>Eng yaxshilar uchun maxsus sovrinlar!</h2>
            <p>10 haftalik marafon g'oliblari noutbuk, stajirovka va maxsus vaucherlar bilan taqdirlanadi. O'z
                mahoratingni ko'rsat!</p>
            <button class="btn-join">Turnirga qo'shilish</button>
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
                <p class="feedback-text">"Ushbu turnir orqali algoritmlash bo'yicha bilimlarimni amalda sinab ko'rish
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
<footer>
    <div class="container footer-container">
        <div class="footer-left">
            <a href="#" class="logo">Dev<span>Cup.uz</span></a>
            <p class="footer-text">Talabalar o'rtasida 10 haftalik dasturlash marafoni. O'z mahoratingni ko'rsat va eng
                yaxshilardan bo'l!</p>
        </div>
        <div class="footer-right">
            <div class="social-links">
                <a href="#">Telegram Bot</a>
                <a href="#">Guruhimiz</a>
                <a href="#">GitHub</a>
            </div>
            <p class="copyright">&copy; 2026 CodeCup. Barcha huquqlar himoyalangan.</p>
        </div>
    </div>
</footer>
</body>
</html>
