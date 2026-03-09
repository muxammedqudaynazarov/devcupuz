@extends('layouts.admin')

@section('style')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <div class="header-info">
                <h1>FAQ ni tahrirlash</h1>
            </div>
            <a href="{{ route('admin.faqs.index') }}" class="btn-logout" style="text-decoration: none;">
                <i class="fas fa-arrow-left"></i> Bekor qilish
            </a>
        </div>

        <div class="table-container" style="padding: 30px;">
            <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST" id="faq-form">
                @csrf
                @method('PUT')
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="question_uz">Savol matni</label>
                        <input type="text" name="question[uz]" id="question_uz" class="search-input"
                               style="width: 100%;"
                               value="{{ old('question.uz', $faq->getTranslation('question', 'uz', false)) }}" required>
                    </div>

                    <div class="form-group full-width" style="margin-top: 20px;">
                        <label>Javob matni</label>
                        <input type="hidden" name="answer[uz]" id="answer_uz"
                               value="{{ old('answer.uz', $faq->getTranslation('answer', 'uz', false)) }}">
                        <div id="answer-editor"
                             style="height: 250px; background: rgba(255,255,255,0.02); color: var(--text-main);">{!! old('answer.uz', $faq->getTranslation('answer', 'uz', false)) !!}</div>
                    </div>
                </div>

                <div class="form-actions"
                     style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 20px; text-align: right;">
                    <button type="submit" class="btn-create">
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
        var toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],
            [{'list': 'ordered'}, {'list': 'bullet'}],
            [{'color': []}, {'background': []}],
            ['link', 'clean']
        ];

        var answerQuill = new Quill('#answer-editor', {
            theme: 'snow',
            modules: {toolbar: toolbarOptions}
        });

        document.getElementById('faq-form').onsubmit = function () {
            document.getElementById('answer_uz').value = answerQuill.root.innerHTML;
        };
    </script>
@endsection
