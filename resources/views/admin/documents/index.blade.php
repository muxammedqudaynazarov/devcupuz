@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">

        <div class="page-header"
             style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <div class="header-info">
                <h1 style="font-size: 1.5rem; margin-bottom: 5px;">📄 Fayllar ro‘yxati</h1>
                <p style="color: var(--text-muted); font-size: 0.9rem;">
                    Tizimni ishlashiga va turnirlar o‘tkazilishiga asos bo‘luvchi PDF formatidagi ilovalar
                </p>
            </div>
            <a href="{{ route('documents.create') }}" class="btn-create" style="text-decoration: none;">
                <i class="fas fa-plus"></i> Yangi fayl
            </a>
        </div>

        <div class="table-container">
            <table class="admin-table" style="text-align: center; vertical-align: middle;">
                <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 10%;">Muqova</th>
                    <th style="text-align: left;">Fayl nomi</th>
                    <th>Fayl</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($documents as $document)
                    <tr style="transition: all 0.3s ease;">
                        <td style="font-family: 'Fira Code', monospace; font-weight: 600; color: var(--text-muted);">
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            @if($document->splash)
                                <img src="{{ asset('storage/' . $document->splash) }}"
                                     alt="Muqova"
                                     style="width: 55px; height: 75px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border-light); box-shadow: 0 4px 12px rgba(0,0,0,0.15); transition: 0.3s;"
                                     onmouseover="this.style.transform='scale(1.1)'"
                                     onmouseout="this.style.transform='scale(1)'">
                            @else
                                <div
                                    style="width: 55px; height: 75px; background: rgba(15, 23, 42, 0.5); border: 1px dashed var(--border-light); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); margin: 0 auto;">
                                    <i class="fas fa-file-pdf" style="font-size: 1.5rem;"></i>
                                </div>
                            @endif
                        </td>
                        <td style="text-align: left; font-weight: 500;">
                            <div style="font-size: 1.05rem; color: var(--text-color); margin-bottom: 6px;">
                                {{ $document->name }}
                            </div>
                        </td>
                        <td>
                            <a href="{{ asset('storage/' . $document->file) }}" target="_blank" class="btn-confirm"
                               title="PDF ni ochish" style="font-size: 0.8rem; text-decoration: none">
                                <i class="fas fa-external-link-alt"></i> Fayni ko‘rish
                            </a>
                        </td>
                        <td>
                            <label class="switch">
                                <input type="checkbox"
                                       onchange="toggleStatus('{{ route('documents.update', $document->id) }}', this)"
                                    {{ $document->status ? 'checked' : '' }}>
                                <span class="slider status-slider"></span>
                            </label>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 60px; color: var(--text-muted);">
                            <div
                                style="width: 80px; height: 80px; background: rgba(255,255,255,0.02); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto;">
                                <i class="fas fa-folder-open" style="font-size: 2.5rem; opacity: 0.5;"></i>
                            </div>
                            <h3 style="font-weight: 500; margin-bottom: 5px;">
                                Fayllar ro‘yxati bo‘sh
                            </h3>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper" style="margin-top: 25px;">
            {{ $documents->links() }}
        </div>
    </div>
@endsection

@section('script')
    <script>
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

        function toggleStatus(url, checkbox) {
            if (!csrfToken) {
                alert("CSRF Token topilmadi. Iltimos sahifani yangilab qayta urinib ko‘ring.");
                return;
            }

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    _method: 'PATCH',
                    is_ajax: true
                })
            }).then(async response => {
                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    throw new Error(errorData.message || 'Serverda xatolik yuz berdi');
                }
                return response.json();
            }).then(data => {
                if (typeof showToast === 'function') {
                    showToast('success', 'Muvaffaqiyatli o‘zgartirildi!');
                }
            }).catch(error => {
                console.error("Fetch xatosi:", error);
                if (typeof showToast === 'function') {
                    showToast('error', 'Holatni o‘zgartirib bo‘lmadi!');
                } else {
                    alert("Xatolik yuz berdi!");
                }
            }).finally(() => {
                checkbox.disabled = false;
            });
        }
    </script>
@endsection
