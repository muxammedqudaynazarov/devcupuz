@forelse($submissions as $sub)
    <tr>
        <td class="fw-bold text-muted"
            style="text-align: center; font-family: 'Fira Code', monospace; font-size: 0.85rem; padding: 2em">
            #{{ substr($sub->uuid, -5) }}
        </td>

        <td style="text-align: start">
            <a href="{{ route('user.show', $sub->user->username) }}"
               style="font-weight: bold; color: var(--text-color); text-decoration: none">
                {{ $sub->user->name['full'] }}
            </a>
            <div style="font-size: x-small; color: #94a3b8; margin-top: 4px;">
                {{ $sub->user->university->name }}
            </div>
        </td>

        <td>
            <a href="{{ route('problems.show', $sub->problem_id) }}"
               style="color: #38bdf8; text-decoration: none; font-weight: 500;">
                #M{{ sprintf('%04d', $sub->problem->id) }}
            </a>
        </td>
        <td class="text-muted" style="font-size: small">
            {{ $sub->program->name ?? '-' }}
        </td>
        <td class="text-muted" style="font-size: small">
            @if($sub->status == '2')
                <span class="time-val">{{ $sub->time }}s / {{ $sub->memory }}mb</span>
            @else
                <span class="time-val text-muted">- / -</span>
            @endif
        </td>

        <td class="text-muted" style="font-size: small">
            {{ Str::limit($sub->message, 25) }}
        </td>

        <td class="text-muted" style="font-size: 0.85rem;">
            {{ $sub->created_at->format('d.m.Y H:i') }}
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center fw-bold text-muted" style="text-align: center; padding: 40px;">
            Hozircha urinishlar mavjud emas
        </td>
    </tr>
@endforelse
