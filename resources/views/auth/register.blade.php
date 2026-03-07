<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevCup | Ro'yxatdan o'tish</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* CSS login bilan bir xil, faqat select uchun qo'shimchalar bor */
        :root { --bg-color: #0f172a; --card-bg: rgba(30, 41, 59, 0.7); --primary-neon: #38bdf8; --secondary-neon: #818cf8; --text-color: #f1f5f9; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background-color: var(--bg-color); color: var(--text-color); min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 20px; }

        .register-card { background: var(--card-bg); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 20px; padding: 40px; width: 100%; max-width: 550px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); text-align: center; }

        .logo { font-size: 2.2rem; font-weight: 800; margin-bottom: 10px; text-decoration: none; color: #fff; display: block; }
        .logo span { color: var(--primary-neon); }
        .subtitle { color: #94a3b8; font-size: 0.9rem; margin-bottom: 30px; }

        .form-group { margin-bottom: 18px; text-align: left; }
        .form-group label { display: block; margin-bottom: 8px; font-size: 0.85rem; color: #94a3b8; }

        .form-input, .form-select {
            width: 100%; height: 48px; padding: 0 15px; background: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 10px; color: #fff; font-size: 0.95rem; outline: none; transition: 0.3s;
        }

        .form-select { cursor: pointer; appearance: none; background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2338bdf8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right 15px center; background-size: 15px; }
        .form-select option { background: var(--bg-color); color: #fff; }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }

        .btn-register { width: 100%; height: 50px; margin-top: 15px; background: linear-gradient(135deg, var(--primary-neon), var(--secondary-neon)); color: #fff; border: none; border-radius: 10px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: 0.3s; box-shadow: 0 5px 15px rgba(56, 189, 248, 0.3); }
        .btn-register:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(56, 189, 248, 0.5); }

        .footer-link { margin-top: 25px; font-size: 0.9rem; color: #94a3b8; }
        .footer-link a { color: var(--primary-neon); text-decoration: none; font-weight: 600; margin-left: 5px; }
    </style>
</head>
<body>

<div class="register-card">
    <a href="/" class="logo">Dev<span>Cup</span></a>
    <p class="subtitle">Platformada yangi profil yaratish</p>
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label>Ismingiz</label>
                <input type="text" name="first_name" class="form-input" placeholder="" required>
            </div>
            <div class="form-group">
                <label>Familiyangiz</label>
                <input type="text" name="last_name" class="form-input" placeholder="" required>
            </div>
        </div>

        <div class="form-group">
            <label>Oliy ta’lim muassasasi</label>
            <select name="university_id" class="form-select" required>
                <option value="" disabled selected>Muassasani tanlang</option>
                @if(isset($universities) && count($universities) > 0)
                    @foreach($universities as $uni)
                        <option value="{{ $uni->id }}">{{ $uni->name }}</option>
                    @endforeach
                @else
                    <option value="">OTMlar yuklanmagan</option>
                @endif
            </select>
        </div>

        <div class="form-group">
            <label>Login</label>
            <input type="text" name="username" class="form-input" placeholder="ST12345" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Parol</label>
                <input type="password" name="password" class="form-input" placeholder="••••••••" required>
            </div>
            <div class="form-group">
                <label>Tasdiqlash</label>
                <input type="password" name="password_confirmation" class="form-input" placeholder="••••••••" required>
            </div>
        </div>

        <button type="submit" class="btn-register">Ro'yxatdan o'tish</button>
    </form>

    <div class="footer-link">
        Akkauntingiz bormi? <a href="{{ route('login') }}">Kirish</a>
    </div>
</div>

</body>
</html>
