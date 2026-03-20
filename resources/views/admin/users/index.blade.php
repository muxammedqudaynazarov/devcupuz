@extends('layouts.admin')

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
                            </div>
                            <a style="font-size: 0.65rem;color: var(--primary-neon); display: block; text-decoration: none"
                               href="{{ route('user.show', $user->username) }}">
                                {{ '@' . $user->username }}
                            </a>

                            {{--<div style="margin-top: 5px;">
                                @if($user->status == '0')
                                    <span class="status-badge pending">Kutilmoqda</span>
                                @elseif($user->status == '1')
                                    <span class="status-badge active">Tasdiqlangan</span>
                                @elseif($user->status == '2')
                                    <span class="status-badge inactive">Taqiqlangan</span>
                                @elseif($user->status == '3')
                                    <span class="status-badge ended">Bloklangan (Ban)</span>
                                @endif
                            </div>--}}
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
                                        <span
                                            style="font-size: 0.75rem; background: rgba(56, 189, 248, 0.1); color: var(--primary-neon); padding: 2px 8px; border-radius: 6px; border: 1px solid var(--primary-neon);">
                                            {{ ucfirst(is_object($r) ? $r->name : $r) }}
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
