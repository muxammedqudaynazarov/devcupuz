@extends('layouts.app')

@section('style')
    <style>
        /* Admin jadvali dizayni */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            background: #1e293b;
            border-radius: 8px;
            overflow: hidden;
            color: #f1f5f9;
        }

        .admin-table th {
            background: #0f172a;
            padding: 15px;
            text-align: left;
            font-size: 0.9rem;
            color: #94a3b8;
        }

        .admin-table td {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            vertical-align: middle;
        }

        /* Zamonaviy Toggle Switch dizayni */
        .switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #334155;
            transition: .3s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }

        /* Status (Holat) faol bo'lsa Yashil rang */
        input:checked + .slider.status-slider {
            background-color: #4ade80;
        }

        input:checked + .slider.status-slider:before {
            transform: translateX(20px);
        }

        /* Default (Standart) faol bo'lsa Ko'k rang */
        input:checked + .slider.default-slider {
            background-color: #38bdf8;
        }

        input:checked + .slider.default-slider:before {
            transform: translateX(20px);
        }

        .switch-disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header" style="margin-bottom: 20px;">
            <h2><i class="fas fa-code"></i> Dasturlash tillari</h2>
            <p style="color: #94a3b8; font-size: 0.9rem;">Tizimdagi barcha tillarni boshqarish</p>
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
                    <td style="color: #64748b; font-weight: bold;">{{ $program->id }}</td>
                    <td style="font-weight: 500; text-align: left">{{ $program->name }}</td>

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
            {{ $programs->links() }}
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
                    if (field === 'default' && newValue === '1') {
                        document.querySelectorAll('input[onchange*="\'default\'"]').forEach(cb => {
                            if (cb !== checkbox) cb.checked = false;
                        });
                    }
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
