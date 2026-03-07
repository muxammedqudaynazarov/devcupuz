@forelse($submissions as $sub)
    <tr>
        <td class="uuid-text">#{{ $sub->uuid }}</td>

        <td>
            <div class="primary-text">{{ $sub->user->name ?? 'Noma\'lum' }}</div>
            <div class="secondary-text">{{ $sub->user->login ?? '' }}</div>
        </td>

        <td>
            <a href="{{ route('problems.show', $sub->problem_id) }}"
               style="color: #e2e8f0; text-decoration: none; font-weight: 500; transition: 0.3s;"
               onmouseover="this.style.color='#38bdf8'" onmouseout="this.style.color='#e2e8f0'">
                {{ $sub->problem->name ?? 'O\'chirilgan masala' }}
            </a>
            <div class="secondary-text" style="color: #64748b;">{{ $sub->created_at->format('d.m.Y H:i:s') }}</div>
        </td>

        <td>
            <span style="background: rgba(255,255,255,0.05); padding: 4px 10px; border-radius: 6px; font-size: 0.8rem; border: 1px solid rgba(255,255,255,0.05);">
                {{ $sub->program->name ?? 'Noma\'lum' }}
            </span>
        </td>

        <td>
            @if($sub->status == '2')
                <div class="secondary-text"><i class="fas fa-clock" style="color: #94a3b8; margin-right: 5px;"></i> {{ $sub->time }}s</div>
                <div class="secondary-text"><i class="fas fa-memory" style="color: #94a3b8; margin-right: 5px;"></i> {{ $sub->memory }}MB</div>
            @else
                <div class="secondary-text">-</div>
            @endif
        </td>

        <td>
            @if($sub->status == '2')
                <span class="status-badge status-success"><i class="fas fa-check-circle"></i> {{ $sub->message ?? 'Accepted' }}</span>
            @elseif($sub->status == '3' || $sub->status == '4')
                <span class="status-badge status-error"><i class="fas fa-times-circle"></i> {{ Str::limit($sub->message, 22) }}</span>
            @else
                <span class="status-badge status-pending"><i class="fas fa-spinner fa-spin"></i> Tekshirilmoqda</span>
            @endif
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" style="text-align: center; padding: 50px 20px;">
            <i class="fas fa-terminal" style="font-size: 2.5rem; color: rgba(255,255,255,0.1); margin-bottom: 15px;"></i>
            <div style="color: #64748b; font-size: 1rem;">Hozircha hech qanday urinishlar mavjud emas.</div>
        </td>
    </tr>
@endforelse
