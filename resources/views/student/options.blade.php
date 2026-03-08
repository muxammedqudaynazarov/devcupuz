@extends('layouts.app')
@section('page_title', '⚙️ Tizim sozlamalari')
@section('page_title_desc', 'Shaxsiy parametrlaringizni o‘zingizga moslashtiring')
@section('content')
    <div class="content-wrapper">
        <div class="card-panel" style="max-width: 600px;">
            <form action="{{ route('options.store') }}" method="POST">
                @csrf
                <div class="form-grid">

                    <div class="form-group">
                        <label for="per_page">Sahifadagi elementlar soni (10-100)</label>
                        <input type="number" name="per_page" id="per_page" class="search-input"
                               style="width: 100%;" min="10" max="100"
                               value="{{ old('per_page', $user->per_page ?? 15) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="theme">Tizim dizayni (Mavzu)</label>
                        <select name="theme" id="theme" class="search-input" style="width: 100%;" required>
                            <option value="light.css" {{ old('theme', $user->theme) == 'light.css' ? 'selected' : '' }}>
                                Light Neon (Yorqin fonda)
                            </option>
                            <option value="dark.css" {{ old('theme', $user->theme) == 'dark.css' ? 'selected' : '' }}>
                                Dark Mode (Qorong‘u fon)
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="language">Tizim tili</label>
                        <select name="language" id="language" class="search-input" style="width: 100%;" required>
                            <option value="uz" {{ old('language', $user->language) == 'uz' ? 'selected' : '' }}>
                                O‘zbekcha
                            </option>
                            <option value="ru" {{ old('language', $user->language) == 'ru' ? 'selected' : '' }}>
                                Русский
                            </option>
                            <option value="kaa" {{ old('language', $user->language) == 'kaa' ? 'selected' : '' }}>
                                Qaraqalpaqsha
                            </option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-top: 15px;">
                        <button type="submit" class="btn-create" style="width: 100%;">
                            <i class="fas fa-save"></i> Sozlamalarni saqlash
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
