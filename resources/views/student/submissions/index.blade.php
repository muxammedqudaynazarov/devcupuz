@extends('layouts.app')

@section('title', 'Urinishlar tarixi | DevCup')

@push('styles')
    <style>
        .clean-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            font-family: 'Poppins', sans-serif;
        }

        .clean-header {
            font-size: 1.25rem;
            font-weight: 600;
            color: #f8fafc;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .last-update {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 400;
        }

        .clean-table-wrapper {
            background: #1e293b;
            border-radius: 8px;
            border: 1px solid #334155;
            overflow: hidden;
        }

        .clean-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .clean-table th {
            background: #0f172a;
            color: #94a3b8;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 14px 20px;
            border-bottom: 1px solid #334155;
        }

        .clean-table td {
            padding: 14px 20px;
            color: #cbd5e1;
            font-size: 0.9rem;
            border-bottom: 1px solid #334155;
        }

        .clean-table tr:last-child td {
            border-bottom: none;
        }

        .clean-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        .code-font {
            font-family: 'Fira Code', monospace;
            font-size: 0.85rem;
        }

        .text-muted {
            color: #64748b;
            font-size: 0.85rem;
        }

        /* Oddiy va aniq badgelar */
        .badge-simple {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-block;
        }

        .bg-green { background: rgba(16, 185, 129, 0.1); color: #10b981; }
        .bg-red { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
        .bg-yellow { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    </style>
@endpush

@section('content')
    <div class="clean-container">
        <div class="clean-header">
            <div><i class="fas fa-history" style="color: #64748b; margin-right: 8px;"></i> Barcha urinishlar</div>
            <div class="last-update" id="last-update">Hozirgina yangilandi</div>
        </div>

        <div class="clean-table-wrapper">
            <table class="clean-table">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th>Foydalanuvchi</th>
                    <th>Masala</th>
                    <th>Til</th>
                    <th>Vaqt / Xotira</th>
                    <th>Holati</th>
                </tr>
                </thead>
                <tbody id="submissions-table">
                @include('student.submissions._rows')
                </tbody>
            </table>
        </div>

        <div class="mt-4" style="display: flex; justify-content: flex-end;">
            {{ $submissions->links('pagination.custom') }}
        </div>
    </div>
@endsection

@section('script')
    <script>
        setInterval(async () => {
            if (document.hidden) return;
            try {
                let res = await fetch(window.location.href, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                if (res.ok) {
                    let data = await res.json();
                    let tableBody = document.getElementById('submissions-table');
                    if (tableBody && data.html) {
                        tableBody.innerHTML = data.html;
                        let timeString = new Date().toLocaleTimeString('uz-UZ', { hour: '2-digit', minute: '2-digit', second:'2-digit' });
                        document.getElementById('last-update').innerText = `${timeString} da yangilandi`;
                    }
                }
            } catch (e) {
                console.error(e);
            }
        }, 10000);
    </script>
@endsection
