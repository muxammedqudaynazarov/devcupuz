<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>#M{{ sprintf('%04d', $problem->id) }} - {{ $problem->name }} | DevCup.UZ</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.2/ace.js"></script>

    <style>
        :root {
            --bg-dark: #0f172a;
            --panel-bg: #1e293b;
            --primary-neon: #38bdf8;
            --accent-green: #4ade80;
            --danger-red: #f87171;
            --warning-yellow: #facc15;
            --border-color: rgba(255, 255, 255, 0.08);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-dark);
            color: #f1f5f9;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        /* Maxsus Navbar */
        .solve-navbar {
            height: 55px;
            background: rgba(15, 23, 42, 0.95);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }

        .back-link {
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
        }

        .back-link:hover {
            color: var(--primary-neon);
        }

        .problem-title {
            font-weight: 600;
            font-size: 1rem;
            color: #fff;
        }

        /* Asosiy ishchi maydon */
        .workspace {
            display: flex;
            flex-grow: 1;
            overflow: hidden;
            height: calc(100vh - 55px);
        }

        .left-panel {
            width: 60%;
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--border-color);
        }

        .right-panel {
            width: 40%;
            display: flex;
            flex-direction: column;
            background: var(--panel-bg);
        }

        @media (max-width: 1200px) {
            .left-panel {
                width: 55%;
            }

            .right-panel {
                width: 45%;
            }
        }

        /* Masala sharti qismi */
        .problem-info {
            flex-grow: 1;
            overflow-y: auto;
            padding: 25px;
            background: var(--bg-dark);
        }

        .desc-content {
            font-size: 0.95rem;
            line-height: 1.7;
            color: #cbd5e1;
        }

        .desc-content h1, .desc-content h2, .desc-content h3 {
            color: var(--primary-neon);
            margin: 15px 0 10px 0;
            font-size: 1.1rem;
        }

        hr.neon-line {
            border: none;
            height: 1px;
            background: var(--primary-neon);
            box-shadow: 0 0 10px var(--primary-neon);
            margin: 30px 0;
            opacity: 0.3;
        }

        /* MISOLLAR JADVALI */
        .examples-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-family: 'Fira Code', monospace;
        }

        .examples-table th {
            text-align: left;
            color: #64748b;
            padding: 12px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-weight: 500;
            font-size: 0.85rem;
        }

        .examples-table td {
            padding: 12px 15px;
            color: #e2e8f0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.02);
            font-size: 0.9rem;
        }

        .copy-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-copy {
            background: var(--primary-neon);
            color: var(--bg-dark);
            width: 26px;
            height: 26px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }

        .btn-copy:hover {
            transform: scale(1.05);
            box-shadow: 0 0 8px rgba(56, 189, 248, 0.5);
        }

        /* URINISHLAR PANELI VA BADGELAR */
        .attempts-panel {
            height: 280px;
            background: var(--bg-dark);
            border-top: 1px solid var(--border-color);
            overflow-y: auto;
            padding: 20px;
        }

        .attempt-card {
            background: var(--panel-bg);
            border: 1px solid rgba(255, 255, 255, 0.03);
            border-radius: 8px;
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .attempt-meta {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .badge {
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: transparent;
        }

        .badge-success {
            color: var(--accent-green);
            border: 1px solid var(--accent-green);
        }

        .badge-error {
            color: var(--danger-red);
            border: 1px solid var(--danger-red);
        }

        .badge-processing {
            color: var(--warning-yellow);
            border: 1px solid var(--warning-yellow);
        }

        /* EDITOR QISMI */
        .toolbar {
            height: 45px;
            background: var(--bg-dark);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            padding: 0 15px;
        }

        .language-select {
            background: var(--panel-bg);
            color: #fff;
            border: 1px solid #4a5568;
            padding: 5px 10px;
            border-radius: 5px;
            outline: none;
            cursor: pointer;
            font-size: 0.85rem;
        }

        #editor {
            flex-grow: 1;
            font-family: 'Fira Code', monospace;
            font-size: 15px;
        }

        .action-bar {
            padding: 10px 15px;
            background: var(--bg-dark);
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-submit {
            background: var(--primary-neon);
            color: var(--bg-dark);
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(56, 189, 248, 0.4);
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        .fa-spin {
            animation: spin 0.8s linear infinite;
        }
    </style>
</head>
<body>

<nav class="solve-navbar">
    <a href="{{ route('problems.index') }}" class="back-link"><i class="fas fa-arrow-left"></i> Turnirga qaytish</a>
    <div class="problem-title">#M{{ sprintf('%04d', $problem->id) }}: {{ $problem->name }}</div>
    <div style="width: 130px"></div>
</nav>

<div class="workspace">
    <div class="left-panel">
        <div class="problem-info">
            <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                <span
                    style="font-size: 0.75rem; padding: 4px 10px; background: rgba(255,255,255,0.05); border-radius: 6px; color: #94a3b8;"><i
                        class="fas fa-clock"></i> {{ $problem->runtime }}s</span>
                <span
                    style="font-size: 0.75rem; padding: 4px 10px; background: rgba(255,255,255,0.05); border-radius: 6px; color: #94a3b8;"><i
                        class="fas fa-memory"></i> {{ $problem->memory }} MB</span>
                <span
                    style="font-size: 0.75rem; padding: 4px 10px; background: rgba(255,255,255,0.05); border-radius: 6px; color: #38bdf8;"><i
                        class="fas fa-star"></i> {{ $problem->point }} ball</span>
            </div>

            <div class="desc-content">
                {!! $problem->desc !!}
                <hr class="neon-line">
                <h3>Kiruvchi ma’lumotlar</h3>
                {!! $problem->input_text !!}
                <hr class="neon-line">
                <h3>Chiquvchi ma’lumotlar</h3>
                {!! $problem->output_text !!}
            </div>

            @php
                $examples = json_decode($problem->example, true) ?? [];
                $totalTests = count($examples);
            @endphp

            @if($totalTests > 0)
                <h3 style="color: #38bdf8; margin-top: 35px; margin-bottom: 5px;">Misollar</h3>
                <table class="examples-table">
                    <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">#</th>
                        <th style="width: 45%;">input.txt</th>
                        <th style="width: 45%;">output.txt</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($examples as $i => $ex)
                        @if($i < 2)
                            <tr>
                                <td style="text-align: center; color: #f1f5f9;">{{ $i + 1 }}</td>
                                <td>
                                    <pre class="copy-container">
                                        <span id="in-{{$i}}">{{ str_replace('\r\n', '<br>', $ex['input']) }}</span>
                                        <button class="btn-copy" onclick="copyToClipboard('in-{{$i}}')"><i
                                                class="far fa-copy"></i></button>
                                    </pre>
                                </td>
                                <td>
                                    <div class="copy-container">
                                        <span id="out-{{$i}}">{{ $ex['output'] }}</span>
                                        <button class="btn-copy" onclick="copyToClipboard('out-{{$i}}')"><i
                                                class="far fa-copy"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="attempts-panel">
            <h4 style="color: #f1f5f9; margin-bottom: 15px; font-size: 1rem;">
                <i class="fas fa-history" style="color: #94a3b8; margin-right: 5px;"></i> Oxirgi urinishlar
            </h4>
            <div id="attempts-list">
                @forelse($attempts as $attempt)
                    <div class="attempt-card">
                        <div>
                            <div>
                                <span
                                    style="color: #e2e8f0; font-weight: 600; font-family: 'Fira Code', monospace;">#{{ $attempt->uuid }}</span>
                                <span
                                    style="color: #64748b; font-size: 0.85rem; margin-left: 10px;">{{ $attempt->created_at->format('d.m.Y H:i:s') }}</span>
                            </div>
                            <div class="attempt-meta">
                                <i class="fas fa-clock"></i> {{ $attempt->time }}s |
                                <i class="fas fa-memory"></i> {{ $attempt->memory }}MB
                            </div>
                        </div>

                        @if($attempt->status == '2')
                            <span class="badge badge-success"><i class="fas fa-check"></i> Accepted</span>
                        @elseif($attempt->status == '3')
                            <span class="badge badge-error"><i class="fas fa-times"></i> {{ $attempt->message }}</span>
                        @elseif($attempt->status == '4')
                            <span class="badge badge-error"><i
                                    class="fas fa-exclamation-triangle"></i> System error</span>
                        @else
                            <span class="badge badge-processing"><i
                                    class="fas fa-spinner fa-spin"></i> Compiling...</span>
                        @endif
                    </div>
                @empty
                    <div style="text-align: center; color: #64748b; padding: 20px 0;">
                        Siz hali bu masalaga kod yubormagansiz.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="right-panel">
        <div class="toolbar">
            <select class="language-select" id="language" onchange="changeLanguage()">
                @foreach($programs as $program)
                    <option value="{{ $program->id }}"
                            data-mode="{{ strtolower($program->name) }}">{{ $program->name }}</option>
                @endforeach
            </select>
        </div>

        <div id="editor"></div>

        <div class="action-bar">
            <div id="save-status" style="font-size: 0.75rem; color: #64748b;">
                <i class="fas fa-check-circle" style="color: #4ade80"></i> Saqlangan
            </div>
            <button class="btn-submit" onclick="submitCode()">
                <i class="fas fa-paper-plane"></i> Yechimni yuborish
            </button>
        </div>
    </div>
</div>

<script>
    // 1. Editorni sozlash
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/tomorrow_night_eighties");
    editor.setOptions({fontSize: "15px", showPrintMargin: false, enableBasicAutocompletion: true});

    // MUHIM O'ZGARISH: user_id orqali har bir foydalanuvchini ajratish
    const userId = '{{ auth()->id() }}';
    const GLOBAL_LANG_KEY = 'devcup_preferred_language_user_' + userId;
    const PROBLEM_CODE_KEY = 'problem_{{ $problem->id }}_code_user_' + userId;
    const totalTests = {{ $totalTests }};

    // 2. LocalStorage'dan faqat shu user uchun yozilgan kodni o'qish
    document.addEventListener('DOMContentLoaded', function () {
        const savedLang = localStorage.getItem(GLOBAL_LANG_KEY);
        const langSelect = document.getElementById('language');

        if (savedLang && Array.from(langSelect.options).some(opt => opt.value === savedLang)) {
            langSelect.value = savedLang;
        }
        updateEditorMode();

        const savedCode = localStorage.getItem(PROBLEM_CODE_KEY);
        if (savedCode) {
            editor.setValue(savedCode, -1);
        } else {
            editor.setValue("// Yechimingizni shu yerga yozing...\n", -1);
        }
    });

    // 3. Til almashish mantiqi (user_id bilan saqlash)
    function changeLanguage() {
        localStorage.setItem(GLOBAL_LANG_KEY, document.getElementById('language').value);
        updateEditorMode();
    }

    function updateEditorMode() {
        const select = document.getElementById("language");
        if (select.options.length > 0) {
            let mode = select.options[select.selectedIndex].getAttribute("data-mode");
            if (mode === 'c++') mode = 'c_cpp';
            editor.session.setMode("ace/mode/" + mode);
        }
    }

    // 4. Avto-saqlash (Auto-save) individual user uchun
    let typingTimer;
    editor.session.on('change', function () {
        const statusEl = document.getElementById('save-status');
        statusEl.innerHTML = '<i class="fas fa-sync fa-spin"></i> saving...';
        statusEl.style.color = '#94a3b8';

        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            localStorage.setItem(PROBLEM_CODE_KEY, editor.getValue());
            statusEl.innerHTML = '<i class="fas fa-check-circle" style="color: #4ade80"></i> save';
        }, 1000);
    });

    // Nusxa olish
    function copyToClipboard(elementId) {
        navigator.clipboard.writeText(document.getElementById(elementId).innerText);
    }

    // 5. Kodni Jo'natish (AJAX)
    async function submitCode() {
        const code = editor.getValue();
        const langSelect = document.getElementById('language');
        const submitBtn = document.querySelector('.btn-submit');
        const attemptsList = document.getElementById('attempts-list');

        if (!langSelect.value || langSelect.value == 0) return alert("Dasturlash tilini tanlang!");
        if (code.trim() === '' || code.trim() === '// Yechimingizni shu yerga yozing...') return alert('Iltimos, avval kod yozing!');

        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        if (!csrfMeta) return alert("Xavfsizlik kaliti (CSRF) topilmadi. Sahifani yangilang!");

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Running...';

        const tempId = 'temp-' + Date.now();
        const attemptHtml = `
            <div class="attempt-card" id="${tempId}">
                <div>
                    <div>
                        <span class="uuid-label" style="color: #e2e8f0; font-weight: 600; font-family: 'Fira Code', monospace;">#Waiting</span>
                        <span style="color: #64748b; font-size: 0.85rem; margin-left: 10px;">Hozirgina</span>
                    </div>
                    <div class="attempt-meta" id="meta-${tempId}">
                        <i class="fas fa-clock"></i> 0s | <i class="fas fa-memory"></i> 0MB
                    </div>
                </div>
                <span class="badge badge-processing" id="status-${tempId}"><i class="fas fa-spinner fa-spin"></i> Compiling...</span>
            </div>`;

        if (attemptsList.innerHTML.includes('Siz hali bu masalaga')) attemptsList.innerHTML = '';
        attemptsList.insertAdjacentHTML('afterbegin', attemptHtml);

        try {
            const response = await fetch("{{ route('problems.check_code') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfMeta.getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    problem_id: {{ $problem->id }},
                    program_id: parseInt(langSelect.value),
                    code: code
                })
            });

            const result = await response.json();
            const statusEl = document.getElementById(`status-${tempId}`);

            if (response.ok && result.status !== '4') {
                document.getElementById(`meta-${tempId}`).innerHTML = `<i class="fas fa-clock"></i> ${result.time}s | <i class="fas fa-memory"></i> ${result.memory}MB`;

                // UUID joyini aniq topib almashtiramiz
                const uuidSpan = document.getElementById(tempId).querySelector('.uuid-label');
                if (uuidSpan) {
                    uuidSpan.innerText = '#' + result.uuid;
                }

                if (result.status === '2') {
                    statusEl.className = 'badge badge-success';
                    statusEl.innerHTML = '<i class="fas fa-check"></i> Accepted';
                } else if (result.status === '3') {
                    statusEl.className = 'badge badge-error';
                    statusEl.innerHTML = `<i class="fas fa-times"></i> ${result.message}`;
                } else {
                    statusEl.className = 'badge badge-processing';
                    statusEl.innerHTML = `<i class="fas fa-spinner fa-spin"></i> ${result.message}`;
                }
            } else {
                statusEl.className = 'badge badge-error';
                statusEl.innerHTML = `<i class="fas fa-wifi"></i> ${result.message || 'Server error'}`;
            }
        } catch (error) {
            document.getElementById(`status-${tempId}`).className = 'badge badge-error';
            document.getElementById(`status-${tempId}`).innerHTML = '<i class="fas fa-exclamation-triangle"></i> System error';
        }

        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Yechimni yuborish';
    }
</script>
</body>
</html>
