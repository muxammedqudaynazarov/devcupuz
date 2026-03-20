@extends('layouts.admin')
@section('style')
    <style>
        .br50 {
            border-radius: 50%;
            width: 22px;
            height: 22px;
            font-size: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            cursor: help;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .br50:hover {
            transform: scale(1.2);
            filter: brightness(1.2);
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">

        <div class="page-header">
            <div class="header-info">
                <h1>👥 Foydalanuvchilar boshqaruvi</h1>
                <p>Tizimdagi barcha foydalanuvchilar, ularning rollari va holatlari</p>
            </div>
        </div>

        <div class="table-container">
            <table class="admin-table">
                <thead>
                <tr style="text-align: center">
                    <th>#</th>
                    <th style="text-align: left;">Foydalanuvchi</th>
                    <th>Aloqa / OTM</th>
                    <th>Lavozim & Rollari</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    @php
                        $userRoles = is_string($user->rol) ? json_decode($user->rol, true) : ($user->rol ?? []);
                    @endphp
                    <tr>
                        <td class="text-center fw-bold text-muted" style="text-align: center">
                            #{{ $user->id }}
                        </td>
                        <td style="text-align: left;">
                            <div class="t-title">
                                {{ $user->name['full'] ?? '?' }}
                                @if($user->status == '0')
                                    <div class="status-badge pending br50">
                                        <i class="fas fa-hourglass-half"></i>
                                    </div>
                                @elseif($user->status == '1')
                                    <div class="status-badge active br50">
                                        <i class="fas fa-check"></i>
                                    </div>
                                @elseif($user->status == '2')
                                    <div class="status-badge inactive br50">
                                        <i class="fas fa-times"></i>
                                    </div>
                                @elseif($user->status == '3')
                                    <div class="status-badge ended br50">
                                        <i class="fas fa-user-slash"></i>
                                    </div>
                                @endif
                            </div>
                            <a style="font-size: 0.65rem;color: var(--primary-neon); display: block; text-decoration: none"
                               href="{{ route('user.show', $user->username) }}">
                                {{ '@' . $user->username }}
                            </a>
                        </td>
                        <td style="font-size: 11px; text-align: center">
                            <a style="color: var(--text-color); text-decoration: none" href="tel:+{{ $user->phone }}">
                                {{ preg_replace('/(\d{3})(\d{2})(\d{3})(\d{2})(\d{2})/', '+$1 ($2) $3-$4-$5', $user->phone) }}
                            </a>
                            <div style="color: var(--text-muted);">
                                {{ $user->university->name ?? '' }}
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <div style="display: flex; flex-wrap: wrap; gap: 5px; justify-content: center;">
                                @if(is_array($userRoles))
                                    @foreach($userRoles as $r)
                                        @php($rl = \Spatie\Permission\Models\Role::where('name', $r)->first())
                                        <span
                                            style="font-size: 0.75rem; background: rgba(56, 189, 248, 0.1); color: var(--primary-neon); padding: 2px 8px; border-radius: 6px; border: 1px solid var(--primary-neon);">
                                            {{ $rl->desc }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ route('users.edit', $user->id) }}" class="action-badge badge-edit">
                                Tahrirlash
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center fw-bold text-muted"
                            style="text-align: center; padding: 40px;">
                            <i class="fas fa-users" style="font-size: 3rem; opacity: 0.3; margin-bottom: 15px;"></i><br>
                            Foydalanuvchilar topilmadi
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{-- $users->links('pagination.custom') --}}
        </div>
    </div>
@endsection
