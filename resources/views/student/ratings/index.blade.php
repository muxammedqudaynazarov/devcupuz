@extends('layouts.app')
@section('page_title', '📊 Turnir reytingi')
@section('page_title_desc', $tournament->name . ' musobaqasi natijalari')
@section('content')
    <div class="content-wrapper">
        {{--<div class="page-header">
            <div class="header-info">
                <h1></h1>
                <p>{{ $tournament->name }} musobaqasi natijalari</p>
            </div>
        </div>
--}}
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
                    <tr>
                        <td>
                            @if($index + 1 == 1)
                                🥇
                            @elseif($index + 1 == 2)
                                🥈
                            @elseif($index + 1 == 3)
                                🥉
                            @else
                                #{{ $index + 1 }}
                            @endif
                        </td>
                        <td style="text-align: start">
                            <a href="{{ route('user.show', $rating->user->username) }}"
                               style="font-weight: bold; color: var(--text-color); text-decoration: none">
                                {{ json_decode($rating->user->name)->full }}
                            </a>
                            <div style="font-size: x-small; color: #94a3b8; margin-top: 4px;">
                                {{ $rating->user->university->name }}
                            </div>
                        </td>
                        <td>
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
                            Hozircha natijalar mavjud emas
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
