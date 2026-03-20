@extends('layouts.welcome')

@section('content')
    <style>
        /* Google Drive uslubidagi Grid */
        .drive-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 25px;
            padding: 20px 0;
            width: 100%;
        }

        .drive-card {
            background: var(--card-bg, #1e293b);
            border: 1px solid var(--border-light, rgba(255, 255, 255, 0.08));
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .drive-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-neon, #38bdf8);
            box-shadow: 0 10px 25px rgba(56, 189, 248, 0.15);
        }

        .drive-thumbnail {
            height: 200px;
            background: rgba(15, 23, 42, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            border-bottom: 1px solid var(--border-light, rgba(255, 255, 255, 0.05));
        }

        .drive-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
            opacity: 0.5;
        }

        .drive-card:hover .drive-thumbnail img {
            transform: scale(1.05);
            opacity: 0.9;
        }

        .drive-thumbnail .fallback-icon {
            font-size: 5rem;
            color: var(--text-muted, #94a3b8);
            opacity: 0.3;
        }

        .drive-info {
            padding: 15px;
            align-items: center;
            gap: 12px;
            background: var(--panel-bg, #1e293b);
        }


        .drive-title {
            color: var(--text-color, #f1f5f9);
            font-size: 0.75rem;
            overflow: hidden;
            text-align: justify;
        }

        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            background: var(--card-bg, #1e293b);
            border-radius: 12px;
            border: 1px dashed var(--border-light, rgba(255, 255, 255, 0.1));
            color: var(--text-muted, #94a3b8);
        }

        .empty-state i {
            font-size: 3.5rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }
    </style>

    <section id="documents">
        <h1 class="section-title">
            {{ __('welcome.Documents and decisions') }}
        </h1>
        <div class="section-subtitle">
            {{ __('welcome.System rules, training materials, and all other decisions and important PDF files') }}
        </div>

        <div class="faq-container"
             style="max-width: 1200px; margin: 0 auto; background: transparent; border: none; box-shadow: none;">
            <div class="drive-grid">
                @forelse($documents as $document)
                    <a href="{{ asset('storage/' . $document->file) }}" target="_blank" class="drive-card"
                       title="{{ $document->name }}">
                        <div class="drive-thumbnail">
                            @if($document->splash)
                                <img src="{{ asset('storage/' . $document->splash) }}" alt="{{ $document->name }}">
                            @else
                                <i class="fas fa-file-pdf fallback-icon"></i>
                            @endif
                        </div>

                        <div class="drive-info">
                            <div class="drive-title">
                                {{ $document->name }}
                            </div>
                            <div style="color: var(--text-color); font-size: 11px">
                                {{ $document->created_at->format('d.m.Y') }}
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-folder-open"></i>
                        <p style="font-size: 12px">
                            Hozircha qaror yoki hujjatlar mavjud emas
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
