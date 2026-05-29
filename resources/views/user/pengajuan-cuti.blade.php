@extends('layouts.user')

@section('title', 'Ajukan Cuti')
@section('page_title', 'Pengajuan Cuti')
@section('page_subtitle', 'Lengkapi formulir berikut untuk mengajukan cuti.')

@section('content')
    @php($authUser = $user ?? auth()->user())

    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="rounded-2xl border border-red-200 bg-red-50 px-6 py-5">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white border border-red-200 flex items-center justify-center text-red-600">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-extrabold text-red-800">Periksa kembali input Anda</h4>
                        <ul class="list-disc list-inside text-sm text-red-700 mt-2 space-y-1 font-semibold">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('user.cuti.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- I. DATA PEGAWAI --}}
            <section class="bg-white rounded-3xl shadow-soft border border-slate-100 overflow-hidden">
                <div class="px-6 md:px-8 py-5 border-b border-slate-50 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-[var(--maroon)]">
                            <i class="bi bi-person-badge-fill"></i>
                        </div>
                        <div>
                            <h3 class="text-sm md:text-base font-extrabold text-slate-800">I. Data Pegawai</h3>
                            <p class="text-xs md:text-sm text-slate-500 font-medium">Data ini otomatis dari akun Anda.</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Wajib</span>
                </div>

                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="block text-xs font-extrabold text-slate-600 mb-2">Nama Lengkap</label>
                        <input type="text"
                               value="{{ $authUser->name }}"
                               readonly
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-700 font-semibold" />
                    </div>

                    {{-- NIP --}}
                    <div>
                        <label class="block text-xs font-extrabold text-slate-600 mb-2">NIP</label>
                        <input type="text"
                               value="{{ $authUser->nip }}"
                               readonly
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-700 font-semibold" />
                    </div>

                    {{-- Jabatan --}}
                    <div>
                        <label class="block text-xs font-extrabold text-slate-600 mb-2">Jabatan</label>
                        <input type="text"
                               value="{{ $authUser->jabatan ?? '-' }}"
                               readonly
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-700 font-semibold" />
                    </div>

                    {{-- Masa Kerja --}}
                    <div>
                        <label class="block text-xs font-extrabold text-slate-600 mb-2">Masa Kerja</label>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="flex items-center gap-2">
                                <input type="text"
                                       value="{{ floor($workYears ?? 0) }}"
                                       readonly
                                       class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-700 font-semibold" />
                                <span class="text-xs text-slate-500 font-bold">Tahun</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="text"
                                       value="{{ floor($workMonths ?? 0) }}"
                                       readonly
                                       class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-700 font-semibold" />
                                <span class="text-xs text-slate-500 font-bold">Bulan</span>
                            </div>
                        </div>
                    </div>

                    {{-- Unit Kerja --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-extrabold text-slate-600 mb-2">Unit Kerja</label>
                        <input type="text"
                               value="{{ $authUser->bidang_unit ?? 'DISDIKBUDPORA KABUPATEN SEMARANG' }}"
                               readonly
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-700 font-semibold" />
                    </div>

                </div>
            </section>

            {{-- II. ATASAN LANGSUNG --}}
            <section class="bg-white rounded-3xl shadow-soft border border-slate-100 overflow-hidden">
                <div class="px-6 md:px-8 py-5 border-b border-slate-50 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-[var(--maroon)]">
                            <i class="bi bi-person-check-fill"></i>
                        </div>
                        <div>
                            <h3 class="text-sm md:text-base font-extrabold text-slate-800">II. Atasan Langsung</h3>
                            <p class="text-xs md:text-sm text-slate-500 font-medium">Pilih atasan yang akan menyetujui cuti Anda.</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Wajib</span>
                </div>

                <div class="p-6 md:p-8 space-y-4">

                    {{-- Supervisor select --}}
                    <div>
                        <label class="block text-xs font-extrabold text-slate-600 mb-2">
                            Nama Atasan <span class="text-red-600">*</span>
                        </label>
                        <div class="relative">
                            <select name="supervisor_id"
                                    id="supervisor_select"
                                    required
                                    class="w-full appearance-none px-4 py-3 pr-10 rounded-2xl border
                                        {{ $errors->has('supervisor_id') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-white' }}
                                        text-slate-800 font-semibold focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-[var(--maroon)] cursor-pointer">
                                <option value="" disabled {{ old('supervisor_id') ? '' : 'selected' }}>
                                    — Pilih atasan langsung —
                                </option>
                                @foreach ($supervisors as $unitKerja => $group)
                                    <optgroup label="{{ $unitKerja }}">
                                        @foreach ($group as $supervisor)
                                            <option value="{{ $supervisor->id }}"
                                                    data-jabatan="{{ $supervisor->jabatan }}"
                                                    data-unit="{{ $supervisor->unit_kerja }}"
                                                    data-nip="{{ $supervisor->nip }}"
                                                    {{ old('supervisor_id') == $supervisor->id ? 'selected' : '' }}>
                                                {{ $supervisor->nama }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400">
                                <i class="bi bi-chevron-down text-sm"></i>
                            </div>
                        </div>
                        @error('supervisor_id')
                            <p class="text-xs text-red-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Checkbox PLT --}}
                    <label id="plt_checkbox_wrapper"
                        class="hidden items-center gap-3 cursor-pointer select-none w-fit">
                        <div class="relative">
                            <input type="checkbox" id="plt_checkbox" class="sr-only peer">
                            <div class="w-10 h-6 rounded-full bg-slate-200 peer-checked:bg-[var(--maroon)] transition-colors duration-200"></div>
                            <div class="absolute top-1 left-1 w-4 h-4 rounded-full bg-white shadow transition-transform duration-200 peer-checked:translate-x-4"></div>
                        </div>
                        <span class="text-xs font-extrabold text-slate-600">
                            Atasan berstatus <span class="text-[var(--maroon)]">PLT</span>
                            <span class="font-medium text-slate-400">(Pelaksana Tugas)</span>
                        </span>
                        <input type="hidden" name="plt_jabatan" id="plt_jabatan_value" value="">
                    </label>           

                    {{-- Info card: muncul setelah memilih atasan --}}
                    <div id="supervisor_info"
                        class="hidden rounded-2xl border border-slate-100 bg-slate-50/60 p-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-1">NIP</p>
                            <p id="info_nip" class="text-sm font-extrabold text-slate-700">—</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-1">Jabatan</p>
                            {{-- Mode normal: teks biasa --}}
                            <p id="info_jabatan" class="text-sm font-extrabold text-slate-700">—</p>
                            {{-- Mode PLT: input yang bisa diedit, tersembunyi saat tidak PLT --}}
                            <input id="info_jabatan_plt"
                                type="text"
                                placeholder="Tulis jabatan PLT..."
                                class="hidden w-full text-sm font-extrabold text-slate-700 bg-white border border-amber-300
                                        rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-200
                                        focus:border-amber-400 placeholder:font-medium placeholder:text-slate-400" />
                        </div>
                        <div>
                            <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-1">Unit Kerja</p>
                            <p id="info_unit" class="text-sm font-extrabold text-slate-700">—</p>
                        </div>
                    </div>

                    {{-- Badge peringatan PLT, muncul hanya saat PLT aktif --}}
                    <div id="plt_notice"
                        class="hidden rounded-2xl border border-amber-200 bg-amber-50/60 px-4 py-3 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-white border border-amber-200 flex items-center justify-center text-amber-500 flex-shrink-0">
                            <i class="bi bi-info-circle-fill text-sm"></i>
                        </div>
                        <p class="text-xs font-semibold text-amber-800">
                            Mode PLT aktif. Jabatan yang Anda isi hanya untuk keperluan tampilan —
                            data atasan di sistem tidak berubah.
                        </p>
                    </div>

                </div>
            </section>

            {{-- III. JENIS CUTI --}}
            <section class="bg-white rounded-3xl shadow-soft border border-slate-100 overflow-hidden">
                <div class="px-6 md:px-8 py-5 border-b border-slate-50 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-[var(--maroon)]">
                        <i class="bi bi-ui-radios"></i>
                    </div>
                    <div>
                        <h3 class="text-sm md:text-base font-extrabold text-slate-800">III. Jenis Cuti yang Diambil</h3>
                        <p class="text-xs md:text-sm text-slate-500 font-medium">Pilih salah satu jenis cuti.</p>
                    </div>
                </div>

                <div class="p-6 md:p-8 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @php($jenisOld = old('jenis_cuti', 'Cuti Tahunan'))
                    @foreach([
                        'Cuti Tahunan'         => 'Cuti Tahunan',
                        'Cuti Besar'           => 'Cuti Besar',
                        'Cuti Sakit'           => 'Cuti Sakit',
                        'Cuti Melahirkan'      => 'Cuti Melahirkan',
                        'Cuti Alasan Penting'  => 'Cuti Karena Alasan Penting',
                        'Cuti Luar Tanggungan' => 'Cuti di Luar Tanggungan Negara',
                    ] as $value => $label)
                        <label class="flex items-center gap-3 p-4 rounded-2xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition">
                            <input type="radio"
                                   name="jenis_cuti"
                                   value="{{ $value }}"
                                   class="h-4 w-4 text-[var(--maroon)]"
                                   {{ $jenisOld === $value ? 'checked' : '' }}>
                            <div class="min-w-0">
                                <div class="text-sm font-extrabold text-slate-800">{{ $label }}</div>
                                <div class="text-xs text-slate-500 font-medium">{{ $value }}</div>
                            </div>
                        </label>
                    @endforeach
                </div>
                {{-- Warning cuti besar --}}
                <div id="cuti_besar_warning"
                    class="hidden mx-6 mb-6 md:mx-8 md:mb-8 rounded-2xl border border-red-200 bg-red-50/60 px-5 py-4 flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-white border border-red-200 flex items-center justify-center text-red-500 flex-shrink-0 mt-0.5">
                        <i class="bi bi-exclamation-octagon-fill text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-extrabold text-red-800">Cuti Besar Tidak Tersedia</p>
                        <p id="cuti_besar_warning_text" class="text-xs font-medium text-red-700 mt-1"></p>
                    </div>
                </div>
            </section>

            {{-- IV. ALASAN CUTI --}}
            <section class="bg-white rounded-3xl shadow-soft border border-slate-100 overflow-hidden">
                <div class="px-6 md:px-8 py-5 border-b border-slate-50 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-[var(--maroon)]">
                        <i class="bi bi-chat-left-text-fill"></i>
                    </div>
                    <div>
                        <h3 class="text-sm md:text-base font-extrabold text-slate-800">IV. Alasan Cuti</h3>
                        <p class="text-xs md:text-sm text-slate-500 font-medium">Minimal 20 karakter agar mudah diverifikasi.</p>
                    </div>
                </div>

                <div class="p-6 md:p-8">
                    <label class="block text-xs font-extrabold text-slate-600 mb-2">
                        Uraian Alasan <span class="text-red-600">*</span>
                    </label>
                    <textarea name="alasan"
                              minlength="20"
                              required
                              placeholder="Jelaskan alasan cuti secara detail..."
                              class="w-full min-h-[140px] px-4 py-3 rounded-2xl border border-slate-200 bg-white text-slate-800 font-medium focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-[var(--maroon)]">{{ old('alasan') }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-2 font-semibold">Berikan alasan yang jelas, minimal 20 karakter.</p>
                </div>
            </section>

            {{-- V. LAMA CUTI --}}
            <section class="bg-white rounded-3xl shadow-soft border border-slate-100 overflow-hidden">
                <div class="px-6 md:px-8 py-5 border-b border-slate-50 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-[var(--maroon)]">
                        <i class="bi bi-calendar2-week-fill"></i>
                    </div>
                    <div>
                        <h3 class="text-sm md:text-base font-extrabold text-slate-800">V. Lamanya Cuti</h3>
                        <p class="text-xs md:text-sm text-slate-500 font-medium">Pilih satuan, isi jumlah, lalu tentukan tanggal mulai. Sabtu, Minggu, dan hari libur nasional otomatis dilewati.</p>
                    </div>
                </div>

                <div class="p-6 md:p-8 space-y-5">

                    {{-- Baris 1: Jumlah + Satuan + Tanggal Mulai --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                        {{-- Jumlah & Satuan --}}
                        <div class="md:col-span-1">
                            <label class="block text-xs font-extrabold text-slate-600 mb-2">
                                Durasi <span class="text-red-600">*</span>
                            </label>
                            <div class="flex gap-2">
                                <input type="number"
                                    id="durasi_input"
                                    min="1"
                                    value="{{ old('durasi_input', 1) }}"
                                    placeholder="0"
                                    class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white text-slate-800 font-semibold focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-[var(--maroon)]">
                                <select id="satuan_input"
                                        class="px-3 py-3 rounded-2xl border border-slate-200 bg-white text-slate-800 font-semibold focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-[var(--maroon)] cursor-pointer">
                                    <option value="hari" {{ old('satuan_input', 'hari') === 'hari' ? 'selected' : '' }}>Hari</option>
                                    <option value="minggu" {{ old('satuan_input') === 'minggu' ? 'selected' : '' }}>Minggu</option>
                                    <option value="bulan" {{ old('satuan_input') === 'bulan' ? 'selected' : '' }}>Bulan</option>
                                </select>
                            </div>
                        </div>

                        {{-- Mulai Tanggal --}}
                        <div>
                            <label class="block text-xs font-extrabold text-slate-600 mb-2">
                                Mulai Tanggal <span class="text-red-600">*</span>
                            </label>
                            <input type="date"
                                id="tanggal_mulai_input"
                                name="tanggal_mulai"
                                required
                                min="{{ now()->subDays(30)->toDateString() }}"
                                value="{{ old('tanggal_mulai') }}"
                                class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white text-slate-800 font-semibold focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-[var(--maroon)]">
                        </div>

                        {{-- s/d Tanggal (readonly, dihitung otomatis) --}}
                        <div>
                            <label class="block text-xs font-extrabold text-slate-600 mb-2">
                                s/d Tanggal <span class="text-slate-400 font-medium">(otomatis)</span>
                            </label>
                            <input type="date"
                                id="tanggal_selesai_display"
                                name="tanggal_selesai"
                                required
                                readonly
                                value="{{ old('tanggal_selesai') }}"
                                class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-700 font-semibold focus:outline-none cursor-not-allowed">
                        </div>
                    </div>

                    {{-- Hidden inputs untuk dikirim ke server --}}
                    <input type="hidden" name="lama_hari" id="lama_hari_hidden" value="{{ old('lama_hari', '') }}">

                    {{-- Ringkasan hasil kalkulasi --}}
                    <div id="durasi_summary" class="hidden rounded-2xl border border-slate-100 bg-slate-50/60 px-5 py-4 flex flex-wrap items-center gap-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-[var(--maroon)]">
                                <i class="bi bi-calendar-check text-sm"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Hari Kerja</p>
                                <p id="summary_hari_kerja" class="text-sm font-extrabold text-slate-800">—</p>
                            </div>
                        </div>
                        <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-amber-500">
                                <i class="bi bi-slash-circle text-sm"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Dilewati</p>
                                <p id="summary_dilewati" class="text-sm font-extrabold text-slate-800">—</p>
                            </div>
                        </div>
                        <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-500">
                                <i class="bi bi-calendar-range text-sm"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Total Kalender</p>
                                <p id="summary_kalender" class="text-sm font-extrabold text-slate-800">—</p>
                            </div>
                        </div>
                    </div>

                    {{-- Loading state API --}}
                    <div id="durasi_loading" class="hidden rounded-2xl border border-blue-100 bg-blue-50/50 px-5 py-3 flex items-center gap-3">
                        <svg class="animate-spin h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <p class="text-xs font-semibold text-blue-700">Mengambil data hari libur nasional...</p>
                    </div>

                    {{-- Error state API --}}
                    <div id="durasi_error" class="hidden rounded-2xl border border-amber-200 bg-amber-50/60 px-5 py-3 flex items-center gap-3">
                        <i class="bi bi-exclamation-triangle-fill text-amber-500 text-sm"></i>
                        <p class="text-xs font-semibold text-amber-800">
                            Gagal mengambil data hari libur. Sabtu & Minggu tetap diabaikan, tapi hari libur nasional mungkin tidak terhitung.
                        </p>
                    </div>

                </div>
            </section>

            {{-- VI. CATATAN CUTI --}}
            <section class="bg-white rounded-3xl shadow-soft border border-slate-100 overflow-hidden">
                <div class="px-6 md:px-8 py-5 border-b border-slate-50 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-[var(--maroon)]">
                        <i class="bi bi-table"></i>
                    </div>
                    <div>
                        <h3 class="text-sm md:text-base font-extrabold text-slate-800">VI. Catatan Cuti</h3>
                        <p class="text-xs md:text-sm text-slate-500 font-medium">Ringkasan sisa cuti berdasarkan tahun.</p>
                    </div>
                </div>

                <div class="p-6 md:p-8 overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-xs font-extrabold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                <th class="py-3 pr-4">Tahun</th>
                                <th class="py-3 pr-4">Sisa Cuti</th>
                                <th class="py-3">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr>
                                <td class="py-4 pr-4 font-extrabold text-slate-700">
                                    N-2 ({{ $leaveBalance['n2']['year'] ?? '-' }})
                                </td>
                                <td class="py-4 pr-4">
                                    <input type="text"
                                           readonly
                                           value="{{ $leaveBalance['n2']['remaining'] ?? 0 }}"
                                           class="w-28 px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 text-slate-700 font-semibold">
                                </td>
                                <td class="py-4">
                                    <input type="text"
                                           readonly
                                           value="Bonus: {{ $leaveBalance['n2']['bonus'] ?? 0 }} hari (setengah dari sisa)"
                                           class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 text-slate-600 font-medium">
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 pr-4 font-extrabold text-slate-700">
                                    N-1 ({{ $leaveBalance['n1']['year'] ?? '-' }})
                                </td>
                                <td class="py-4 pr-4">
                                    <input type="text"
                                           readonly
                                           value="{{ $leaveBalance['n1']['remaining'] ?? 0 }}"
                                           class="w-28 px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 text-slate-700 font-semibold">
                                </td>
                                <td class="py-4">
                                    <input type="text"
                                           readonly
                                           value="Bonus: {{ $leaveBalance['n1']['bonus'] ?? 0 }} hari (setengah dari sisa)"
                                           class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 text-slate-600 font-medium">
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 pr-4 font-extrabold text-slate-700">
                                    N ({{ $leaveBalance['n']['year'] ?? '-' }}) - Tahun Berjalan
                                </td>
                                <td class="py-4 pr-4">
                                    <input type="text"
                                           readonly
                                           value="{{ $leaveBalance['n']['remaining'] ?? 0 }}"
                                           class="w-28 px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 text-[var(--maroon)] font-extrabold">
                                </td>
                                <td class="py-4">
                                    <input type="text"
                                           readonly
                                           value="Sisa cuti tahun ini (dari {{ $leaveBalance['n']['quota'] ?? 0 }} hari)"
                                           class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 text-slate-600 font-medium">
                                </td>
                            </tr>
                            <tr class="bg-emerald-50/30">
                                <td class="py-4 pr-4 font-black text-[var(--maroon)]">TOTAL TERSEDIA</td>
                                <td class="py-4 pr-4">
                                    <input type="text"
                                           readonly
                                           value="{{ $leaveBalance['total_available'] ?? 0 }}"
                                           class="w-28 px-3 py-2 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-700 font-black">
                                </td>
                                <td class="py-4">
                                    <input type="text"
                                           readonly
                                           value="Total cuti yang dapat diambil saat ini"
                                           class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white text-slate-600 font-medium">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- VII. ALAMAT CUTI --}}
            <section class="bg-white rounded-3xl shadow-soft border border-slate-100 overflow-hidden">
                <div class="px-6 md:px-8 py-5 border-b border-slate-50 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-[var(--maroon)]">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div>
                        <h3 class="text-sm md:text-base font-extrabold text-slate-800">VII. Alamat Selama Menjalankan Cuti</h3>
                        <p class="text-xs md:text-sm text-slate-500 font-medium">Isi alamat dan kontak yang bisa dihubungi.</p>
                    </div>
                </div>

                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Alamat Lengkap --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-extrabold text-slate-600 mb-2">
                            Alamat Lengkap <span class="text-red-600">*</span>
                        </label>
                        <textarea name="alamat_cuti"
                                  required
                                  placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten..."
                                  class="w-full min-h-[110px] px-4 py-3 rounded-2xl border border-slate-200 bg-white text-slate-800 font-medium focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-[var(--maroon)]">{{ old('alamat_cuti') }}</textarea>
                    </div>

                    {{-- Nomor Telepon / HP --}}
                    <div>
                        <label class="block text-xs font-extrabold text-slate-600 mb-2">
                            Nomor Telepon / HP <span class="text-red-600">*</span>
                        </label>
                        <input type="text"
                               name="no_telepon"
                               required
                               value="{{ old('no_telepon') }}"
                               placeholder="08xxxxxxxxxx"
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white text-slate-800 font-semibold focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-[var(--maroon)]">
                    </div>

                    <div class="grid grid-cols-1 gap-5">

                        {{-- Nomor Telepon Darurat --}}
                        <div>
                            <label class="block text-xs font-extrabold text-slate-600 mb-2">
                                Nomor Telepon / HP Darurat <span class="text-red-600">*</span>
                            </label>
                            <input type="text"
                                   name="no_telepon_darurat"
                                   required
                                   value="{{ old('no_telepon_darurat') }}"
                                   placeholder="08xxxxxxxxxx"
                                   class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white text-slate-800 font-semibold focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-[var(--maroon)]">
                        </div>

                        {{-- Hubungan Darurat --}}
                        <div>
                            <label class="block text-xs font-extrabold text-slate-600 mb-2">
                                Hubungan dengan yang Bersangkutan <span class="text-red-600">*</span>
                            </label>
                            <input type="text"
                                   name="hubungan_darurat"
                                   required
                                   value="{{ old('hubungan_darurat') }}"
                                   placeholder="Contoh: Istri, Suami, Orang Tua, Saudara"
                                   class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white text-slate-800 font-semibold focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-[var(--maroon)]">
                        </div>

                    </div>
                </div>
            </section>

            {{-- VIII. DOKUMEN PENDUKUNG --}}
            <section class="bg-white rounded-3xl shadow-soft border border-slate-100 overflow-hidden">
                <div class="px-6 md:px-8 py-5 border-b border-slate-50 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-[var(--maroon)]">
                        <i class="bi bi-paperclip"></i>
                    </div>
                    <div>
                        <h3 class="text-sm md:text-base font-extrabold text-slate-800">VIII. Dokumen Pendukung (Opsional)</h3>
                        <p class="text-xs md:text-sm text-slate-500 font-medium">Unggah lampiran jika diperlukan (surat dokter, dsb).</p>
                    </div>
                </div>

                <div class="p-6 md:p-8 space-y-5">

                    {{-- Catatan Tambahan --}}
                    <div>
                        <label class="block text-xs font-extrabold text-slate-600 mb-2">Catatan Tambahan</label>
                        <textarea name="catatan_tambahan"
                                  placeholder="Tambahkan catatan jika ada hal spesifik..."
                                  class="w-full min-h-[110px] px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50/30 text-slate-800 font-medium focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-[var(--maroon)]">{{ old('catatan_tambahan') }}</textarea>
                    </div>

                    {{-- Dokumen Lampiran --}}
                    <div>
                        <label class="block text-xs font-extrabold text-slate-600 mb-2">Dokumen Lampiran</label>
                        <div id="dropZone"
                             class="relative rounded-2xl border border-dashed border-slate-200 bg-slate-50/40 p-6 flex flex-col items-center justify-center text-center">
                            <input type="file"
                                   name="dokumen_pendukung"
                                   id="fileUpload"
                                   accept=".pdf,.doc,.docx,.jpg,.png"
                                   class="absolute inset-0 opacity-0 cursor-pointer" />
                            @error('dokumen_pendukung')
                                <p class="text-xs text-red-600 font-semibold mt-2">{{ $message }}</p>
                            @enderror
                            <div id="uploadIcon"
                                 class="w-14 h-14 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-500">
                                <i class="bi bi-upload text-2xl"></i>
                            </div>
                            <div id="uploadText" class="mt-4 text-sm font-extrabold text-slate-700">Klik atau seret file ke sini</div>
                            <div id="uploadHint" class="mt-2 text-xs text-slate-500 font-medium">Supported: PDF, DOC, JPG, PNG (Maks 5MB)</div>
                        </div>
                    </div>

                {{-- Download template surat permohonan cuti --}}
                    <div class="mb-4 rounded-2xl border border-blue-100 bg-blue-50/60 p-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <div class="w-11 h-11 rounded-xl bg-white border border-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                <i class="bi bi-file-earmark-word-fill text-xl"></i>
                            </div>
                            <div>
                                <div class="text-sm font-extrabold text-slate-800">Surat Permohonan Cuti</div>
                                <p class="text-xs md:text-sm text-slate-500 font-medium mt-1">
                                        Unduh format surat, isi sesuai kebutuhan, lalu lampirkan bersama dokumen pendukung pengajuan cuti.
                                </p>
                            </div>
                        </div>
                         <a href="{{ asset('templates/surat-permohonan-cuti.docx') }}"
                             download="SURAT PERMOHONAN CUTI.docx"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-blue-600 px-4 py-3 text-xs md:text-sm font-extrabold text-white shadow-lg shadow-blue-900/10 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100 transition whitespace-nowrap">
                               <i class="bi bi-download"></i>
                             Download Surat Permohonan Cuti
                         </a>
                    </div>

                    {{-- Tips --}}
                    <div class="rounded-2xl border border-blue-100 bg-blue-50/50 p-5 flex gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white border border-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                            <i class="bi bi-lightbulb-fill"></i>
                        </div>
                        <div>
                            <div class="text-sm font-extrabold text-blue-800">Tips</div>
                            <p class="text-sm text-blue-700/80 font-medium mt-1">Pastikan melengkapi dokumen pendukung agar proses verifikasi berjalan lancar dengan menggabungkan surat permohonan cuti, SK PNS/PPPK, serta lampiran yang sesuai dengan alasan cuti (seperti surat dokter, jadwal haji/umrah dari biro perjalanan, undangan, surat keterangan, dan dokumen pendukung lainnya) ke dalam 1 file PDF sesuai ketentuan ukuran yang berlaku.</p>
                        </div>
                    </div>

                </div>
            </section>

            {{-- Submit --}}
            <div class="pt-2">
                <button type="submit"
                        class="w-full btn-primary text-white px-6 py-4 rounded-2xl font-extrabold shadow-lg shadow-red-900/15 inline-flex items-center justify-center gap-2">
                    <i class="bi bi-send-fill"></i>
                    Ajukan Permohonan Cuti
                </button>
                <p class="text-center text-[11px] text-slate-400 font-semibold mt-3">
                    Dengan menekan tombol ini, Anda menyatakan bahwa data yang diisi adalah benar.
                </p>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
<script>
// =============================================================================
// FILE UPLOAD
// =============================================================================
const fileInput  = document.getElementById('fileUpload');
const uploadText = document.getElementById('uploadText');
const uploadHint = document.getElementById('uploadHint');
const uploadIcon = document.getElementById('uploadIcon');
const dropZone   = document.getElementById('dropZone');

const ALLOWED_TYPES = [
    'application/pdf',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'image/jpeg', 'image/png',
];
const ALLOWED_EXT = ['pdf', 'docx', 'jpg', 'jpeg', 'png'];
const MAX_SIZE_MB  = 5;

if (fileInput) {
    fileInput.addEventListener('change', function () {
        if (!this.files || !this.files[0]) return;
        const file   = this.files[0];
        const ext    = file.name.split('.').pop().toLowerCase();
        const sizeMB = file.size / (1024 * 1024);
        if (!ALLOWED_EXT.includes(ext))           { showFileError(`Format tidak diizinkan: .${ext}`); this.value = ''; return; }
        if (!ALLOWED_TYPES.includes(file.type))   { showFileError('Tipe file tidak valid.');           this.value = ''; return; }
        if (sizeMB > MAX_SIZE_MB)                 { showFileError(`Melebihi ${MAX_SIZE_MB}MB.`);       this.value = ''; return; }
        showFileSuccess(file);
    });
}

function showFileError(msg) {
    uploadText.innerText = msg;         uploadText.className = 'mt-4 text-sm font-extrabold text-red-600';
    uploadHint.innerText = 'Pilih file lain: PDF, DOCX, JPG, atau PNG (maks 5MB)';
    uploadHint.className = 'mt-2 text-xs text-red-400 font-medium';
    uploadIcon.innerHTML = '<i class="bi bi-x-circle-fill text-2xl text-red-500"></i>';
    dropZone.classList.replace('border-slate-200', 'border-red-300');
    dropZone.classList.add('bg-red-50/40');
}
function showFileSuccess(file) {
    uploadText.innerText = 'File Siap Diupload!'; uploadText.className = 'mt-4 text-sm font-extrabold text-emerald-700';
    uploadHint.innerHTML = `<strong>Berhasil:</strong> ${file.name} (${(file.size/1024).toFixed(1)} KB)`;
    uploadHint.className = 'mt-2 text-xs text-emerald-700 font-medium';
    uploadIcon.innerHTML = '<i class="bi bi-check-circle-fill text-2xl text-emerald-600"></i>';
    dropZone.classList.replace('border-slate-200', 'border-emerald-300');
    dropZone.classList.add('bg-emerald-50/40');
}

// =============================================================================
// SUPERVISOR INFO CARD + PLT
// =============================================================================
const supervisorSelect   = document.getElementById('supervisor_select');
const supervisorInfo     = document.getElementById('supervisor_info');
const infoNip            = document.getElementById('info_nip');
const infoJabatan        = document.getElementById('info_jabatan');
const infoJabatanPlt     = document.getElementById('info_jabatan_plt');
const infoUnit           = document.getElementById('info_unit');
const pltCheckboxWrapper = document.getElementById('plt_checkbox_wrapper');
const pltCheckbox        = document.getElementById('plt_checkbox');
const pltNotice          = document.getElementById('plt_notice');
const pltHiddenInput     = document.getElementById('plt_jabatan_value');

function updateSupervisorInfo() {
    const selected = supervisorSelect.options[supervisorSelect.selectedIndex];
    if (!selected || !selected.value) {
        supervisorInfo.classList.add('hidden');
        pltCheckboxWrapper.classList.add('hidden');
        pltCheckboxWrapper.classList.remove('flex');
        pltNotice.classList.add('hidden');
        pltCheckbox.checked = false;
        pltHiddenInput.value = '';
        applyPltMode(false);
        return;
    }
    infoNip.textContent     = selected.dataset.nip      || '—';
    infoJabatan.textContent = selected.dataset.jabatan  || '—';
    infoUnit.textContent    = selected.dataset.unit     || '—';
    pltCheckbox.checked     = false;
    pltHiddenInput.value    = '';
    infoJabatanPlt.value    = '';
    applyPltMode(false);
    supervisorInfo.classList.remove('hidden');
    pltCheckboxWrapper.classList.remove('hidden');
    pltCheckboxWrapper.classList.add('flex');
}

function applyPltMode(isPlt) {
    if (isPlt) {
        infoJabatan.classList.add('hidden');
        infoJabatanPlt.classList.remove('hidden');
        pltNotice.classList.remove('hidden');
        if (!infoJabatanPlt.value) {
            const db = infoJabatan.textContent;
            infoJabatanPlt.value = db !== '—' ? db : '';
            pltHiddenInput.value = infoJabatanPlt.value;
        }
        infoJabatanPlt.focus();
    } else {
        infoJabatan.classList.remove('hidden');
        infoJabatanPlt.classList.add('hidden');
        pltNotice.classList.add('hidden');
        pltHiddenInput.value = '';
    }
}

if (infoJabatanPlt) {
    infoJabatanPlt.addEventListener('input', function () {
        pltHiddenInput.value = this.value.trim();
    });
}
if (supervisorSelect) {
    supervisorSelect.addEventListener('change', updateSupervisorInfo);
    if (supervisorSelect.value) updateSupervisorInfo();
}
if (pltCheckbox) {
    pltCheckbox.addEventListener('change', function () { applyPltMode(this.checked); });
}

// =============================================================================
// KALKULASI HARI KERJA (skip Sabtu, Minggu, libur nasional)
// =============================================================================

// Cache hari libur per tahun agar tidak fetch berulang
const _holidayCache = {};

async function fetchHolidays(year) {
    if (_holidayCache[year] !== undefined) return _holidayCache[year];

    showDurasiLoading(true);
    try {
        const res  = await fetch(`https://api-hari-libur.vercel.app/api?year=${year}`);
        const json = await res.json();
        // Response: { status, code, data: [ { date: "YYYY-MM-DD", description: "..." } ] }
        const dates = (json.data || []).map(h => h.date);
        _holidayCache[year] = dates;
        showDurasiError(false);
        return dates;
    } catch (e) {
        _holidayCache[year] = [];   // fallback: anggap tidak ada libur nasional
        showDurasiError(true);
        return [];
    } finally {
        showDurasiLoading(false);
    }
}

/**
 * Hitung hari kerja dari startDate sebanyak workDays hari.
 * Lewati Sabtu (6), Minggu (0), dan hari libur nasional.
 * Kembalikan { endDate: Date, skipped: number, calendarDays: number }
 */
async function calcWorkDays(startDate, workDays) {
    // Kumpulkan tahun yang mungkin dilewati (maks ~1 tahun ke depan)
    const startYear = startDate.getFullYear();
    const endYearEst = startYear + 1;
    const [h1, h2] = await Promise.all([
        fetchHolidays(startYear),
        fetchHolidays(endYearEst),
    ]);
    const holidaySet = new Set([...h1, ...h2]);

    function isWorkDay(d) {
        const dow = d.getDay();                          // 0=Sun, 6=Sat
        if (dow === 0 || dow === 6) return false;
        const key = d.toISOString().slice(0, 10);
        if (holidaySet.has(key)) return false;
        return true;
    }

    // Jika hari mulai itu sendiri bukan hari kerja, geser maju
    let cursor = new Date(startDate);
    while (!isWorkDay(cursor)) {
        cursor.setDate(cursor.getDate() + 1);
    }
    const actualStart = new Date(cursor);

    let counted = 0;
    let skipped  = 0;

    while (counted < workDays) {
        if (isWorkDay(cursor)) {
            counted++;
            if (counted < workDays) cursor.setDate(cursor.getDate() + 1);
        } else {
            skipped++;
            cursor.setDate(cursor.getDate() + 1);
        }
    }

    const calendarDays = Math.round((cursor - actualStart) / 86400000) + 1;
    return { endDate: cursor, skipped, calendarDays, actualStart };
}

/**
 * Konversi durasi + satuan → jumlah hari kerja yang diminta
 */
function toWorkDaysRequested(durasi, satuan) {
    if (satuan === 'hari')   return durasi;
    if (satuan === 'minggu') return durasi * 5;   // 1 minggu = 5 hari kerja
    if (satuan === 'bulan')  return durasi * 22;  // 1 bulan ≈ 22 hari kerja
    return durasi;
}

function fmt(date) {
    // Format ke YYYY-MM-DD untuk input[type=date]
    return date.toISOString().slice(0, 10);
}

function showDurasiLoading(show) {
    document.getElementById('durasi_loading').classList.toggle('hidden', !show);
}
function showDurasiError(show) {
    document.getElementById('durasi_error').classList.toggle('hidden', !show);
}

// Elemen
const durasiInput       = document.getElementById('durasi_input');
const satuanInput       = document.getElementById('satuan_input');
const tanggalMulaiInput = document.getElementById('tanggal_mulai_input');
const tanggalSelesaiDisp= document.getElementById('tanggal_selesai_display');
const lamaHariHidden    = document.getElementById('lama_hari_hidden');
const durasiSummary     = document.getElementById('durasi_summary');
const summaryHariKerja  = document.getElementById('summary_hari_kerja');
const summaryDilewati   = document.getElementById('summary_dilewati');
const summaryKalender   = document.getElementById('summary_kalender');

let _calcTimer = null;

async function recalculate() {
    const durasi  = parseInt(durasiInput.value, 10);
    const satuan  = satuanInput.value;
    const mulaiVal= tanggalMulaiInput.value;

    // Reset jika input belum lengkap
    if (!mulaiVal || isNaN(durasi) || durasi < 1) {
        tanggalSelesaiDisp.value = '';
        lamaHariHidden.value     = '';
        durasiSummary.classList.add('hidden');
        return;
    }

    const workDaysReq = toWorkDaysRequested(durasi, satuan);
    const startDate   = new Date(mulaiVal + 'T00:00:00');   // hindari timezone shift

    const { endDate, skipped, calendarDays, actualStart } = await calcWorkDays(startDate, workDaysReq);

    tanggalSelesaiDisp.value = fmt(endDate);
    lamaHariHidden.value     = workDaysReq;

    // Update ringkasan
    const satuanLabel = satuan === 'hari' ? 'hari kerja' : satuan === 'minggu' ? 'hari kerja' : 'hari kerja';
    summaryHariKerja.textContent = `${workDaysReq} hari kerja`;
    summaryDilewati.textContent  = skipped > 0
        ? `${skipped} hari (Sabtu/Minggu/Libur)`
        : 'Tidak ada hari dilewati';
    summaryKalender.textContent  = `${calendarDays} hari kalender`;
    durasiSummary.classList.remove('hidden');
}

function scheduleRecalc() {
    clearTimeout(_calcTimer);
    _calcTimer = setTimeout(recalculate, 300);   // debounce 300ms
}

if (durasiInput)        durasiInput.addEventListener('input', scheduleRecalc);
if (satuanInput)        satuanInput.addEventListener('change', scheduleRecalc);
if (tanggalMulaiInput)  tanggalMulaiInput.addEventListener('change', scheduleRecalc);

// Trigger kalkulasi awal jika ada nilai old() dari Laravel
if (tanggalMulaiInput?.value && durasiInput?.value) {
    recalculate();
}

// =============================================================================
// CUTI BESAR ELIGIBILITY CHECK
// =============================================================================
(async function checkCutiBesar() {
    const res = await fetch('{{ route("user.cuti.besar.check") }}', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    });
    const json = await res.json();

    const warning     = document.getElementById('cuti_besar_warning');
    const warningText = document.getElementById('cuti_besar_warning_text');
    const submitBtn   = document.querySelector('button[type="submit"]');

    // Pasang listener ke semua radio jenis cuti
    document.querySelectorAll('input[name="jenis_cuti"]').forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value !== 'Cuti Besar') {
                warning.classList.add('hidden');
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                return;
            }

            if (!json.eligible) {
                warning.classList.remove('hidden');
                warningText.textContent = json.message;
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                warning.classList.add('hidden');
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        });
    });
})();
</script>
@endpush