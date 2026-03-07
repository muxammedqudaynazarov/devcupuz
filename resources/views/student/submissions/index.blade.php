@extends('layouts.app')
@section('style')
    <style>
        table thead th {
            padding: 4em;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">

        <div class="page-header">
            <div class="header-info">
                <h1>🏆 Urinishlar tarixi</h1>
                <p>Barcha foydalanuvchilarning masalalarga yuborgan yechimlari</p>
            </div>
        </div>

        <div class="table-container">
            <table class="admin-table" style="text-align: center">
                <thead>
                <tr style="text-align: center">
                    <th style="width: 5%;padding: 2em;">#UUID</th>
                    <th style="text-align: start">Foydalanuvchi</th>
                    <th style="width: 12%;">Masala</th>
                    <th style="width: 12%;">Dastur tili</th>
                    <th style="width: 12%;">Vaqt / xotira</th>
                    <th style="width: 20%;">Holati</th>
                    <th style="width: 10%;">Sana</th>
                </tr>
                </thead>
                <tbody id="submissions-table">
                @include('student.submissions._rows')
                </tbody>
            </table>
            <div style="padding: 15px;">
                {{ $submissions->links('pagination.custom') }}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        setInterval(async () => {
            if (document.hidden) return;
            try {
                let res = await fetch(window.location.href, {
                    headers: {'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'}
                });
                if (res.ok) {
                    let data = await res.json();
                    let tbody = document.getElementById('submissions-table');
                    if (tbody && data.html) {
                        tbody.innerHTML = data.html;
                        let timeString = new Date().toLocaleTimeString('uz-UZ', {
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit'
                        });
                        document.getElementById('last-update').innerText = timeString + ' da yangilandi';
                    }
                }
            } catch (e) {
                console.error("Yangilash xatosi", e);
            }
        }, 10000);
    </script>
@endsection
