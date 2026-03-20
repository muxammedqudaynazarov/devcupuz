@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="page-header" style="margin-bottom: 25px;">
            <div class="header-info">
                <h1>Foydalanuvchini tahrirlash</h1>
                <p>Ma’lumotlarni, lavozimni va ruxsat etilgan rollarni o‘zgartirish</p>
            </div>
        </div>
        @php
            $userRoles = is_string($user->rol) ? json_decode($user->rol, true) : ($user->rol ?? []);
            $userRolesArray = array_map(function($r) { return is_object($r) ? $r->name : $r; }, $userRoles ?: []);
        @endphp
        <div class="table-container" style="padding: 30px;">
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 25px;">
                    <div class="form-group">
                        <label>To‘liq ism-sharifi (Full Name)</label>
                        <input type="text" name="name[full]" class="search-input" style="width: 100%;"
                               value="{{ old('name.full', $user->name['full'] ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Qisqa ismi</label>
                        <input type="text" name="name[short]" class="search-input" style="width: 100%;"
                               value="{{ old('name.short', $user->name['short'] ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Foydalanuvchi nomi (username)</label>
                        <input type="text" name="username" class="search-input" style="width: 100%;"
                               value="{{ old('username', $user->username) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Yangi parol (o‘zgartirish uchun)</label>
                        <input type="text" name="password" class="search-input" style="width: 100%;"
                               placeholder="O‘zgartirmaslik uchun bo‘sh qoldiring">
                    </div>
                    <div class="form-group">
                        <label>Telefon raqami</label>
                        <input type="text" name="phone" class="search-input" style="width: 100%;"
                               value="{{ old('phone', $user->phone) }}" placeholder="+998901234567">
                    </div>
                    <div class="form-group">
                        <label>Foydalanuvchi blok qilinsinmi?</label>
                        <label
                            style="display: flex; align-items: center; gap: 10px; background: rgba(15, 23, 42, 0.4); padding: 10px 15px; border-radius: 8px; border: 1px solid var(--border-light); cursor: pointer; transition: 0.3s;">
                            <input type="checkbox" name="blocked" value="1" {{ $user->status == '3' ? 'checked' : '' }}
                            style="width: 18px; height: 18px; accent-color: var(--primary-neon);">
                            <div style="color: var(--text-color); font-weight: 500;">
                                Ha
                            </div>
                        </label>
                    </div>
                </div>
                <div class="form-group" style="border-top: 1px solid var(--border-light); padding-top: 20px;">
                    <label>
                        Foydalanuvchiga qo‘shimcha rollarni biriktirish
                    </label>
                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
                        @foreach($roles as $role)
                            <label
                                style="display: flex; align-items: center; gap: 10px; background: rgba(15, 23, 42, 0.4); padding: 10px 15px; border-radius: 8px; border: 1px solid var(--border-light); cursor: pointer; transition: 0.3s;"
                                onmouseover="this.style.borderColor='var(--primary-neon)'"
                                onmouseout="this.style.borderColor='var(--border-light)'">
                                <input type="checkbox" name="rol[]" value="{{ $role->name }}"
                                       {{ in_array($role->name, $userRolesArray) ? 'checked' : '' }}
                                       style="width: 18px; height: 18px; accent-color: var(--primary-neon);">
                                <span
                                    style="color: var(--text-color); font-weight: 500;">{{ ucfirst($role->name) }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="form-actions" style="margin-top: 35px; text-align: right;">
                    <button type="submit" class="btn-create">
                        <i class="fas fa-save"></i> O‘zgarishlarni saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
