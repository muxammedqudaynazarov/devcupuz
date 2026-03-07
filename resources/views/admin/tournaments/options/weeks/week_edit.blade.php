@extends('layouts.admin')

@section('style')
    <style>
        .inner-row-grid {
            display: grid;
            grid-template-columns: 2fr 6fr 4fr; /* Raqam(2), Nom(6), Status(4) */
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

        /* O'zgartirish taqiqlangan maydon stili */
        .input-disabled {
            background-color: rgba(15, 23, 42, 0.8) !important;
            color: #64748b !important;
            cursor: not-allowed;
            border-color: rgba(255, 255, 255, 0.05) !important;
        }

        @media (max-width: 768px) {
            .inner-row-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <div class="header-info">
                <h1>Haftani o‘zgartirish</h1>
                <p>Turnir: <span style="color: var(--primary-neon);">{{ $tournament->name }}</span></p>
            </div>
        </div>

        <div class="table-container" style="padding: 30px;">
            <form action="{{ route('weeks.week_update', ['tournament_id' => $tournament->id, 'week_id' => $week->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-grid">
                    <div class="inner-row-grid full-width">
                        <div class="form-group">
                            <label for="week_number">Bosqich raqami №</label>
                            <input type="number" id="week_number" class="search-input input-disabled"
                                   style="width: 100%;"
                                   value="{{ $week->week_number }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="name">Tur nomi</label>
                            <input type="text" name="name" id="name" class="search-input" style="width: 100%;"
                                   placeholder="Masalan: 1-hafta (Kirish va asoslar)" value="{{ old('name', $week->name) }}"
                                   required>
                            @error('name') <small style="color: var(--danger-red); display: block; margin-top: 5px;">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Tur holati</label>
                            <select name="status" id="status" class="search-input"
                                    style="width: 100%; cursor: pointer;">
                                <option value="1" {{ old('status', $week->status) == '1' ? 'selected' : '' }}>Faol (ochiq)</option>
                                <option value="0" {{ old('status', $week->status) == '0' ? 'selected' : '' }}>Nofaol (yopiq)</option>
                            </select>
                            @error('status') <small style="color: var(--danger-red); display: block; margin-top: 5px;">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;" class="full-width">
                        <div class="form-group">
                            <label for="started">Boshlanish vaqti</label>
                            <input type="datetime-local" name="started" id="started" class="search-input"
                                   style="width: 100%;" value="{{ old('started', \Carbon\Carbon::parse($week->started)->format('Y-m-d\TH:i')) }}" required>
                            @error('started') <small style="color: var(--danger-red); display: block; margin-top: 5px;">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label for="finished">Yakunlanish vaqti</label>
                            <input type="datetime-local" name="finished" id="finished" class="search-input"
                                   style="width: 100%;" value="{{ old('finished', \Carbon\Carbon::parse($week->finished)->format('Y-m-d\TH:i')) }}" required>
                            @error('finished') <small style="color: var(--danger-red); display: block; margin-top: 5px;">{{ $message }}</small> @enderror
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
