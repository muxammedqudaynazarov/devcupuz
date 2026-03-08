@extends('layouts.admin')


@section('content')
    <div class="content-wrapper">

        <div class="page-header">
            <div class="header-info">
                <h1>🏆 Turnir masalalari</h1>
                <p>Barcha algoritmik masalalar ro'yxati va sozlamalari</p>
            </div>
            <a href="{{ route('admin.problems.create') }}" class="btn-create" style="text-decoration: none;">
                <span class="plus-icon">+</span> Yangi masala
            </a>
        </div>

        @if(session('success'))
            <div
                style="background: rgba(34, 197, 94, 0.1); border-left: 4px solid #22c55e; color: #22c55e; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table class="admin-table" style="text-align: center">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Masala</th>
                    <th>Turnir va boshqich</th>
                    <th>Texnik cheklovlar</th>
                    <th style="width: 10%">Boshqaruv paneli</th>
                </tr>
                </thead>
                <tbody>
                @forelse($problems as $problem)
                    <tr>
                        <td>
                            #{{ sprintf('%04d', $problem->id) }}
                        </td>

                        <td style="font-weight: bold">
                            {{ $problem->name }}
                        </td>
                        <td style="font-size: small">
                            {{ $problem->week?->tournament?->name ?? 'Turnir topilmadi' }}
                            <span style="margin: 0 5px;">•</span>
                            {{ $problem->week?->week_number ?? '?' }}-bosqich
                        </td>
                        <td>
                            <div class="tech-badge">Xotira: <span>{{ $problem->memory }} MB</span></div>
                            <div class="tech-badge">Vaqt: <span>{{ $problem->runtime }} sek</span></div>
                            <div class="tech-badge">Ball: <span>{{ $problem->point }}</span></div>
                        </td>

                        <td style="text-align: center;">
                            <div class="action-btn-group">
                                <a href="{{ route('admin.problems.edit', $problem->id) }}" class="btn-outline-blue"
                                   title="Tahrirlash">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.problems.destroy', $problem->id) }}" method="POST"
                                      style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-outline-blue"
                                            onclick="return confirm('Rostdan ham ushbu masalani o\'chirmoqchimisiz?');"
                                            title="O'chirish">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: #64748b;">
                            <i class="fas fa-code" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.5;"></i>
                            <p>Hozircha hech qanday masala qo'shilmagan.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $problems->links() }}
        </div>
    </div>
@endsection
