@extends('layouts.admin')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <div class="header-info">
                <h1>Turnirdagi dasturlash tillari:
                    <span style="color: var(--primary-neon);">
                        {{ $tournament->name }}
                    </span>
                </h1>
                <p style="font-size: 12px">
                    Ushbu turnirda qatnashchilar foydalana olishlari mumkin bo‘lgan dasturlash tillari sozlamalari
                </p>
            </div>
        </div>

        <div class="table-container" style="padding: 30px;">
            @if(!in_array($tournament->status, ['4', '5']))
                <form action="{{ route('program-languages.update', $tournament->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="programs-select"
                                   style="display: block; margin-bottom: 12px; color: #94a3b8; font-weight: 500;">
                                * Ruxsat etilgan dasturlash tillari (bir nechta tanlash mumkin)
                            </label>
                            <select name="programs[]" id="programs-select" style="width: 100%;" multiple="multiple">
                                @foreach($all_programs as $program)
                                    <option value="{{ $program->id }}"
                                        {{ $tournament->programs->contains($program->id) ? 'selected' : '' }}>
                                        {{ $program->name }}
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
            @else
                @foreach($tournament->programs as $program)
                    <div class="btn-open" style="display: inline-block; margin: 0.2em; padding: 0.4em; font-weight: normal">
                        {{ $program->name }}
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#programs-select').select2({
                placeholder: "Dasturlash tillarini qidiring yoki tanlang...",
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function () {
                        return "Bunday til topilmadi";
                    }
                }
            });
        });
    </script>
@endsection
