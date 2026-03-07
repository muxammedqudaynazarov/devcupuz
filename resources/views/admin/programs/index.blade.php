@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="page-header" style="margin-bottom: 20px;">
            <h2><i class="fas fa-code"></i> Dasturlash tillari</h2>
        </div>

        <table class="admin-table" style="text-align: center">
            <thead>
            <tr>
                <th style="width: 7%;">#</th>
                <th style="text-align: left">Til nomi</th>
                <th style="width: 15%; text-align: center;">Default</th>
                <th style="width: 15%; text-align: center;">Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($programs as $program)
                <tr>
                    <td style="color: #64748b; font-size: small">{{ $program->id }}</td>
                    <td style="font-weight: 100; text-align: left; font-size: small">{{ $program->name }}</td>

                    <td style="text-align: center;">
                        <label class="switch">
                            <input type="checkbox"
                                   onchange="updateProgram({{ $program->id }}, 'default', this)"
                                {{ $program->default == '1' ? 'checked' : '' }}>
                            <span class="slider default-slider"></span>
                        </label>
                    </td>

                    <td style="text-align: center;">
                        <label class="switch">
                            <input type="checkbox"
                                   onchange="updateProgram({{ $program->id }}, 'status', this)"
                                {{ $program->status == '1' ? 'checked' : '' }}>
                            <span class="slider status-slider"></span>
                        </label>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $programs->links('pagination.custom') }}
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        async function updateProgram(programId, field, checkbox) {
            const newValue = checkbox.checked ? '1' : '0';
            checkbox.disabled = true;
            checkbox.nextElementSibling.classList.add('switch-disabled');
            try {
                const response = await fetch(`/admin/programs/${programId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        field: field,
                        value: newValue
                    })
                });
                const result = await response.json();
                if (response.ok) {
                    const Toast = Swal.mixin({
                        toast: true, position: 'top-end', showConfirmButton: false, timer: 2000,
                        background: '#1e293b', color: '#f1f5f9'
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Muvaffaqiyatli saqlandi!'
                    });
                } else {
                    throw new Error(result.message || "Xatolik yuz berdi");
                }
            } catch (error) {
                console.error(error);
                checkbox.checked = !checkbox.checked;
                Swal.fire({
                    icon: 'error', title: 'Xatolik!', text: 'Ma\'lumotni saqlashda xato yuz berdi.',
                    background: '#1e293b', color: '#f1f5f9'
                });
            } finally {
                checkbox.disabled = false;
                checkbox.nextElementSibling.classList.remove('switch-disabled');
            }
        }
    </script>
@endsection
