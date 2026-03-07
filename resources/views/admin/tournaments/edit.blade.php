@extends('layouts.admin')

@section('style')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .ql-editor.ql-blank::before {
            color: #64748b;
            font-style: normal;
        }

        /* 8-4 nisbatda joylashtirish uchun maxsus grid */
        .inner-row-grid {
            display: grid;
            grid-template-columns: 8fr 4fr;
            gap: 25px;
        }

        select.search-input {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 15px;
            padding-right: 40px;
        }

        /* --- Custom Modal Styles --- */
        .custom-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(8px);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .custom-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .custom-modal {
            background: var(--card-bg);
            border: 1px solid rgba(248, 113, 113, 0.3); /* Xavf rangi */
            border-radius: 16px;
            padding: 30px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            transform: translateY(-20px) scale(0.95);
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .custom-modal-overlay.active .custom-modal {
            transform: translateY(0) scale(1);
        }

        .modal-icon {
            font-size: 3rem;
            color: var(--danger-red);
            margin-bottom: 15px;
            text-shadow: 0 0 15px rgba(248, 113, 113, 0.4);
        }

        .modal-title {
            color: #fff;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .modal-text {
            color: #cbd5e1;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 25px;
        }

        .modal-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .btn-cancel {
            background: rgba(100, 116, 139, 0.2);
            color: #e2e8f0;
            border: 1px solid rgba(100, 116, 139, 0.3);
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: 0.2s;
        }

        .btn-cancel:hover {
            background: rgba(100, 116, 139, 0.4);
        }

        .btn-confirm {
            background: rgba(248, 113, 113, 0.1);
            color: var(--danger-red);
            border: 1px solid var(--danger-red);
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.2s;
        }

        .btn-confirm:hover {
            background: var(--danger-red);
            color: #fff;
            box-shadow: 0 0 15px rgba(248, 113, 113, 0.4);
        }

        @media (max-width: 768px) {
            .inner-row-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div class="custom-modal-overlay" id="statusModal">
        <div class="custom-modal">
            <div class="modal-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="modal-title">Diqqat, etibor bering!</h3>
            <p class="modal-text">Siz turnirni <b id="modalStatusName" style="color: var(--danger-red);"></b> holatiga
                o‘tkazmoqchisiz.<br>Shu holatga o‘tkazilgandan so‘ng, o‘zgartirish oynasini qayta ochib bo‘lmaydi.
                Davom etasizmi?</p>
            <div class="modal-actions">
                <button class="btn-cancel" onclick="closeModal()" type="button">Bekor qilish</button>
                <button class="btn-confirm" onclick="submitForm()" type="button">Ha, saqlash</button>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="page-header">
            <div class="header-info">
                <h1>🏆 Turnirni tahrirlash</h1>
                <p>Musobaqa ma’lumotlarini yangilang</p>
            </div>
            <a href="{{ route('tournaments.index') }}" class="btn-logout" style="text-decoration: none;">
                <i class="fas fa-arrow-left"></i> Bekor qilish
            </a>
        </div>
        <div class="table-container" style="padding: 30px;">
            <form action="{{ route('tournaments.update', $tournament->id) }}" method="POST" id="tournament-form">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="inner-row-grid full-width">
                        <div class="form-group">
                            <label for="name">Turnir nomi</label>
                            <input type="text" name="name" id="name" class="search-input" style="width: 100%;"
                                   placeholder="Masalan: DevCup Spring 2026"
                                   value="{{ old('name', $tournament->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="status">Turnir holati</label>
                            <select name="status" id="status" class="search-input"
                                    style="width: 100%; cursor: pointer;">
                                <option value="0" {{ old('status', $tournament->status) == '0' ? 'selected' : '' }}>
                                    Nofaol
                                </option>
                                <option value="1" {{ old('status', $tournament->status) == '1' ? 'selected' : '' }}>
                                    Faol
                                </option>
                                <option value="3" {{ old('status', $tournament->status) == '3' ? 'selected' : '' }}>
                                    Yakunlangan
                                </option>
                                <option value="4" {{ old('status', $tournament->status) == '4' ? 'selected' : '' }}>
                                    Qoldirilgan
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="time-row-grid full-width">
                        <div class="form-group">
                            <label for="started">Boshlanish vaqti</label>
                            <input type="datetime-local" name="started" id="started" class="search-input"
                                   style="width: 100%;"
                                   value="{{ old('started', $tournament->started->format('Y-m-d\TH:i')) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="finished">Yakunlanish vaqti</label>
                            <input type="datetime-local" name="finished" id="finished" class="search-input"
                                   style="width: 100%;"
                                   value="{{ old('finished', $tournament->finished->format('Y-m-d\TH:i')) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="deadline">Ariza qabul qilish muddati</label>
                            <input type="datetime-local" name="deadline" id="deadline" class="search-input"
                                   style="width: 100%;"
                                   value="{{ old('deadline', $tournament->deadline->format('Y-m-d\TH:i')) }}" required>
                        </div>
                    </div>

                    <div class="form-group full-width quill-editor-box">
                        <label for="desc">Turnir tasnifi</label>
                        <input type="hidden" name="desc" id="desc" value="{{ old('desc', $tournament->desc) }}">
                        <div id="editor-container" style="height: 250px;">{!! old('desc', $tournament->desc) !!}</div>
                    </div>
                </div>

                <div class="form-actions"
                     style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 20px;">
                    <button type="button" class="btn-create" onclick="checkStatusBeforeSubmit()">
                        <i class="fas fa-save"></i> O‘zgarishlarni saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            placeholder: 'Turnir haqidagi to‘liq ma’lumotni va qoidalarni kiriting...',
            modules: {
                toolbar: [
                    [{'header': [1, 2, 3, false]}],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{'list': 'ordered'}, {'list': 'bullet'}],
                    [{'color': []}, {'background': []}],
                    ['link', 'blockquote', 'code-block'],
                ]
            }
        });

        const form = document.getElementById('tournament-form');
        const modal = document.getElementById('statusModal');
        const statusSelect = document.getElementById('status');
        const modalStatusName = document.getElementById('modalStatusName');

        function prepareQuillData() {
            var descInput = document.getElementById('desc');
            if (quill.getText().trim().length === 0) {
                descInput.value = '';
            } else {
                descInput.value = quill.root.innerHTML;
            }
        }

        function checkStatusBeforeSubmit() {
            const currentStatus = statusSelect.value;
            if (currentStatus === '3' || currentStatus === '4') {
                const statusName = currentStatus === '3' ? '"Yakunlangan"' : '"Qoldirilgan"';
                modalStatusName.textContent = statusName;
                modal.classList.add('active');
            } else {
                submitForm();
            }
        }

        function closeModal() {
            modal.classList.remove('active');
        }

        function submitForm() {
            prepareQuillData();
            form.submit();
        }

        document.getElementById('started').addEventListener('change', function () {
            let started = new Date(this.value);
            if (!isNaN(started.getTime())) {
                let finished = new Date(started.getTime() + (3 * 60 * 60 * 1000));
                let formatted = finished.getFullYear() + '-' +
                    String(finished.getMonth() + 1).padStart(2, '0') + '-' +
                    String(finished.getDate()).padStart(2, '0') + 'T' +
                    String(finished.getHours()).padStart(2, '0') + ':' +
                    String(finished.getMinutes()).padStart(2, '0');

                document.getElementById('finished').value = formatted;
            }
        });
    </script>
@endsection
