@props(['variant' => 'primary', 'size' => 'md'])
@php
    $variants = ['primary' => 'bg-primary-600 text-white hover:bg-primary-700', 'outline' => 'border border-slate-200 text-slate-600 hover:bg-slate-50'];
    $sizes = ['sm' => 'px-3 py-1.5 text-xs', 'md' => 'px-4 py-2 text-sm', 'lg' => 'px-6 py-3 text-base'];
@endphp
<button {{ $attributes->merge(['class' => "inline-flex items-center justify-center font-semibold rounded-lg transition-all " . $variants[$variant] . " " . $sizes[$size]]) }}>
    {{ $slot }}
</button>