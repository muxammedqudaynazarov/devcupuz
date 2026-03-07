@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <div class="header-info">
                <h1>Yangi bosqich qo‘shish</h1>
                <p>Turnir: <span style="color: var(--primary-neon);">{{ $tournament->name }}</span></p>
            </div>
            <a href="{{ route('weeks.show', $tournament->id) }}" class="btn-logout" style="text-decoration: none;">
                <i class="fas fa-arrow-left"></i> Bekor qilish
            </a>
        </div>

        <div class="table-container" style="padding: 30px;">
            <form action="{{ route('weeks.update', $tournament->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-grid">
                    <div class="inner-row-grid full-width">
                        <div class="form-group">
                            <label for="week_number">Bosqich raqami №</label>
                            <input type="number" name="week_number" id="week_number" class="search-input"
                                   style="width: 100%;"
                                   value="{{ old('week_number', $nextWeekNumber) }}" required min="1">
                        </div>

                        <div class="form-group">
                            <label for="name">Tur nomi</label>
                            <input type="text" name="name" id="name" class="search-input" style="width: 100%;"
                                   placeholder="Masalan: 1-hafta (Kirish va asoslar)" value="{{ old('name') }}"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="status">Tur holati</label>
                            <select name="status" id="status" class="search-input"
                                    style="width: 100%; cursor: pointer;">
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Faol (ochiq)</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Nofaol (yopiq)</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;" class="full-width">
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
                    </div>
                </div>

                <div class="form-actions"
                     style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 20px; text-align: right">
                    <button type="submit" class="btn-create">
                        <i class="fas fa-check"></i> O‘zgarishlarni saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
