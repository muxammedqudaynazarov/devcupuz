@extends('layouts.app')
@section('page_title', '🏆 Turnirlar ro‘yxati')
@section('page_title_desc', 'Tizimdagi barcha musobaqalar va ularning ro‘yxati')
@section('content')
    <div class="content-wrapper">
        <div class="table-container">
            <table class="admin-table">
                <thead>
                <tr style="text-align: center">
                    <th style="width: 5%; padding: 2em">#</th>
                    <th>Turnir haqida</th>
                    <th style="width: 20%;">Muddatlar</th>
                    <th style="width: 5%;">Ishtirokchilar</th>
                    <th style="width: 5%;">Holati</th>
                    <th style="width: 10%;"></th>
                </tr>
                </thead>
                <tbody>
                @forelse($tournaments as $tournament)
                    <tr>
                        <td class="fw-bold text-muted" style="text-align: center">#{{ $tournament->id }}</td>
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
                        <td style="text-align: center">
                            {{ $tournament->users_count }}
                        </td>
                        <td style="text-align: center">
                            @if($tournament->status == '0')
                                Nofaol
                            @elseif($tournament->status == '1')
                                Faol
                            @elseif($tournament->status == '2')
                                Jarayonda
                            @elseif($tournament->status == '3')
                                Yakunlangan
                            @elseif($tournament->status == '4')
                                Qoldirilgan
                            @endif
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
                        <td colspan="6" class="text-center fw-bold text-muted" style="text-align: center; padding: 40px">
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
