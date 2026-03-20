@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="page-header" style="margin-bottom: 25px;">
            <div class="header-info">
                <h1>{{ isset($prize) ? 'Sovrinni tahrirlash' : 'Yangi sovrin qo‘shish' }}</h1>
                <p>Sovrin nomi, rasmi va malumotlarini kiritish</p>
            </div>
        </div>

        <div class="table-container" style="padding: 30px;">
            <form action="{{ isset($prize) ? route('prizes.update', $prize->id) : route('prizes.store') }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($prize))
                    @method('PUT')
                @endif
                <div class="form-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 25px;">
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Sovrin nomi</label>
                        <input type="text" name="title" class="search-input" style="width: 100%;"
                               value="{{ old('title', $prize->title ?? '') }}" placeholder="Masalan: MacBook Pro M3"
                               required>
                    </div>
                    <div class="form-group">
                        <label>Tavsif (O‘zbek tilida)</label>
                        <textarea name="desc[uz]" class="search-input"
                                  style="width: 100%; min-height: 120px; resize: vertical;"
                                  required>{{ old('desc.uz', isset($prize) ? $prize->getTranslation('desc', 'uz', false) : '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Tavsif (Qoraqalpoq tilida)</label>
                        <textarea name="desc[kaa]" class="search-input"
                                  style="width: 100%; min-height: 120px; resize: vertical;"
                                  required>{{ old('desc.kaa', isset($prize) ? $prize->getTranslation('desc', 'kaa', false) : '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Tavsif (Rus tilida)</label>
                        <textarea name="desc[ru]" class="search-input"
                                  style="width: 100%; min-height: 120px; resize: vertical;"
                                  required>{{ old('desc.ru', isset($prize) ? $prize->getTranslation('desc', 'ru', false) : '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Banner (rasm yuklash)</label>
                        <input type="file" name="image" class="search-input" style="width: 100%; padding: 10px;"
                               accept="image/*" {{ isset($prize) ? '' : 'required' }}>

                        @if(isset($prize) && $prize->image)
                            <div style="margin-top: 15px;">
                                <small style="color: var(--text-muted); display: block; margin-bottom: 5px;">
                                    Joriy rasm:
                                </small>
                                <img src="{{ asset('storage/' . $prize->image) }}" alt="Joriy rasm"
                                     style="height: 80px; border-radius: 8px; border: 1px solid var(--border-light);">
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Sovrin holati</label>
                        <select name="actual" class="search-input" style="width: 100%; cursor: pointer;">
                            <option
                                value="1" {{ isset($prize) && $prize->actual == '1' ? 'selected' : (isset($prize) && $prize->actual == '0' ? '' : 'selected') }}>
                                Dolzarb (Joriy turnir uchun)
                            </option>
                            <option value="0" {{ isset($prize) && $prize->actual == '0' ? 'selected' : '' }}>
                                Arxivlangan (Eski sovrin)
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-actions"
                     style="margin-top: 35px; text-align: right; border-top: 1px solid var(--border-light); padding-top: 20px;">
                    <button type="submit" class="btn-create">
                        <i class="fas fa-save"></i> {{ isset($prize) ? 'O‘zgarishlarni saqlash' : 'Sovrinni qo‘shish' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
