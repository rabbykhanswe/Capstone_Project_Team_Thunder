@if ($paginator->hasPages())
<nav role="navigation" style="display:flex;align-items:center;justify-content:space-between;gap:12px;">
    <p style="font-size:13px;color:#64748b;margin:0;">
        Showing <strong>{{ $paginator->firstItem() }}</strong> to <strong>{{ $paginator->lastItem() }}</strong> of <strong>{{ $paginator->total() }}</strong>
    </p>
    <div style="display:flex;align-items:center;gap:6px;">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 14px;height:32px;background:#f8fafc;color:#94a3b8;border:1.5px solid #e2e8f0;border-radius:6px;font-size:13px;font-weight:600;cursor:not-allowed;">
                <i class="fas fa-chevron-left" style="font-size:11px;"></i> Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="display:inline-flex;align-items:center;gap:5px;padding:6px 14px;height:32px;background:#fff;color:#1a2e1e;border:1.5px solid #e2e8f0;border-radius:6px;font-size:13px;font-weight:600;text-decoration:none;transition:all .15s;" onmouseover="this.style.background='#f0fdf4';this.style.borderColor='#16a34a';this.style.color='#16a34a'" onmouseout="this.style.background='#fff';this.style.borderColor='#e2e8f0';this.style.color='#1a2e1e'">
                <i class="fas fa-chevron-left" style="font-size:11px;"></i> Previous
            </a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span style="display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:32px;padding:0 6px;font-size:13px;color:#94a3b8;">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:32px;padding:0 8px;background:#16a34a;color:#fff;border-radius:6px;font-size:13px;font-weight:700;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:32px;padding:0 8px;background:#fff;color:#1a2e1e;border:1.5px solid #e2e8f0;border-radius:6px;font-size:13px;font-weight:600;text-decoration:none;transition:all .15s;" onmouseover="this.style.background='#f0fdf4';this.style.borderColor='#16a34a';this.style.color='#16a34a'" onmouseout="this.style.background='#fff';this.style.borderColor='#e2e8f0';this.style.color='#1a2e1e'">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="display:inline-flex;align-items:center;gap:5px;padding:6px 14px;height:32px;background:#fff;color:#1a2e1e;border:1.5px solid #e2e8f0;border-radius:6px;font-size:13px;font-weight:600;text-decoration:none;transition:all .15s;" onmouseover="this.style.background='#f0fdf4';this.style.borderColor='#16a34a';this.style.color='#16a34a'" onmouseout="this.style.background='#fff';this.style.borderColor='#e2e8f0';this.style.color='#1a2e1e'">
                Next <i class="fas fa-chevron-right" style="font-size:11px;"></i>
            </a>
        @else
            <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 14px;height:32px;background:#f8fafc;color:#94a3b8;border:1.5px solid #e2e8f0;border-radius:6px;font-size:13px;font-weight:600;cursor:not-allowed;">
                Next <i class="fas fa-chevron-right" style="font-size:11px;"></i>
            </span>
        @endif
    </div>
</nav>
@endif
