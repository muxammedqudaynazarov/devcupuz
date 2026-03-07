@extends('layouts.app')
@section('content')
    <div class="content-body">
        <div class="section-header">
            <div>
                <h2>Turnir Reytingi</h2>
                <p style="color: #94a3b8; font-size: 0.9rem;">10 haftalik marafonning umumiy natijalari</p>
            </div>
            <div class="last-update">
                <span style="font-size: 0.8rem; color: var(--accent-green);">● Live</span>
                <span style="font-size: 0.8rem; color: #94a3b8; margin-left: 5px;">Oxirgi yangilanish: hozirgina</span>
            </div>
        </div>

        <div class="podium-container">
            <div class="podium-item silver">
                <div class="podium-avatar">
                    <img src="https://i.pravatar.cc/150?u=2" alt="Silver">
                    <div class="rank-badge">2</div>
                </div>
                <div class="podium-info">
                    <h4>Ibragimova M.</h4>
                    <p>142 ball</p>
                    <span class="uni-tag">TATU</span>
                </div>
            </div>

            <div class="podium-item gold">
                <div class="crown">👑</div>
                <div class="podium-avatar">
                    <img src="https://i.pravatar.cc/150?u=1" alt="Gold">
                    <div class="rank-badge">1</div>
                </div>
                <div class="podium-info">
                    <h4>Asadov Dilshod</h4>
                    <p>158 ball</p>
                    <span class="uni-tag">KarSU</span>
                </div>
            </div>

            <div class="podium-item bronze">
                <div class="podium-avatar">
                    <img src="https://i.pravatar.cc/150?u=3" alt="Bronze">
                    <div class="rank-badge">3</div>
                </div>
                <div class="podium-info">
                    <h4>Rustamov A.</h4>
                    <p>135 ball</p>
                    <span class="uni-tag">NMU</span>
                </div>
            </div>
        </div>

        <div class="leaderboard-card">
            <table>
                <thead>
                <tr>
                    <th>O'rin</th>
                    <th>Ishtirokchi</th>
                    <th>Universitet</th>
                    <th>Haftalik Progress</th>
                    <th>Jami Ball</th>
                </tr>
                </thead>
                <tbody>
                @foreach(range(4, 10) as $rank)
                    <tr class="{{ $rank == 7 ? 'active-user-row' : '' }}">
                        <td class="rank">#{{ $rank }}</td>
                        <td class="user-info">
                            <span class="name">Talaba Ismi {{ $rank }}</span>
                            <span class="sub-text">Dasturiy injiniring</span>
                        </td>
                        <td><span class="uni-name">TATU</span></td>
                        <td>
                            <div class="progress-mini">
                                <div class="progress-bar" style="width: {{ 100 - ($rank * 5) }}%"></div>
                            </div>
                        </td>
                        <td class="total-score">{{ 130 - ($rank * 2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
