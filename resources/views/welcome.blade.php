@extends('layouts.landing')

@section('content')
<main class="max-w-7xl mx-auto px-8 py-20 lg:py-32">
    <div class="grid lg:grid-cols-2 gap-12 items-center">
        <div>
            <span class="inline-block px-4 py-1.5 bg-primary-50 text-primary-600 rounded-full text-sm font-bold mb-6">
                Sistem Informasi Cuti Terpadu
            </span>
            <h1 class="text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight mb-6">
                Kelola Cuti Pegawai <br>
                <span class="text-primary-600">Lebih Mudah & Cepat</span>
            </h1>
            <p class="text-lg text-slate-600 mb-10 leading-relaxed">
                Platform modern untuk pengajuan, persetujuan, dan pelacakan riwayat cuti pegawai secara real-time. Efisienkan manajemen SDM Anda mulai hari ini.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('login') }}">
                    <x-button size="lg" class="w-full sm:w-auto px-8 py-4 shadow-xl shadow-primary-200">
                        Mulai Sekarang
                    </x-button>
                </a>
                <a href="#fitur">
                    <x-button variant="outline" size="lg" class="w-full sm:w-auto px-8 py-4">
                        Lihat Fitur
                    </x-button>
                </a>
            </div>
        </div>
        
        <div class="relative">
            <div class="absolute inset-0 bg-primary-600 rounded-3xl rotate-3 opacity-10"></div>
            <div class="relative bg-white border border-slate-200 rounded-3xl shadow-2xl overflow-hidden p-2">
                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=1000" alt="Dashboard Preview" class="rounded-2xl">
            </div>
        </div>
    </div>
</main>
@endsection