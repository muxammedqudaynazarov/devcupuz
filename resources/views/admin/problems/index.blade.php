@extends('layouts.admin')

@section('style')
    <style>
        /* Rasmdagi ko'k tugmalar dizayni */
        .action-btn-group {
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
        }

        .btn-outline-blue {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 38px;
            border: 2px solid var(--primary-neon, #38bdf8); /* Qalinroq ko'k border */
            border-radius: 8px;
            color: var(--primary-neon, #38bdf8);
            background: transparent;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
            outline: none;
            padding: 0; /* Button standart paddingini yo'q qilish */
        }

        .btn-outline-blue:hover {
            background: rgba(56, 189, 248, 0.15);
            box-shadow: 0 0 12px rgba(56, 189, 248, 0.4);
            transform: translateY(-2px);
        }

        /* Texnik parametrlar (MB, ms, point) uchun badge dizayni */
        .tech-badge {
            display: inline-block;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.8rem;
            color: #cbd5e1;
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .tech-badge span {
            color: var(--primary-neon);
            font-weight: bold;
        }
    </style>
@endsection

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
                    <th>Boshqaruv paneli</th>
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
