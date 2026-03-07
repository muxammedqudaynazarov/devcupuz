@extends('layouts.admin')

@section('style')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <div class="header-info">
                <h1>📝 Yangi masala yaratish</h1>
                <p>Algoritmik masala shartlari va texnik cheklovlarini belgilang</p>
            </div>
            <a href="{{ route('admin.problems.index') }}" class="btn-logout" style="text-decoration: none;">
                <i class="fas fa-arrow-left"></i> Bekor qilish
            </a>
        </div>

        <div class="table-container" style="padding: 30px;">
            <form action="{{ route('admin.problems.store') }}" method="POST" id="problem-form">
                @csrf
                <div class="form-grid">

                    <div class="form-group full-width">
                        <label for="name">Masala nomi</label>
                        <input type="text" name="name" id="name" class="search-input" style="width: 100%;"
                               placeholder="Masalan: Ikki sonning yig'indisi" value="{{ old('name') }}" required>
                    </div>

                    <div class="form-group full-width">
                        <label for="week_id">Tegishli turnir va bosqich</label>
                        <select name="week_id" id="week_id" class="search-input"
                                style="width: 100%; cursor: pointer;" required>
                            <option value="" disabled selected>Turnir va haftani tanlang...</option>
                            @foreach($tournaments as $tournament)
                                <optgroup label="🏆 {{ $tournament->name }}">
                                    @foreach($tournament->weeks as $week)
                                        <option value="{{ $week->id }}" {{ old('week_id') == $week->id ? 'selected' : '' }}>
                                            {{ $week->week_number }}-bosqich: {{ $week->name }}
                                            ({{ $week->problems_count }} masala)
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <div class="inner-row-grid full-width">
                        <div class="form-group">
                            <label for="memory">Xotira cheklovi (MB)</label>
                            <input type="number" name="memory" id="memory" class="search-input" style="width: 100%;"
                                   placeholder="Masalan: 16" value="{{ old('memory', 64) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="runtime">Vaqt cheklovi (sek)</label>
                            <input type="number" name="runtime" id="runtime" class="search-input" style="width: 100%;"
                                   placeholder="Masalan: 1" value="{{ old('runtime', 1) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="point">Ball</label>
                            <input type="number" name="point" id="point" class="search-input" style="width: 100%;"
                                   placeholder="Masalan: 10" value="{{ old('point', 10) }}" required>
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label>Masala matni (to‘liq sharti)</label>
                        <input type="hidden" name="desc" id="desc" value="{{ old('desc') }}">
                        <div id="desc-editor" style="height: 250px;">{!! old('desc') !!}</div>
                    </div>

                    <div class="text-area-grid full-width">
                        <div class="form-group">
                            <label>Kiruvchi ma’lumotlar tafsiloti (Input details)</label>
                            <input type="hidden" name="input_text" id="input_text" value="{{ old('input_text') }}">
                            <div id="input-editor" style="height: 150px;">{!! old('input_text') !!}</div>
                        </div>
                        <div class="form-group">
                            <label>Chiquvchi ma’lumotlar tafsiloti (Output details)</label>
                            <input type="hidden" name="output_text" id="output_text" value="{{ old('output_text') }}">
                            <div id="output-editor" style="height: 150px;">{!! old('output_text') !!}</div>
                        </div>
                    </div>

                    <div class="form-group full-width" style="margin-top: 20px;">
                        <label style="font-size: 1.1rem; color: var(--primary-neon);">Misollar (Rasmdagi kabi)</label>

                        <table class="example-table">
                            <thead>
                            <tr>
                                <th style="width: 50px; text-align: center;">#</th>
                                <th style="width: 45%;">input.txt</th>
                                <th style="width: 45%;">output.txt</th>
                                <th style="width: 60px; text-align: center;"><i class="fas fa-cog"></i></th>
                            </tr>
                            </thead>
                            <tbody id="example-tbody">
                            <tr>
                                <td class="row-number" style="text-align: center; font-weight: bold; color: #94a3b8; padding-top: 25px;">1</td>
                                <td>
                                    <textarea name="test_input[]" class="example-textarea" placeholder="Masalan: 2 3" required></textarea>
                                </td>
                                <td>
                                    <textarea name="test_output[]" class="example-textarea" placeholder="Masalan: 5" required></textarea>
                                </td>
                                <td style="text-align: center; padding-top: 22px;">
                                    <button type="button" class="btn-action-danger" onclick="removeRow(this)" title="O'chirish">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <button type="button" class="btn-create" style="margin-top: 15px; background: rgba(56, 189, 248, 0.1); border: 1px dashed var(--primary-neon); color: var(--primary-neon);" onclick="addRow()">
                            <i class="fas fa-plus"></i> Yana namuna qo'shish
                        </button>
                    </div>

                </div>

                <div class="form-actions"
                     style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 20px; text-align: right;">
                    <button type="submit" class="btn-create">
                        <i class="fas fa-save"></i> Masalani saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        // 1. Quill.js sozlamalari
        var toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],
            [{'list': 'ordered'}, {'list': 'bullet'}],
            [{'color': []}, {'background': []}],
            ['link', 'code-block', 'blockquote'],
            ['clean']
        ];

        var descQuill = new Quill('#desc-editor', {theme: 'snow', modules: {toolbar: toolbarOptions}});
        var inputQuill = new Quill('#input-editor', {theme: 'snow', modules: {toolbar: toolbarOptions}});
        var outputQuill = new Quill('#output-editor', {theme: 'snow', modules: {toolbar: toolbarOptions}});

        // Forma yuborilganda editor malumotlarini inputga olish
        var form = document.getElementById('problem-form');
        form.onsubmit = function () {
            document.getElementById('desc').value = descQuill.root.innerHTML;
            document.getElementById('input_text').value = inputQuill.root.innerHTML;
            document.getElementById('output_text').value = outputQuill.root.innerHTML;
        };

        // 2. Dinamik jadval qatorlarini boshqarish
        function addRow() {
            let tbody = document.getElementById('example-tbody');
            let rowCount = tbody.rows.length + 1;

            let row = `<tr>
                <td class="row-number" style="text-align: center; font-weight: bold; color: #94a3b8; padding-top: 25px;">${rowCount}</td>
                <td><textarea name="test_input[]" class="example-textarea" placeholder="Kiruvchi ma'lumot..." required></textarea></td>
                <td><textarea name="test_output[]" class="example-textarea" placeholder="Kutilayotgan natija..." required></textarea></td>
                <td style="text-align: center; padding-top: 22px;">
                    <button type="button" class="btn-action-danger" onclick="removeRow(this)" title="O'chirish">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>`;

            tbody.insertAdjacentHTML('beforeend', row);
            updateRowNumbers();
        }

        function removeRow(btn) {
            let tbody = document.getElementById('example-tbody');
            if(tbody.rows.length > 1) {
                btn.closest('tr').remove();
                updateRowNumbers();
            } else {
                alert("Kamida 1 ta namuna kiritilishi shart!");
            }
        }

        function updateRowNumbers() {
            let rows = document.querySelectorAll('#example-tbody tr');
            rows.forEach((row, index) => {
                row.querySelector('.row-number').innerText = index + 1;
            });
        }
    </script>
@endsection
