@extends('layouts.app')

@section('content')
    <div class="content-wrapper">

        <div class="page-header">
            <div class="header-info">
                <h1>🏆 Turnirlar ro‘yxati</h1>
                <p>Tizimdagi barcha musobaqalar va ularning ro‘yxati</p>
            </div>
        </div>

        <div class="table-container">
            <table class="admin-table">
                <thead>
                <tr style="text-align: center">
                    <th style="width: 5%;">#</th>
                    <th>Turnir haqida</th>
                    <th style="width: 20%;">Muddatlar</th>
                    <th style="width: 5%;">Qatnashchilar</th>
                    <th style="width: 5%;">Holati</th>
                    <th style="width: 10%;"></th>
                </tr>
                </thead>
                <tbody>
                @forelse($tournaments as $tournament)
                    <tr>
                        <td class="fw-bold text-muted">#{{ $tournament->id }}</td>
                        <td>
                            <div class="t-header">
                                <span class="t-title">{{ $tournament->name }}</span>
                            </div>
                            @foreach($tournament->programs as $program)
                                <div class="status-badge badge-secondary"
                                     style="font-weight: normal; font-size: 10px; margin: 0.2em; text-transform: none">
                                    {{ $program->name }}
                                </div>
                            @endforeach
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
                        <td style="text-align: center">0</td>
                        <td style="text-align: center">
                            <div class="t-header">
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
                        <td style="text-align: center">
                            @if($tournament->is_applied)
                                @php
                                    $appStatus = $tournament->users->first() ?? null;
                                @endphp
                                @if($appStatus->status == '1' && $appStatus->active == '0')
                                    <form id="activate-form-{{ $tournament->id }}"
                                          action="{{ route('problems.activated') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="tournament_id" value="{{ $tournament->id }}">
                                        <button type="button" class="btn-open" style="cursor: pointer"
                                                onclick="confirmActivation('{{ $tournament->id }}')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('student.tournaments.show', $tournament->id) }}" class="btn-open"
                                       style="padding: 7px 20px">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endif
                            @else
                                @if(!in_array($tournament->status, ['0', '5']))
                                    <a href="{{ route('student.tournaments.show', $tournament->id) }}" class="btn-open"
                                       style="padding: 7px 20px">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endif
                            @endif
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
@section('script')
    <script>
        function confirmActivation(tournamentId) {
            Swal.fire({
                title: 'Siz turnirni o‘zgartirmoqchisiz.',
                text: "Ushbu turnirga o‘tishni xohlaysizmi?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#38bdf8',
                cancelButtonColor: '#f87171',
                confirmButtonText: 'Ha, o‘tish',
                cancelButtonText: 'Yo‘q, qilish',
                background: '#1e293b',
                color: '#f1f5f9'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('activate-form-' + tournamentId).submit();
                }
            })
        }
    </script>
@endsection
