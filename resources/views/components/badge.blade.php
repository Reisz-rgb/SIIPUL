@props(['type' => 'info'])
@php
    $colors = [
        'warning' => 'bg-amber-50 text-amber-700 border-amber-100',
        'success' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
        'info' => 'bg-sky-50 text-sky-700 border-sky-100',
    ];
@endphp
<span class="px-2.5 py-1 rounded-md text-xs font-semibold border {{ $colors[$type] ?? $colors['info'] }}">
    {{ $slot }}
</span>