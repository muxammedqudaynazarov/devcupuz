@extends('layouts.app')
@section('content')
    <div class="content-body">
        <div class="section-header">
            <h2>Turnir reytingi</h2>
            <div class="search-box">
                <input type="text" placeholder="Ism bo'yicha qidirish..." class="search-input">
            </div>
        </div>

        <div class="leaderboard-card">
            <table>
                <thead>
                <tr>
                    <th style="width: 70px;">#</th>
                    <th>Talaba</th>
                    <th>Universitet</th>
                    <th>Guruh</th>
                    <th>Ball</th>
                </tr>
                </thead>
                <tbody>
                @foreach($students as $student)
                    <tr class="{{ auth()->id() == $student->id ? 'active-user-row' : '' }}">
                        <td class="rank">#{{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}</td>
                        <td class="user-cell">
                            <div class="user-avatar-wrapper">
                                <img src="{{ $student->image ?? 'https://ui-avatars.com/api/?name='.$student->name }}" alt="Avatar" class="table-avatar">
                                @if($loop->iteration + ($students->currentPage() - 1) * $students->perPage() <= 3)
                                    <span class="medal-icon">{{ $loop->iteration == 1 ? '🥇' : ($loop->iteration == 2 ? '🥈' : '🥉') }}</span>
                                @endif
                            </div>
                            <div class="user-name-info">
                                <div class="name">{{ json_decode($student->name)->full }}</div>
                                <div class="sub-text">ID: {{ $student->id }}</div>
                            </div>
                        </td>
                        <td class="univer-text">
                            {{ $student->university->name ?? 'Noma\'lum' }}
                        </td>
                        <td><span class="group-text">KI-21-04</span></td>
                        <td class="total-score">{{ $student->total_points ?? 0 }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="pagination-wrapper">
                {{ $students->links('pagination.custom') }}
            </div>
        </div>
    </div>
@endsection
