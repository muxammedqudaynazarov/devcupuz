@extends('layouts.app')
@section('content')
    <div class="content-body">
        <div class="section-header">
            <div>
                <div class="weeks-wrapper">
                    <div class="weeks-scroll">
                        @for ($i = 1; $i < 5; $i++)
                            <a href="?week={{ $i }}" class="week-item past">
                                <span class="week-number">{{ $i }}</span>
                            </a>
                        @endfor

                        <a href="?week=5" class="week-item active">
                            <span class="week-number">5</span>
                        </a>

                        <div class="week-item locked">
                            <span class="week-number">6</span>
                        </div>
                    </div>
                </div>
                <h2>Turnir masalalari</h2>
                <p style="color: #94a3b8; font-size: 0.7rem;">
                    4-tur: Algoritmlar va ma’lumotlar tuzilmalari
                </p>
            </div>
        </div>

        <div class="problems-container">
            <div class="problem-card">
                <div class="problem-main">
                    <div class="problem-status solved" title="Yechilgan"></div>
                    <div class="problem-details">
                        <h3 class="problem-title">A+B Masalasi</h3>
                        <div class="problem-meta">
                            <span>⏱️ 1.0s</span>
                            <span>💾 256MB</span>
                            <span class="difficulty easy">Oson</span>
                        </div>
                    </div>
                </div>
                <div class="problem-action">
                    <div class="point-badge">10 <span>ball</span></div>
                    <a href="{{ route('problems.show', 1) }}" class="btn-open">Yechish</a>
                </div>
            </div>

            <div class="problem-card">
                <div class="problem-main">
                    <div class="problem-status pending" title="Yechilmagan"></div>
                    <div class="problem-details">
                        <h3 class="problem-title">Binary Search - Massivdan qidiruv</h3>
                        <div class="problem-meta">
                            <span>⏱️ 2.0s</span>
                            <span>💾 128MB</span>
                            <span class="difficulty medium">O'rta</span>
                        </div>
                    </div>
                </div>
                <div class="problem-action">
                    <div class="point-badge">25 <span>ball</span></div>
                    <a href="#" class="btn-open">Yechish</a>
                </div>
            </div>

            <div class="problem-card">
                <div class="problem-main">
                    <div class="problem-status pending" title="Yechilmagan"></div>
                    <div class="problem-details">
                        <h3 class="problem-title">Dijkstra - Eng qisqa yo'l algoritmi</h3>
                        <div class="problem-meta">
                            <span>⏱️ 3.5s</span>
                            <span>💾 512MB</span>
                            <span class="difficulty hard">Qiyin</span>
                        </div>
                    </div>
                </div>
                <div class="problem-action">
                    <div class="point-badge">50 <span>ball</span></div>
                    <a href="#" class="btn-open">Yechish</a>
                </div>
            </div>
        </div>
    </div>
@endsection
