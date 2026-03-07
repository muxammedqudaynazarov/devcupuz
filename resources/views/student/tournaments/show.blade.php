@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <div class="header-info">
                <h1 style="display: flex; align-items: center;">
                    🏆 {{ $tournament->name }}
                    @if($tournament->status == '1')
                        <span class="status-badge status-active">Faol</span>
                    @elseif($tournament->status == '3')
                        <span class="status-badge status-inactive">Yakunlangan</span>
                    @endif
                </h1>
                <p>Turnir shartlari va mezonlari bilan tanishib chiqing</p>
            </div>
        </div>

        <div class="tournament-container">

            <div class="card-panel">
                <div class="desc-content">
                    {!! $tournament->desc !!}
                </div>
            </div>

            <div>
                <div class="card-panel">
                    <h3 style="color: #f8fafc; margin-bottom: 20px; font-size: 1.1rem;">
                        📊 Umumiy ma’lumotlar
                    </h3>

                    <ul class="info-list">
                        <li>
                            <span class="info-label">Qatnashchilar:</span>
                            <span class="info-value">
                                {{ $tournament->users_count }}
                            </span>
                        </li>
                        <li>
                            <span class="info-label">Ariza qabul qilish:</span>
                            <span class="info-value text-danger">
                                {{ $tournament->deadline->format('d.m.Y') }}
                            </span>
                        </li>
                        <li>
                            <span class="info-label">Boshlanish vaqti:</span>
                            <span class="info-value">
                                {{ $tournament->started->format('d.m.Y H:i') }}
                            </span>
                        </li>
                        <li>
                            <span class="info-label">Tugash vaqti:</span>
                            <span class="info-value">
                                {{ $tournament->finished->format('d.m.Y H:i') }}
                            </span>
                        </li>
                    </ul>

                    @if($application)
                        <div style="margin-top: 20px;">
                            @if($application->status == '0')
                                <div
                                    style="background: rgba(234, 179, 8, 0.1); border: 1px solid rgba(234, 179, 8, 0.4); color: #eab308; padding: 15px; border-radius: 8px; text-align: center; box-shadow: 0 0 10px rgba(234, 179, 8, 0.1);">
                                    <i class="fas fa-spinner fa-spin"
                                       style="margin-bottom: 8px; font-size: 1.5rem;"></i><br>
                                    <span style="font-weight: 600;">Arizangiz yuborilgan</span><br>
                                    <span
                                        style="font-size: 0.85rem; opacity: 0.8;">Moderatsiya tekshiruvi kutilmoqda...</span>
                                </div>
                            @elseif($application->status == '1')
                                <div
                                    style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.4); color: #4ade80; padding: 15px; border-radius: 8px; text-align: center; box-shadow: 0 0 10px rgba(34, 197, 94, 0.1);">
                                    <i class="fas fa-check-circle"
                                       style="margin-bottom: 8px; font-size: 1.5rem;"></i><br>
                                    <span style="font-weight: 600;">Arizangiz qabul qilingan!</span><br>
                                    <span
                                        style="font-size: 0.85rem; opacity: 0.8;">Turnirda muvaffaqiyat tilaymiz.</span>
                                </div>
                            @elseif($application->status == '2')
                                <div
                                    style="background: rgba(248, 113, 113, 0.1); border: 1px solid rgba(248, 113, 113, 0.4); color: #f87171; padding: 15px; border-radius: 8px; text-align: center; box-shadow: 0 0 10px rgba(248, 113, 113, 0.1);">
                                    <i class="fas fa-times-circle"
                                       style="margin-bottom: 8px; font-size: 1.5rem;"></i><br>
                                    <span style="font-weight: 600;">Arizangiz bekor qilingan</span><br>
                                    <span style="font-size: 0.85rem; opacity: 0.8;">Qo'shimcha ma'lumot uchun admin bilan bog'laning.</span>
                                </div>
                            @endif
                        </div>
                    @else
                        @if($tournament->status == '1' && now()->lessThan($tournament->deadline))
                            @if(auth()->user()->status == '0')
                                <div
                                    style="background: rgba(24acc14, 0.1); border: 1px solid rgba(250, 204, 21, 0.4); color: #facc15; padding: 15px; border-radius: 8px; text-align: center; margin-top: 20px;">
                                    <i class="fas fa-exclamation-triangle"
                                       style="margin-bottom: 8px; font-size: 1.5rem;"></i><br>
                                    <span style="font-weight: 600;">Profilingiz tasdiqlanmagan!</span><br>
                                    <span style="font-size: 0.85rem; opacity: 0.8;">
                                        Turnirda ishtirok etish uchun profilingizni telefon raqam orqali tasdiqlashingiz shart.
                                    </span>
                                    <a href="{{ route('student.verify') }}" class="btn-apply"
                                       style="background: #facc15; color: #0f172a; text-decoration: none; display: block; margin-top: 15px;">
                                        <i class="fas fa-mobile-alt"></i> Tasdiqlash
                                    </a>
                                </div>
                            @else
                                <form action="{{ route('student.tournaments.update', $tournament->id) }}" method="POST"
                                      id="apply-form" style="margin-top: 20px;">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" class="btn-apply" onclick="openApplyModal()">
                                        <i class="fas fa-paper-plane"></i> Ariza yuborish
                                    </button>
                                </form>
                            @endif

                            <div class="apply-modal-overlay" id="applyModal">
                                <div class="apply-modal">
                                    <h3 class="apply-modal-title">Turnirga yozilish</h3>
                                    <p class="apply-modal-text">Siz haqiqatdan ham <b>{{ $tournament->name }}</b>
                                        turniriga
                                        yozilishni tasdiqlaysizmi? Moderatsiya tasdiqlagandan so'ng turnirda
                                        qatnashishingiz
                                        mumkin bo'ladi.</p>

                                    <div class="apply-modal-actions">
                                        <button class="btn-modal-cancel" onclick="closeApplyModal()" type="button">
                                            Yo'q, bekor qilish
                                        </button>
                                        <button class="btn-modal-confirm" onclick="submitApplyForm()" type="button">
                                            Ha, tasdiqlayman
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @elseif(now()->greaterThan($tournament->deadline))
                            <div
                                style="text-align: center; color: #64748b; margin-top: 20px; padding: 12px; border: 1px dashed rgba(255,255,255,0.1); border-radius: 8px; font-size: 0.9rem;">
                                <i class="fas fa-clock"></i> Arizalar qabul qilish muddati tugagan
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function openApplyModal() {
            document.getElementById('applyModal').classList.add('active');
        }

        function closeApplyModal() {
            document.getElementById('applyModal').classList.remove('active');
        }

        function submitApplyForm() {
            document.getElementById('apply-form').submit();
        }
    </script>
@endsection
