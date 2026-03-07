<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevCup | Kirish</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-color: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --primary-neon: #38bdf8;
            --secondary-neon: #818cf8;
            --text-color: #f1f5f9;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            background-image: radial-gradient(circle at top right, #1e1b4b, transparent),
            radial-gradient(circle at bottom left, #0f172a, transparent);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-card {
            background: var(--card-bg);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .logo {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 10px;
            text-decoration: none;
            color: #fff;
            display: block;
        }

        .logo span {
            color: var(--primary-neon);
        }

        .subtitle {
            color: #94a3b8;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.85rem;
            color: #94a3b8;
        }

        .form-input {
            width: 100%;
            height: 50px;
            padding: 0 15px;
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: #fff;
            font-size: 1rem;
            outline: none;
            transition: 0.3s;
        }

        .form-input:focus {
            border-color: var(--primary-neon);
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.2);
        }

        .btn-login {
            width: 100%;
            height: 50px;
            margin-top: 10px;
            background: linear-gradient(135deg, var(--primary-neon), var(--secondary-neon));
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(56, 189, 248, 0.4);
        }

        .footer-link {
            margin-top: 25px;
            font-size: 0.9rem;
            color: #94a3b8;
        }

        .footer-link a {
            color: var(--primary-neon);
            text-decoration: none;
            font-weight: 600;
            margin-left: 5px;
        }

        .footer-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-card">
    <a href="/" class="logo">Dev<span>CUP.uz</span></a>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Login</label>
            <input type="text" name="username" class="form-input" placeholder="Sizning login" required>
        </div>

        <div class="form-group">
            <label> Parol</label>
            <input type="password" name="password" class="form-input" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn-login">Kirish</button>
    </form>

    <div class="footer-link">
        Akkauntingiz yo‘qmi? <a href="{{ route('register') }}">Ro‘yxatdan o‘ting</a>
    </div>
</div>

</body>
</html>
