@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <div class="header-info">
                <h1>Turnir haftalari: <span style="color: var(--primary-neon);">{{ $tournament->name }}</span></h1>
                <p>Ushbu turnirga tegishli haftalar (turlar) ro‘yxatini boshqarish</p>
            </div>
            <div style="display: flex; gap: 15px;">
                <a href="{{ route('weeks.edit', $tournament->id) }}" class="btn-create" style="text-decoration: none;">
                    <i class="fas fa-plus"></i> Qo‘shish
                </a>
            </div>
        </div>

        <div class="table-container">
            <table class="admin-table" style="text-align: center">
                <thead>
                <tr>
                    <th style="width: 80px; text-align: center;">Bosqich</th>
                    <th>Tur nomi</th>
                    <th>Boshlanish</th>
                    <th>Yakunlanish</th>
                    <th>Holati</th>
                    <th style="width: 10% ">Harakat</th>
                </tr>
                </thead>
                <tbody>
                @forelse($tournament->weeks as $week)
                    <tr>
                        <td style="text-align: center;">
                            <span class="week-badge">{{ $week->week_number }}</span>
                        </td>
                        <td>
                            <div class="user-name-info">
                                <span class="name">{{ $week->name }}</span>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem;">
                                <span class="time-dot bg-success"></span>
                                <span
                                    class="time-val">{{ \Carbon\Carbon::parse($week->started)->format('d.m.Y H:i') }}</span>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem;">
                                <span class="time-dot bg-danger"></span>
                                <span
                                    class="time-val">{{ \Carbon\Carbon::parse($week->finished)->format('d.m.Y H:i') }}</span>
                            </div>
                        </td>
                        <td>
                            @if($week->status == '1')
                                <span class="status-badge active">Faol</span>
                            @else
                                <span class="status-badge inactive">Nofaol</span>
                            @endif
                        </td>
                        <td>
                            @php($has_next = \App\Models\Week::where('tournament_id', $tournament->id)->where('week_number', '>', $week->week_number)->exists())
                            @if(!$has_next)
                                <div style="display: flex; gap: 10px; ">
                                    <a href="{{ route('weeks.week_edit', [$tournament->id, $week->id]) }}" class="btn-action btn-open">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('weeks.week_destroy', [$tournament->id, $week->id]) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-danger" onclick="return confirm('Rostdan ham ushbu turni o\'chirmoqchimisiz?');">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px; color: #64748b;">
                            <i class="fas fa-layer-group"
                               style="font-size: 3rem; margin-bottom: 15px; opacity: 0.5;"></i>
                            <p>Hali bu turnirga hech qanday tur (hafta) qo'shilmagan.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
