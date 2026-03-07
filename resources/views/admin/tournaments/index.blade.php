@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">

        <div class="page-header">
            <div class="header-info">
                <h1>🏆 Turnirlar boshqaruvi</h1>
                <p>Tizimdagi barcha musobaqalar va ularning sozlamalari</p>
            </div>
            <a href="{{ route('tournaments.create') }}" class="btn-create">
                <span class="plus-icon">+</span> Yangi turnir
            </a>
        </div>

        <div class="table-container">
            <table class="admin-table">
                <thead>
                <tr style="text-align: center">
                    <th style="width: 5%; text-align: center;">#</th>
                    <th style="width: 35%;">Turnir haqida</th>
                    <th style="width: 25%;">Muddatlar</th>
                    <th style="width: 35%;">Boshqaruv paneli</th>
                </tr>
                </thead>
                <tbody>
                @forelse($tournaments as $tournament)
                    <tr>
                        <td class="text-center fw-bold text-muted">#{{ $tournament->id }}</td>
                        <td>
                            <div class="t-header">
                                <span class="t-title">{{ $tournament->name }}</span>
                                @if($tournament->status == '0')
                                    <span class="status-badge inactive">Nofaol</span>
                                @elseif($tournament->status == '1')
                                    <span class="status-badge active">Faol</span>
                                @elseif($tournament->status == '2')
                                    <span class="status-badge pending">Jarayonda</span>
                                @elseif($tournament->status == '3')
                                    <span class="status-badge ended">Yakunlangan</span>
                                @elseif($tournament->status == '4')
                                    <span class="status-badge cancelled">Qoldirilgan</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="time-list">
                                <div class="time-item">
                                    <span class="time-dot bg-success"></span>
                                    <span class="time-label">Boshlanishi:</span>
                                    <span class="time-val">{{ $tournament->started->format('d.m.Y H:i') }}</span>
                                </div>
                                <div class="time-item">
                                    <span class="time-dot bg-danger"></span>
                                    <span class="time-label">Yakunlanishi:</span>
                                    <span class="time-val">{{ $tournament->finished->format('d.m.Y H:i') }}</span>
                                </div>
                                <div class="time-item">
                                    <span class="time-dot bg-warning"></span>
                                    <span class="time-label text-warning">Ariza yuborish:</span>
                                    <span
                                        class="time-val text-warning">{{ $tournament->deadline->format('d.m.Y H:i') }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="action-badges-flex">

                                @if(in_array($tournament->status, ['0', '1', '2']))
                                    <a href="{{ route('weeks.show', $tournament->id) }}"
                                       class="action-badge badge-blue">
                                        <i class="fas fa-layer-group"></i> Turlar
                                    </a>
                                @endif
                                <a href="#" class="action-badge badge-purple">
                                    <i class="fas fa-users"></i> Talabalar
                                </a>

                                <a href="{{ route('program-languages.edit', $tournament->id) }}"
                                   class="action-badge badge-green">
                                    <i class="fas fa-code"></i> Dastur tillari
                                </a>

                                <a href="{{ route('universities.edit', $tournament->id) }}"
                                   class="action-badge badge-yellow">
                                    <i class="fas fa-university"></i> OTM
                                </a>

                                @if($tournament->status == '0')
                                    <a href="#" class="action-badge badge-pink">
                                        <i class="fas fa-user-shield"></i> Adminlar
                                    </a>
                                @endif
                                @if(in_array($tournament->status, ['0', '1']))
                                    <a href="{{ route('tournaments.edit', $tournament->id) }}"
                                       class="action-badge badge-edit">
                                        <i class="fas fa-edit"></i> O‘zgartirish
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center fw-bold text-muted" style="text-align: center">
                            Ma’lumotlar topilmadi
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $tournaments->links('pagination.custom') }}
        </div>
    </div>
@endsection
