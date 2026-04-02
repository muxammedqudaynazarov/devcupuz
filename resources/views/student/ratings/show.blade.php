@extends('layouts.app')

@section('page_title', '🏆 Hafta reytingi')
@section('page_title_desc', $week->name . ' natijalari')

@section('content')
    <div class="content-wrapper">
        <div class="table-container">
            <table class="admin-table" style="text-align: center">
                <thead>
                <tr>
                    <th style="width: 5%; padding: 2em">O‘rin</th>
                    <th style="text-align: start">Foydalanuvchi</th>
                    <th style="width: 15%;">Ball</th>
                    <th style="width: 15%;">Jarima</th>
                    <th style="width: 15%;">Urinishlar</th>
                </tr>
                </thead>
                <tbody>
                @forelse($ratings as $index => $rating)
                    @php
                        // Paginatsiya bilan hisoblaganda umumiy ro'yxatdagi haqiqiy o'rnini topish
                        $rank = ($ratings->currentPage() - 1) * $ratings->perPage() + $loop->iteration;
                    @endphp
                    <tr>
                        <td>
                            @if($rank == 1)
                                <span style="font-size: 1.5rem;" title="1-o'rin">🥇</span>
                            @elseif($rank == 2)
                                <span style="font-size: 1.5rem;" title="2-o'rin">🥈</span>
                            @elseif($rank == 3)
                                <span style="font-size: 1.5rem;" title="3-o'rin">🥉</span>
                            @else
                                <span style="font-weight: bold; color: #94a3b8;">#{{ $rank }}</span>
                            @endif
                        </td>
                        <td style="text-align: start">
                            <a href="{{ route('user.show', $rating->user->username) }}"
                               style="font-weight: bold; color: var(--text-color); text-decoration: none">
                                {{ $rating->user->name['full'] }}
                            </a>
                            <div style="font-size: x-small; color: #94a3b8; margin-top: 4px;">
                                {{ $rating->user->university->name ?? 'Belgilanmagan' }}
                            </div>
                        </td>
                        <td style="font-weight: bold; color: #38bdf8;">
                            {{ $rating->score }}
                        </td>
                        <td class="text-muted" style="font-size: small">
                            {{ $rating->penalty > 0 ? '-' . $rating->penalty : '0' }}
                        </td>
                        <td class="text-muted" style="font-size: small">
                            {{ $rating->attempts }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center fw-bold text-muted" style="padding: 40px;">
                            <i class="fas fa-trophy" style="font-size: 2rem; opacity: 0.2; margin-bottom: 10px;"></i><br>
                            Hozircha ushbu haftada natijalar mavjud emas
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            @if($ratings->total() > auth()->user()->per_page)
                <div style="padding: 15px;">
                    {{ $ratings->links('pagination.custom') }}
                </div>
            @endif
        </div>
    </div>
@endsection
