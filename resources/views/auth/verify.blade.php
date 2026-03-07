<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DevCup | Raqamni tasdiqlash</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --bg-color: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --primary-neon: #38bdf8;
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
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .verify-card {
            background: var(--card-bg);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .icon-box {
            width: 80px;
            height: 80px;
            background: rgba(56, 189, 248, 0.1);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
            color: var(--primary-neon);
            font-size: 2.5rem;
        }

        .title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #94a3b8;
            font-size: 0.9rem;
            margin-bottom: 30px;
            line-height: 1.5;
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

        .btn-action {
            width: 100%;
            height: 50px;
            background: var(--primary-neon);
            color: var(--bg-color);
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(56, 189, 248, 0.4);
        }

        /* Kod kiritish qismi yashirin turadi */
        #code-section {
            display: none;
        }
    </style>
</head>
<body>
<div class="verify-card">
    <div class="icon-box"><i class="fas fa-shield-alt"></i></div>
    <h2 class="title">Xavfsizlik tekshiruvi</h2>

    <div id="phone-section" style="{{ $step == 'step2' ? 'display: none;' : '' }}">
        <p class="subtitle">SMS kod olish uchun telefon raqamingizni kiriting.</p>
        <div class="form-group">
            <label>Telefon raqamingiz</label>
            <input type="text" id="phone_number" class="form-input"
                   placeholder="998901234567"
                   value="{{ session('verify_phone', '998') }}"
                   maxlength="12">
        </div>
        <button type="button" class="btn-action" id="btn-send-sms" onclick="sendSmsCode()">SMS Kod yuborish</button>
    </div>

    <div id="code-section" style="{{ $step == 'step2' ? 'display: block;' : 'display: none;' }}">
        <p class="subtitle"><b>{{ session('verify_phone') }}</b> raqamiga yuborilgan kodni kiriting.</p>
        <form action="{{ route('student.verify.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" name="code" class="form-input" placeholder="000000" required
                       maxlength="6"
                       style="text-align: center; letter-spacing: 5px; font-size: 1.2rem; font-weight: bold;">
                @error('code')
                <span style="color: #f87171; font-size: 0.8rem; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn-action">Tasdiqlash</button>
        </form>
        <button type="button" onclick="resetVerification()"
                style="background: none; border: none; color: #94a3b8; margin-top: 15px; cursor: pointer; font-size: 0.8rem;">
            <i class="fas fa-edit"></i> Raqamni o‘zgartirish
        </button>
    </div>
</div>

<script>
    function resetVerification() {
        document.getElementById('phone-section').style.display = 'block';
        document.getElementById('code-section').style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function () {
        const phoneInput = document.getElementById('phone_number');
        phoneInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0 && !value.startsWith('998')) {
                value = '998' + value;
            }
            e.target.value = value.substring(0, 12);
        });
        phoneInput.addEventListener('blur', function (e) {
            if (e.target.value.length > 0 && e.target.value.length < 12) {
                Swal.fire({
                    icon: 'warning',
                    title: 'To‘liq emas',
                    text: 'Telefon raqam to‘liq kiritilmadi. 12 xonali bo‘lishi shart.',
                    background: '#1e293b',
                    color: '#fff'
                });
            }
        });
    });

    async function sendSmsCode() {
        const phone = document.getElementById('phone_number').value;
        const btn = document.getElementById('btn-send-sms');
        if (phone.length !== 12 || !phone.startsWith('998')) {
            return Swal.fire({
                icon: 'error',
                title: 'Noto‘g‘ri format!',
                text: 'Raqam 998 bilan boshlanishi va 12 ta raqamdan iborat bo‘lishi shart.',
                background: '#1e293b',
                color: '#fff'
            });
        }
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Yuborilmoqda...';
        try {
            const res = await fetch("{{ route('student.verify.send') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({phone: phone})
            });
            const data = await res.json();
            if (res.ok) {
                location.reload();
            } else {
                throw new Error(data.message || 'Xatolik yuz berdi');
            }
        } catch (e) {
            Swal.fire({icon: 'error', title: 'Xatolik', text: e.message});
            btn.disabled = false;
            btn.innerHTML = 'SMS Kod yuborish';
        }
    }
</script>

</body>
</html>
