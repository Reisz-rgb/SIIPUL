@extends('layouts.app')

@section('title', 'Dashboard')

@section('header')
<div class="md:flex md:items-center md:justify-between">
    <div class="min-w-0 flex-1">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
            Dashboard
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            Selamat datang kembali, <span class="font-semibold">John Doe</span>
        </p>
    </div>
    <div class="mt-4 flex md:ml-4 md:mt-0">
        <a href="{{ route('cuti.create') }}">
            <x-button variant="primary" size="md">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Ajukan Cuti
            </x-button>
        </a>
    </div>
</div>
@endsection

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-6">
    <x-card>
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-primary-100">
                    <svg class="w-6 h-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                </div>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">Total Jatah Cuti</dt>
                    <dd class="flex items-baseline">
                        <div class="text-2xl font-semibold text-gray-900">12 Hari</div>
                    </dd>
                </dl>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-success-100">
                    <svg class="w-6 h-6 text-success-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">Cuti Terpakai</dt>
                    <dd class="flex items-baseline">
                        <div class="text-2xl font-semibold text-gray-900">5 Hari</div>
                    </dd>
                </dl>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-warning-100">
                    <svg class="w-6 h-6 text-warning-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">Sisa Cuti</dt>
                    <dd class="flex items-baseline">
                        <div class="text-2xl font-semibold text-gray-900">7 Hari</div>
                    </dd>
                </dl>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-info-100">
                    <svg class="w-6 h-6 text-info-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">Menunggu Persetujuan</dt>
                    <dd class="flex items-baseline">
                        <div class="text-2xl font-semibold text-gray-900">2 Pengajuan</div>
                    </dd>
                </dl>
            </div>
        </div>
    </x-card>
</div>

<!-- Table with Action Buttons -->
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2">
        <x-card title="Pengajuan Cuti Terbaru">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jenis Cuti
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Durasi
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                20 Jan - 22 Jan 2026
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Cuti Tahunan
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                3 Hari
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge type="warning">Pending</x-badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-2">
                                    <button onclick="lihatDetail('CT-2026-001')" class="inline-flex items-center px-3 py-1.5 bg-primary-50 text-primary-700 rounded-md hover:bg-primary-100 transition-colors text-xs font-medium">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Lihat Detail
                                    </button>
                                    <button onclick="eksporSurat('CT-2026-001')" class="inline-flex items-center px-3 py-1.5 bg-success-50 text-success-700 rounded-md hover:bg-success-100 transition-colors text-xs font-medium">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                        Ekspor Surat
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                10 Jan - 12 Jan 2026
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Cuti Sakit
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                3 Hari
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge type="success">Disetujui</x-badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-2">
                                    <button onclick="lihatDetail('CT-2026-002')" class="inline-flex items-center px-3 py-1.5 bg-primary-50 text-primary-700 rounded-md hover:bg-primary-100 transition-colors text-xs font-medium">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Lihat Detail
                                    </button>
                                    <button onclick="eksporSurat('CT-2026-002')" class="inline-flex items-center px-3 py-1.5 bg-success-50 text-success-700 rounded-md hover:bg-success-100 transition-colors text-xs font-medium">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                        Ekspor Surat
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                25 Des - 27 Des 2025
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Cuti Tahunan
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                3 Hari
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge type="success">Disetujui</x-badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-2">
                                    <button onclick="lihatDetail('CT-2025-015')" class="inline-flex items-center px-3 py-1.5 bg-primary-50 text-primary-700 rounded-md hover:bg-primary-100 transition-colors text-xs font-medium">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Lihat Detail
                                    </button>
                                    <button onclick="eksporSurat('CT-2025-015')" class="inline-flex items-center px-3 py-1.5 bg-success-50 text-success-700 rounded-md hover:bg-success-100 transition-colors text-xs font-medium">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                        Ekspor Surat
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                <a href="{{ route('cuti.riwayat') }}" class="text-sm font-medium text-primary-600 hover:text-primary-700">
                    Lihat semua riwayat →
                </a>
            </div>
        </x-card>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <x-card title="Kalender Januari 2026">
            <div class="text-center">
                <div class="grid grid-cols-7 gap-1 mb-2">
                    <div class="text-xs font-medium text-gray-500">Min</div>
                    <div class="text-xs font-medium text-gray-500">Sen</div>
                    <div class="text-xs font-medium text-gray-500">Sel</div>
                    <div class="text-xs font-medium text-gray-500">Rab</div>
                    <div class="text-xs font-medium text-gray-500">Kam</div>
                    <div class="text-xs font-medium text-gray-500">Jum</div>
                    <div class="text-xs font-medium text-gray-500">Sab</div>
                </div>
                <div class="grid grid-cols-7 gap-1">
                    @for($i = 1; $i <= 31; $i++)
                        <button class="aspect-square flex items-center justify-center text-sm rounded-md hover:bg-gray-100 {{ $i == 9 ? 'bg-primary-600 text-white hover:bg-primary-700' : 'text-gray-700' }}">
                            {{ $i }}
                        </button>
                    @endfor
                </div>
            </div>
        </x-card>

        <x-card title="Aksi Cepat">
            <div class="space-y-3">
                <a href="{{ route('cuti.create') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors border border-gray-200">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary-100">
                            <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Ajukan Cuti Baru</p>
                        <p class="text-xs text-gray-500">Buat pengajuan cuti</p>
                    </div>
                </a>

                <a href="{{ route('cuti.riwayat') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors border border-gray-200">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-success-100">
                            <svg class="w-5 h-5 text-success-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Riwayat Cuti</p>
                        <p class="text-xs text-gray-500">Lihat semua pengajuan</p>
                    </div>
                </a>

                <a href="{{ route('profile') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors border border-gray-200">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-info-100">
                            <svg class="w-5 h-5 text-info-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Profil Pegawai</p>
                        <p class="text-xs text-gray-500">Lihat dan edit profil</p>
                    </div>
                </a>
            </div>
        </x-card>
    </div>
</div>

@push('scripts')
<script>
    function lihatDetail(noCuti) {
        alert('Melihat detail untuk: ' + noCuti);
        // TODO: Implement redirect ke halaman detail
        // window.location.href = '/dashboard/cuti/detail/' + noCuti;
    }
    
    function eksporSurat(noCuti) {
        alert('Mengekspor surat untuk: ' + noCuti);
        // TODO: Implement download PDF
        // window.location.href = '/dashboard/cuti/ekspor/' + noCuti;
    }
</script>
@endpush
@endsection