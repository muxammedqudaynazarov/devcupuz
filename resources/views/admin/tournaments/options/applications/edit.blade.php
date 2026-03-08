@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <div class="header-info">
                <h1>{{ $tournament->name }} turniriga tushgan arizalar</h1>
                <p>Ushbu turnirga qatnashish istagini bildirgan talabalar ro‘yxati</p>
            </div>
        </div>
        <div class="table-container">
            <table class="admin-table">
                <thead>
                <tr style="text-align: center">
                    <th style="width: 5%;">#</th>
                    <th style="width: 30%;">Talaba (F.I.SH)</th>
                    <th style="width: 20%;">O‘quv yurti</th>
                    <th style="width: 15%;">Ariza vaqti</th>
                    <th style="width: 15%;"></th>
                </tr>
                </thead>
                <tbody>
                @forelse($applications as $user)
                    <tr style="text-align: center;">
                        <td class="fw-bold text-muted">{{ $loop->iteration }}</td>
                        <td style="text-align: left;">
                            <div class="t-header">
                                <span class="t-title">{{ json_decode($user->name)->full }}</span>
                            </div>
                            <div class="text-muted" style="font-size: 0.8rem;">
                                Telefon: {{ $user->phone ?? '-' }}
                            </div>
                        </td>
                        <td class="text-muted" style="font-size: small">{{ $user->university->name ?? '-' }}</td>
                        <td class="text-muted" style="font-size: small">
                            {{ $user->pivot->created_at ? $user->pivot->created_at->format('d.m.Y H:i') : '-' }}
                        </td>
                        <td>
                            @if($user->pivot->status == '0')
                                <div class="action-badges-flex" style="justify-content: center;">
                                    <form action="{{ route('applications.update', [$tournament->id, $user->id]) }}"
                                          method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="1">
                                        <button type="submit" class="btn-confirm"
                                                style="border: none; cursor: pointer;">
                                            <i class="fas fa-check"></i> Qabul qilish
                                        </button>
                                    </form>

                                    <form
                                        action="{{ route('applications.update', [$tournament->id, $user->id]) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="2">
                                        <button type="submit" class="btn-cancel"
                                                style="border: none; cursor: pointer;">
                                            <i class="fas fa-times"></i> Bekor qilish
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-muted" style="font-size: 0.8rem;"></span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center fw-bold text-muted" style="padding: 30px;">
                            Hozircha arizalar kelib tushmagan
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $applications->links('pagination.custom') }}
            </div>
        </div>
    </div>
@endsection
