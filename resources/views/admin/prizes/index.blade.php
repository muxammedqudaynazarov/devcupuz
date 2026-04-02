@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <div class="header-info">
                <h1>Sovrinlar</h1>
                <p>Turnir g‘oliblari uchun mo‘ljallangan yutuqlar va sovg‘alar ro‘yxati</p>
            </div>
            <a href="{{ route('prizes.create') }}" class="btn-create">
                <span class="plus-icon">+</span> Yangi sovrin
            </a>
        </div>

        <div class="table-container">
            <table class="admin-table">
                <thead>
                <tr style="text-align: center">
                    <th style="width: 5%;">#</th>
                    <th style="width: 15%;">Banner (rasm)</th>
                    <th style="text-align: left; width: 35%;">Sovrin nomi va tavsifi</th>
                    <th style="width: 15%;">Holati</th>
                    <th style="width: 20%;">Amallar</th>
                </tr>
                </thead>
                <tbody>
                @forelse($prizes as $prize)
                    <tr>
                        <td class="text-center fw-bold text-muted" style="text-align: center;">
                            #{{ $prize->id }}
                        </td>
                        <td style="text-align: center;">
                            <img src="{{ asset('storage/' . $prize->image) }}" alt="Prize"
                                 style="width: 80px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border-light);">
                        </td>
                        <td style="text-align: left;">
                            <div class="t-title"
                                 style="font-size: 1.05rem; color: var(--text-color); margin-bottom: 5px;">
                                {{ $prize->title }}
                            </div>
                            <div
                                style="font-size: 0.8rem; color: var(--text-muted); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $prize->desc ?? 'Tavsif kiritilmagan' }}
                            </div>
                        </td>
                        <td style="text-align: center;">
                            @if($prize->actual == '1')
                                <i class="fas fa-star"></i>
                            @else
                                <i class="fas fa-archive"></i>
                            @endif
                        </td>
                        <td>
                            <div class="action-badges-flex" style="justify-content: center;">
                                <a href="{{ route('prizes.edit', $prize->id) }}"
                                   style="text-decoration: none; border-radius: 10px; border:1px solid #aaa; color: #fff; padding: 5px 10px; justify-items: center">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('prizes.destroy', $prize->id) }}" method="POST"
                                      style="margin: 0;"
                                      onsubmit="return confirm('Rostdan ham ushbu sovrinni o‘chirmoqchimisiz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="badge-pink"
                                            style="text-decoration: none; border-radius: 10px; border:1px solid #aaa; color: #fff; padding: 15px">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center fw-bold text-muted"
                            style="text-align: center; padding: 40px;">
                            <i class="fas fa-gift" style="font-size: 3rem; opacity: 0.3; margin-bottom: 15px;"></i><br>
                            Hozircha hech qanday sovrin qo'shilmagan
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            @if($prizes->total() > auth()->user()->per_page)
                <div style="margin-top: 20px;">
                    {{ $prizes->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
