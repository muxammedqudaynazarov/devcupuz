@extends('layouts.app') {{-- Yoki layouts.welcome --}}

@section('title', 'Hisob bloklangan')

@section('content')
    <div style="display: flex; justify-content: center; align-items: center; min-height: 80vh; padding: 20px;">
        <div
            style="max-width: 500px; width: 100%; background: var(--card-bg, #1e293b); border: 1px solid var(--border-light, rgba(255,255,255,0.1)); border-radius: 20px; padding: 40px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">

            <div
                style="width: 100px; height: 100px; background: rgba(248, 113, 113, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px auto; border: 2px solid #f87171; box-shadow: 0 0 20px rgba(248, 113, 113, 0.2);">
                <i class="fas fa-user-slash" style="font-size: 3rem; color: #f87171;"></i>
            </div>

            <h1 style="color: #f1f5f9; font-size: 1.8rem; margin-bottom: 15px; font-weight: 700;">Hisobingiz
                bloklandi</h1>

            <p style="color: var(--text-muted, #94a3b8); line-height: 1.6; margin-bottom: 30px;">
                Hurmatli <strong>{{ auth()->user()->name['short'] ?? auth()->user()->username }}</strong>,
                sizning hisobingiz tizim qoidalarini buzganingiz yoki ma’muriyat qaroriga ko‘ra cheklangan.
                Hozirda siz uchun tizimning barcha imkoniyatlari yopiq.
            </p>

            <div style="display: flex; flex-direction: column; gap: 15px;">
                <a href="https://t.me/allambergenkalbayev" target="_blank" class="btn-create"
                   style="text-decoration: none; justify-content: center; background: #38bdf8; border: none;">
                    <i class="fab fa-telegram-plane"></i> Ma’muriyat bilan bog‘lanish
                </a>

                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit"
                            style="background: transparent; border: 1px solid var(--border-light); color: var(--text-muted); padding: 10px; border-radius: 10px; cursor: pointer; width: 100%; transition: 0.3s;">
                        <i class="fas fa-sign-out-alt"></i> Chiqish
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
