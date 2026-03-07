@extends('layouts.admin')

@section('style')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <div class="header-info">
                <h1>🏆 Yangi turnir yaratish</h1>
                <p>Musobaqa ma’lumotlarini kiriting va muddatlarni belgilang</p>
            </div>
        </div>
        <div class="table-container" style="padding: 30px;">
            <form action="{{ route('tournaments.store') }}" method="POST" id="tournament-form">
                @csrf
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="name">Turnir nomi</label>
                        <input type="text" name="name" id="name" class="search-input" style="width: 100%;"
                               placeholder="Masalan: DevCup Spring 2026" value="{{ old('name') }}" required>
                    </div>

                    <div class="time-row-grid full-width">
                        <div class="form-group">
                            <label for="started">Boshlanish vaqti</label>
                            <input type="datetime-local" name="started" id="started" class="search-input"
                                   style="width: 100%;" value="{{ old('started') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="finished">Yakunlanish vaqti</label>
                            <input type="datetime-local" name="finished" id="finished" class="search-input"
                                   style="width: 100%;" value="{{ old('finished') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="deadline">Ariza qabul qilish muddati</label>
                            <input type="datetime-local" name="deadline" id="deadline" class="search-input"
                                   style="width: 100%;" value="{{ old('deadline') }}" required>
                        </div>
                    </div>

                    <div class="form-group full-width quill-editor-box">
                        <label for="desc">Turnir tasnifi</label>
                        <input type="hidden" name="desc" id="desc" value="{{ old('desc') }}">

                        <div id="editor-container" style="height: 250px;">{!! old('desc') !!}</div>
                    </div>
                </div>

                <div class="form-actions"
                     style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 20px;">
                    <button type="submit" class="btn-create">
                        <i class="fas fa-check"></i> Turnirni yaratish
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

        var form = document.getElementById('tournament-form');
        form.onsubmit = function () {
            var descInput = document.getElementById('desc');
            // Muharrir ichida matn yo'q bo'lsa (faqat bo'sh teglar bo'lsa) qiymatni bo'shatish
            if (quill.getText().trim().length === 0) {
                descInput.value = '';
            } else {
                descInput.value = quill.root.innerHTML;
            }
        };
    </script>
@endsection
