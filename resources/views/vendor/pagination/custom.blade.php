@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" style="display: flex; justify-content: center; gap: 8px;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span style="padding: 8px 16px; border: 1px solid #e5e7eb; border-radius: 8px; color: #9ca3af; cursor: not-allowed;">
                <i class="fa-solid fa-chevron-left"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="padding: 8px 16px; border: 1px solid #e5e7eb; border-radius: 8px; color: #374151; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='white'">
                <i class="fa-solid fa-chevron-left"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span style="padding: 8px 16px;">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="padding: 8px 16px; background: #8b1515; color: white; border-radius: 8px; font-weight: 600;">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" style="padding: 8px 16px; border: 1px solid #e5e7eb; border-radius: 8px; color: #374151; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='white'">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="padding: 8px 16px; border: 1px solid #e5e7eb; border-radius: 8px; color: #374151; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='white'">
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        @else
            <span style="padding: 8px 16px; border: 1px solid #e5e7eb; border-radius: 8px; color: #9ca3af; cursor: not-allowed;">
                <i class="fa-solid fa-chevron-right"></i>
            </span>
        @endif
    </nav>
@endif