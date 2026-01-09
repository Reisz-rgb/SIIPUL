@props(['title' => null])
<div class="bg-white rounded-xl border border-slate-200 shadow-sm">
    @if($title) <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-semibold text-slate-800">{{ $title }}</h3></div> @endif
    <div class="p-6">{{ $slot }}</div>
</div>