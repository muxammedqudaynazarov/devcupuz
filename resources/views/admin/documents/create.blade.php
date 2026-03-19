@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <div class="header-info">
                <h1>📄 Yangi ilova qo‘shish</h1>
                <p>Tizimni ishlashiga va turnirlar o‘tkazilishiga asos bo‘luvchi PDF formatidagi ilovalarni kiritish</p>
            </div>
        </div>

        <div class="table-container" style="padding: 30px;">
            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data"
                  id="document-form">
                @csrf
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="name_uz">
                            Fayl nomi (O‘zbekcha) <span style="color: var(--danger-red);">*</span>
                        </label>
                        <input type="text" name="name[uz]" id="name_uz" class="search-input" style="width: 100%;"
                               placeholder="Masalan: Tizimdan foydalanish yo‘riqnomasi yoki qarorlar"
                               value="{{ old('name.uz') }}" required>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 25px;" class="full-width">
                        <div class="form-group">
                            <label for="name_ru">Fayl nomi (Ruscha)</label>
                            <input type="text" name="name[ru]" id="name_ru" class="search-input" style="width: 100%;"
                                   placeholder="Masalan: Инструкции или решения по использованию системы"
                                   value="{{ old('name.ru') }}">
                        </div>

                        <div class="form-group">
                            <label for="name_kaa">Fayl nomi (Qoraqalpoqcha)</label>
                            <input type="text" name="name[kaa]" id="name_kaa" class="search-input" style="width: 100%;"
                                   placeholder="Masalan: Sistemadan paydalanıw kórsetpesi yamasa qararlar"
                                   value="{{ old('name.kaa') }}">
                        </div>
                    </div>

                    <div class="form-group full-width" style="margin-top: 15px;">
                        <label for="file">PDF fayl yuklang <span style="color: var(--danger-red);">*</span></label>
                        <div
                            style="background: rgba(15, 23, 42, 0.4); padding: 15px; border-radius: 8px; border: 1px dashed var(--border-light);">
                            <input type="file" name="file" id="file" class="search-input"
                                   style="width: 100%; padding: 10px; cursor: pointer;"
                                   accept="application/pdf" required>

                            <p style="margin-top: 10px; font-size: 0.65rem; color: var(--text-muted);">
                                <i class="fas fa-info-circle" style="color: var(--primary-neon);"></i>
                                Faqat <b>.pdf</b> formatdagi fayllar. Fayl yuklangandan so'ng tizim avtomatik ravishda
                                birinchi sahifadan muqova (splash) rasmini kesib oladi.
                            </p>
                            @error('file')
                            <small
                                style="color: var(--danger-red); display: block; margin-top: 5px;">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="form-actions"
                     style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 20px; text-align: right;">
                    <button type="submit" class="btn-create">
                        <i class="fas fa-save"></i> Faylni saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
