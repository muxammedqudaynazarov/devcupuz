@extends('layouts.admin')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <style>
        /* --- Select2 Dark & Neon Dizayni --- */

        /* Asosiy input qutisi */
        .select2-container--default .select2-selection--multiple {
            background: rgba(15, 23, 42, 0.5) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 10px !important;
            min-height: 50px !important; /* Standart input o'lchamiga moslash */
            padding: 4px 10px !important;
            transition: border-color 0.3s ease;
        }

        /* Focus bo'lganda (bosilganda) neon border */
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: var(--primary-neon) !important;
            box-shadow: 0 0 10px rgba(56, 189, 248, 0.1);
        }

        /* Yozilayotgan matn (Search input) */
        .select2-container--default .select2-search--inline .select2-search__field {
            color: #fff !important;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            margin-top: 8px !important;
            caret-color: var(--primary-neon); /* Kursor rangi */
        }

        /* Tanlangan itemlar (Teglar / Badgelar) */
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background: rgba(56, 189, 248, 0.1) !important;
            border: 1px solid rgba(56, 189, 248, 0.3) !important;
            color: var(--primary-neon) !important;
            border-radius: 8px !important;
            padding: 5px 12px !important;
            margin-top: 6px !important;
            display: inline-flex;
            flex-direction: row-reverse; /* X tugmasini o'ng tomonga o'tkazish */
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* 'X' o'chirish tugmasi */
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: var(--primary-neon) !important;
            border: none !important;
            position: relative !important;
            margin: 0 !important;
            padding: 0 !important;
            font-size: 1.2rem;
            line-height: 1;
            transition: 0.2s;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            background: transparent !important;
            color: #fff !important;
            transform: scale(1.2);
        }

        /* Pastga ochiladigan menyu (Dropdown) */
        .select2-dropdown {
            background-color: #1e293b !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 10px !important;
            overflow: hidden;
            margin-top: 5px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
        }

        /* Qidiruv natijalari / Optionlar */
        .select2-container--default .select2-results__option {
            color: #cbd5e1 !important;
            padding: 12px 20px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            transition: background 0.2s ease;
        }

        /* Option ustiga borganda */
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: var(--primary-neon) !important;
            color: #0f172a !important; /* Matn qorayadi (kontrast uchun) */
            font-weight: 600;
        }

        /* Avval tanlab bo'lingan optionlar */
        .select2-container--default .select2-results__option[aria-selected="true"] {
            background-color: rgba(255, 255, 255, 0.03) !important;
            color: #64748b !important;
            cursor: not-allowed;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <div class="header-info">
                <h1>Turnirdagi OTM ro‘yxati:
                    <span style="color: var(--primary-neon);">
                        {{ $tournament->name }}
                    </span>
                </h1>
                <p style="font-size: 12px">
                    Ushbu turnirda talabalari qatnashishi ruxsat etilgan oliy ta’lim tashkilotlari sozlamalari
                </p>
            </div>
        </div>

        <div class="table-container" style="padding: 30px;">
            <form action="{{ route('program-languages.update', $tournament->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="programs-select"
                               style="display: block; margin-bottom: 12px; color: #94a3b8; font-weight: 500;">
                            * Ruxsat etilgan oliy ta’lim tashkilotlari
                        </label>
                        <select name="universities[]" id="universities-select" style="width: 100%;" multiple="multiple">
                            @foreach($universities as $university)
                                <option value="{{ $university->id }}"
                                    {{ $tournament->universities->contains($university->id) ? 'selected' : '' }}>
                                    {{ $university->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-actions"
                     style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 20px; text-align: right">
                    <button type="submit" class="btn-create">
                        <i class="fas fa-save"></i> O‘zgarishlarni saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#universities-select').select2({
                placeholder: "OTM nomi bo‘yicha qidiring yoki tanlang...",
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function () {
                        return "Bunday OTM topilmadi";
                    }
                }
            });
        });
    </script>
@endsection
