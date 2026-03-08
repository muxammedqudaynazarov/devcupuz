<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>#M{{ sprintf('%04d', $problem->id) }} - {{ $problem->name }} | DevCup.UZ</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/theme/dracula.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/theme/eclipse.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/addon/edit/matchbrackets.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/clike/clike.min.js"></script> <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/python/python.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/php/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/ruby/ruby.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/rust/rust.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/go/go.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/sql/sql.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/swift/swift.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/shell/shell.min.js"></script>

    @auth
        <link rel="stylesheet" href="{{ asset('assets/themes/problems/'.auth()->user()->theme) }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/themes/problems/dark.css') }}">
    @endauth

    <style>
        /* CodeMirror'ni ekranga to'liq moslashish uchun CSS */
        .editor-container {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: var(--bg-dark);
        }
        .CodeMirror {
            flex-grow: 1;
            font-family: 'Fira Code', monospace;
            font-size: 15px;
            height: 100% !important;
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
            <div class="problem-stats-row">
                <span class="stat-badge stat-badge-muted">
                    <i class="fas fa-clock"></i> {{ $problem->runtime }}s
                </span>
                <span class="stat-badge stat-badge-muted">
                    <i class="fas fa-memory"></i> {{ $problem->memory }} MB
                </span>
                <span class="stat-badge stat-badge-primary">
                    <i class="fas fa-star"></i> {{ $problem->point }} ball
                </span>
            </div>

            <div class="desc-content">
                {!! $problem->desc !!}
                <hr class="neon-line">
                <h3 class="section-title">Kiruvchi ma’lumotlar</h3>
                {!! $problem->input_text !!}
                <hr class="neon-line">
                <h3 class="section-title">Chiquvchi ma’lumotlar</h3>
                {!! $problem->output_text !!}
            </div>

            @php
                $examples = json_decode($problem->example, true) ?? [];
                $totalTests = count($examples);
            @endphp

            @if($totalTests > 0)
                <h3 class="section-title">Misollar</h3>
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
                                <td class="example-index">{{ $i + 1 }}</td>
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
            <h4 class="panel-title">
                <i class="fas fa-history panel-icon"></i> Oxirgi urinishlar
            </h4>
            <div id="attempts-list">
                @forelse($attempts as $attempt)
                    <div class="attempt-card">
                        <div>
                            <div>
                                <span class="uuid-label">#{{ $attempt->uuid }}</span>
                                <span class="time-label">{{ $attempt->created_at->format('d.m.Y H:i:s') }}</span>
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
                    <div class="empty-state">
                        Siz hali bu masalaga kod yubormagansiz.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="right-panel">
        <div class="toolbar">
            <select class="language-select" id="language" onchange="changeLanguage()"
                    @if(now()>=$week->finished) disabled @endif>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}" data-mode="{{ $program->code }}">
                        {{ $program->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="editor-container">
            <textarea id="code-editor" @if(now()>=$week->finished) disabled @endif></textarea>
        </div>

        <div class="action-bar">
            <div id="save-status" class="save-status">
                <i class="fas fa-check-circle text-success"></i> Saqlangan
            </div>
            <button class="btn-submit" onclick="submitCode()">
                <i class="fas fa-paper-plane"></i> Yechimni yuborish
            </button>
        </div>
    </div>
</div>

<script>
    // CodeMirror Inicializatsiyasi
    var editor = CodeMirror.fromTextArea(document.getElementById("code-editor"), {
        lineNumbers: true,
        matchBrackets: true,
        indentUnit: 4,
        @if(auth()->check() && auth()->user()->theme == 'light.css')
        theme: "eclipse", // Light dizayn
        @else
        theme: "dracula", // Dark dizayn
        @endif
        readOnly: {{ now() >= $week->finished ? 'true' : 'false' }}
    });

    @if(now() <= $week->finished)
    const userId = '{{ auth()->id() }}';
    const GLOBAL_LANG_KEY = 'devcup_preferred_language_user_' + userId;
    const PROBLEM_CODE_KEY = 'problem_{{ $problem->id }}_code_user_' + userId;

    document.addEventListener('DOMContentLoaded', function () {
        const savedLang = localStorage.getItem(GLOBAL_LANG_KEY);
        const langSelect = document.getElementById('language');

        if (savedLang && Array.from(langSelect.options).some(opt => opt.value === savedLang)) {
            langSelect.value = savedLang;
        }
        updateEditorMode();

        const savedCode = localStorage.getItem(PROBLEM_CODE_KEY);
        if (savedCode) {
            editor.setValue(savedCode);
        } else {
            editor.setValue("");
        }
    });

    function changeLanguage() {
        localStorage.setItem(GLOBAL_LANG_KEY, document.getElementById('language').value);
        updateEditorMode();
    }

    // Seçilgan tilga qarab CodeMirror mode'ni o'zgartirish
    function updateEditorMode() {
        const select = document.getElementById("language");
        if (select.options.length > 0) {
            let mode = select.options[select.selectedIndex].getAttribute("data-mode");
            editor.setOption("mode", mode || "text/plain");
        }
    }

    let typingTimer;
    editor.on('change', function () {
        const statusEl = document.getElementById('save-status');
        statusEl.innerHTML = '<i class="fas fa-sync fa-spin text-muted-icon"></i> saving...';

        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            localStorage.setItem(PROBLEM_CODE_KEY, editor.getValue());
            statusEl.innerHTML = '<i class="fas fa-check-circle text-success"></i> save';
        }, 1000);
    });

    function copyToClipboard(elementId) {
        navigator.clipboard.writeText(document.getElementById(elementId).innerText);
    }

    async function submitCode() {
        const code = editor.getValue();
        const langSelect = document.getElementById('language');
        const submitBtn = document.querySelector('.btn-submit');
        const attemptsList = document.getElementById('attempts-list');

        if (!langSelect.value || langSelect.value == 0) return alert("Dasturlash tilini tanlang!");
        if (code.trim() === '') return alert('Iltimos, avval kod yozing!');

        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        if (!csrfMeta) return alert("Xavfsizlik kaliti (CSRF) topilmadi. Sahifani yangilang!");

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Running...';

        const tempId = 'temp-' + Date.now();
        const attemptHtml = `
            <div class="attempt-card" id="${tempId}">
                <div>
                    <div>
                        <span class="uuid-label">#Waiting</span>
                        <span class="time-label">Hozirgina</span>
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
                document.getElementById(`meta-${tempId}`).innerHTML = `<i class="fas fa-clock"></i> ${result.time}s | <i class="fas fa-memory"></i> ${result.memory}MB | `;

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

                // Yechim muvaffaqiyatli yuborilgandan so'ng maydonni tozalash
                editor.setValue("");
                localStorage.removeItem(PROBLEM_CODE_KEY);

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
    @endif
</script>
</body>
</html>
