@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div class="header-info">
                <h1>❓ FAQ (Ko‘p beriladigan savollar)</h1>
                <p class="text-muted">Turnir haqida savol-javoblar ro'yxati</p>
            </div>
            <a href="{{ route('admin.faqs.create') }}" class="btn-create" style="text-decoration: none;">
                <i class="fas fa-plus"></i> Yangi qo‘shish
            </a>
        </div>

        <div class="table-container" style="padding: 20px;">
            <div class="table-responsive">
                <table class="data-table" style="width: 100%; border-collapse: collapse;">
                    <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">Tartib</th>
                        <th>Savol (UZ)</th>
                        <th>Javob qisqacha</th>
                        <th style="width: 150px; text-align: center;">Amallar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($faqs as $faq)
                        <tr>
                            <td style="text-align: center;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 3px;">
                                    {{-- TEPAGA TUGMASI (Disabled mantiqi) --}}
                                    <form action="{{ route('faqs.move-up', $faq->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn-order btn-order-up" @if($loop->first) disabled @endif>
                                            <i class="fas fa-chevron-up"></i>
                                        </button>
                                    </form>

                                    <span style="font-weight: 600; font-size: 0.9rem;">{{ $faq->order }}</span>

                                    {{-- PASTGA TUGMASI (Disabled mantiqi) --}}
                                    <form action="{{ route('faqs.move-down', $faq->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn-order btn-order-down" @if($loop->last) disabled @endif>
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td style="font-weight: 600; color: var(--text-main);">
                                {{ $faq->getTranslation('question', 'uz', false) ?? '' }}
                            </td>
                            <td style="color: var(--text-muted); font-size: 0.9rem;">
                                {{ \Illuminate\Support\Str::limit(strip_tags($faq->getTranslation('answer', 'uz', false)), 80) }}
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; justify-content: center; gap: 10px;">
                                    {{-- EDIT TUGMASI --}}
                                    <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="btn-action-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- DELETE TUGMASI --}}
                                    <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Rostdan ham o‘chirmoqchimisiz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 20px;">
                                Hozircha savol-javoblar kiritilmagan.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 15px;">
                {{ $faqs->links() }}
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        /* ... Oldingi uslublar qolishi mumkin ... */

        /* Yangi interaktiv tugmalar uslublari */

        /* Tepa-past surish tugmalari */
        .btn-order {
            padding: 3px 10px;
            font-size: 0.75rem;
            border: 2px solid transparent;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-order-up {
            color: var(--primary-neon);
            border-color: var(--primary-neon);
        }

        .btn-order-down {
            color: var(--primary-neon);
            border-color: var(--primary-neon);
        }

        .btn-order:hover:not(:disabled) {
            box-shadow: 0 0 10px rgba(56, 189, 248, 0.4);
            transform: translateY(-1px);
        }

        .btn-order:disabled {
            opacity: 0.2;
            cursor: not-allowed;
            border-color: #64748b;
        }

        /* Amallar tugmalari (Edit va Delete) */
        .btn-action-edit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border: 2px solid var(--warning-yellow);
            color: var(--warning-yellow);
            border-radius: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-action-edit:hover {
            box-shadow: 0 0 15px rgba(245, 158, 11, 0.5);
            transform: translateY(-2px);
        }

        .btn-action-delete {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border: 2px solid var(--danger-red);
            color: var(--danger-red);
            border-radius: 8px;
            transition: all 0.3s ease;
            background: transparent;
            cursor: pointer;
        }

        .btn-action-delete:hover {
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.5);
            transform: translateY(-2px);
        }
    </style>
@endsection
