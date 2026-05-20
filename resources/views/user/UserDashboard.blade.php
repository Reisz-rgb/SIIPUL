@extends('layouts.user')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Overview')
@section('page_subtitle', 'Selamat datang kembali di portal layanan cuti.')

@section('content')
    @php
        $authUser = $user ?? auth()->user();
        $recent   = $recentLeaves ?? $latestLeaves ?? [];
    @endphp

    {{-- Email warning modal overlay --}}
    @if(empty($authUser->email))
        {{-- Backdrop --}}
        <div id="email-modal-backdrop"
             style="position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:1rem;
                    background:rgba(15,23,42,0.45);
                    backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);
                    opacity:0;transition:opacity 400ms ease-out;">

            {{-- Modal card --}}
            <div id="email-modal"
                 style="position:relative;background:white;border-radius:1.5rem;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);
                        max-width:26rem;width:100%;padding:2.5rem;display:flex;flex-direction:column;align-items:center;text-align:center;
                        transform:scale(0.92) translateY(16px);opacity:0;
                        transition:transform 400ms cubic-bezier(.34,1.56,.64,1),opacity 400ms ease-out;">

                {{-- Icon --}}
                <div style="width:4rem;height:4rem;border-radius:1rem;background:#FEF3C7;border:2px solid #FDE68A;
                            display:flex;align-items:center;justify-content:center;margin-bottom:1.25rem;">
                    <i class="bi bi-envelope-exclamation-fill" style="font-size:1.75rem;color:#D97706;"></i>
                </div>

                {{-- Text --}}
                <h3 style="font-size:1.125rem;font-weight:800;color:#1E293B;margin-bottom:.5rem;">Email belum ditambahkan</h3>
                <p style="font-size:.875rem;color:#64748B;font-weight:500;line-height:1.6;margin-bottom:1.5rem;">
                    Tanpa email, Anda tidak dapat menggunakan fitur <span style="font-weight:700;color:#334155;">lupa password</span>.<br>
                    Lengkapi profil Anda sekarang agar akun tetap aman.
                </p>

                {{-- Actions --}}
                <div style="display:flex;gap:.75rem;width:100%;">
                    <button onclick="closeEmailModal()"
                            style="flex:1;font-size:.875rem;font-weight:700;color:#64748B;background:#F1F5F9;
                                   padding:.75rem 1rem;border-radius:.875rem;border:none;cursor:pointer;transition:background .2s;"
                            onmouseover="this.style.background='#E2E8F0'" onmouseout="this.style.background='#F1F5F9'">
                        Nanti Saja
                    </button>
                    <a href="{{ route('user.profil.edit') }}"
                       style="flex:1;font-size:.875rem;font-weight:800;color:white;background:#F59E0B;
                              padding:.75rem 1rem;border-radius:.875rem;text-decoration:none;
                              display:inline-flex;align-items:center;justify-content:center;gap:.5rem;
                              box-shadow:0 4px 14px rgba(245,158,11,.35);transition:background .2s;"
                       onmouseover="this.style.background='#D97706'" onmouseout="this.style.background='#F59E0B'">
                        <i class="bi bi-pencil-fill" style="font-size:.7rem;"></i>
                        Isi Email Sekarang
                    </a>
                </div>

                {{-- Close X --}}
                <button onclick="closeEmailModal()"
                        style="position:absolute;top:1rem;right:1rem;width:2rem;height:2rem;border-radius:50%;
                               border:none;background:transparent;cursor:pointer;color:#94A3B8;
                               display:flex;align-items:center;justify-content:center;transition:background .2s;"
                        onmouseover="this.style.background='#F1F5F9';this.style.color='#475569'"
                        onmouseout="this.style.background='transparent';this.style.color='#94A3B8'"
                        aria-label="Tutup">
                    <i class="bi bi-x-lg" style="font-size:.875rem;"></i>
                </button>
            </div>
        </div>

        <script>
            function closeEmailModal() {
                var backdrop = document.getElementById('email-modal-backdrop');
                var modal    = document.getElementById('email-modal');
                backdrop.style.opacity = '0';
                modal.style.opacity    = '0';
                modal.style.transform  = 'scale(0.92) translateY(16px)';
                setTimeout(function () { backdrop.remove(); }, 400);
            }

            // Pindahkan modal ke <body> supaya inset:0 cover full viewport termasuk sidebar
            document.addEventListener('DOMContentLoaded', function () {
                var backdrop = document.getElementById('email-modal-backdrop');
                if (backdrop) document.body.appendChild(backdrop);
            });

            // Tutup kalau klik backdrop
            document.getElementById('email-modal-backdrop').addEventListener('click', function (e) {
                if (e.target === this) closeEmailModal();
            });

            // Tutup dengan Escape
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeEmailModal();
            });

            // Tampilkan setelah 500ms
            setTimeout(function () {
                var backdrop = document.getElementById('email-modal-backdrop');
                var modal    = document.getElementById('email-modal');
                if (!backdrop) return;
                backdrop.style.opacity = '1';
                modal.style.opacity    = '1';
                modal.style.transform  = 'scale(1) translateY(0)';
            }, 500);
        </script>
    @endif

    {{-- Welcome card --}}
    <section class="bg-white border-0 rounded-[2.5rem] p-8 md:p-10 shadow-soft flex flex-col justify-center">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex-1">
                <div class="inline-flex items-center gap-2 bg-emerald-50 text-emerald-700 rounded-full px-3 py-1 mb-4">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    <span class="text-[10px] font-extrabold tracking-widest uppercase">{{ $authUser->status ?? 'AKTIF' }}</span>
                </div>

                <h3 class="text-2xl md:text-3xl font-extrabold text-slate-800 leading-tight">
                    Halo, {{ explode(' ', $authUser->name ?? 'User')[0] }}! 👋
                </h3>
                <p class="text-slate-500 text-base font-medium mt-2 leading-relaxed md:w-3/4">
                    Pantau sisa jatah cuti dan status pengajuan Anda.
                </p>
            </div>

            <div class="flex-shrink-0">
                <a href="{{ route('user.cuti.create') }}"
                   class="btn-primary text-white px-8 py-4 rounded-2xl font-bold shadow-lg shadow-red-900/20 text-sm md:text-base inline-flex items-center justify-center w-full md:w-auto transition-all hover:scale-[1.02] active:scale-[0.98]">
                    <i class="bi bi-plus-circle-fill mr-3 text-lg"></i>
                    Ajukan Cuti Baru
                </a>
            </div>
        </div>
    </section>

    {{-- Stats + Recent --}}
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start mt-6">

        {{-- Stat cards --}}
        <div class="lg:col-span-5 space-y-4">

            {{-- Jatah Tahunan --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:-translate-y-1 transition-transform flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center flex-shrink-0 border border-blue-100 text-blue-500">
                    <i class="bi bi-files text-2xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-[10px] font-extrabold text-slate-400 tracking-wider uppercase">Jatah Tahunan</p>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-3xl font-black text-slate-800 leading-none">{{ $totalQuota ?? 0 }}</h3>
                        <p class="text-[11px] text-slate-400 font-bold uppercase">Hari</p>
                    </div>
                    @php
                        $quotaMax     = (int)($annualQuota ?? ($totalQuota ?? 0));
                        $remainAnnual = (int)($totalQuota ?? 0);
                        $pctAnnual    = ($quotaMax > 0) ? min(100, max(0, ($remainAnnual / $quotaMax) * 100)) : 0;
                    @endphp
                    <div class="mt-3 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-blue-500 h-full" style="width: {{ $pctAnnual }}%"></div>
                    </div>
                </div>
            </div>

            {{-- Telah Diambil --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:-translate-y-1 transition-transform flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center flex-shrink-0 border border-orange-100 text-orange-500">
                    <i class="bi bi-hourglass-split text-2xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-[10px] font-extrabold text-slate-400 tracking-wider uppercase">Telah Diambil</p>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-3xl font-black text-orange-600 leading-none">{{ $usedLeave ?? 0 }}</h3>
                        <p class="text-[11px] text-slate-400 font-bold uppercase">Hari</p>
                    </div>
                    @php
                        $quota = max((int)($totalQuota ?? 0), 1);
                        $used  = (int)($usedLeave ?? 0);
                        $pct   = min(100, max(0, ($used / $quota) * 100));
                    @endphp
                    <div class="mt-3 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-orange-500 h-full" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
            </div>

            {{-- Sisa Cuti --}}
            <div class="bg-white rounded-3xl p-6 border border-emerald-100 shadow-sm hover:-translate-y-1 transition-transform flex items-center gap-5 bg-gradient-to-r from-white to-emerald-50/30">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-content-center flex-shrink-0 border border-emerald-100 text-emerald-600 flex items-center justify-center">
                    <i class="bi bi-check-lg text-2xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-[10px] font-extrabold text-slate-400 tracking-wider uppercase">Sisa Cuti Tersedia</p>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-4xl font-black text-slate-800 leading-none">{{ $remainingLeave ?? 0 }}</h3>
                        <p class="text-[11px] text-slate-400 font-bold uppercase">Hari</p>
                    </div>
                    @php
                        $maxAvail   = (int)($maxAvailable ?? ($remainingLeave ?? 0));
                        $remainAvail = (int)($remainingLeave ?? 0);
                        $pctAvail   = ($maxAvail > 0) ? min(100, max(0, ($remainAvail / $maxAvail) * 100)) : 0;
                    @endphp
                    <div class="mt-3 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-emerald-500 h-full" style="width: {{ $pctAvail }}%"></div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Recent submissions --}}
        <div class="lg:col-span-7">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

                <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                    <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="bi bi-clock-history text-[var(--maroon)]"></i>
                        Pengajuan Terbaru
                    </h4>
                    <a href="{{ route('user.riwayat') }}"
                       class="text-[11px] font-bold text-[var(--maroon)] hover:underline uppercase tracking-tighter">
                        Lihat Semua
                    </a>
                </div>

                <div class="p-5 space-y-4">
                    @forelse($recent as $leave)
                        @php
                            $statusColor = [
                                'approved' => 'emerald',
                                'pending'  => 'orange',
                                'rejected' => 'red',
                            ][$leave->status] ?? 'slate';

                            $statusIcon = [
                                'approved' => 'bi-check-circle-fill',
                                'pending'  => 'bi-hourglass-split',
                                'rejected' => 'bi-x-circle-fill',
                            ][$leave->status] ?? 'bi-info-circle';
                        @endphp

                        <div class="flex items-center gap-4 p-4 rounded-2xl border border-slate-50 hover:bg-slate-50 transition-all group">
                            <div class="w-12 h-12 rounded-xl bg-{{ $statusColor }}-50 border border-{{ $statusColor }}-100 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                <i class="bi {{ $statusIcon }} text-{{ $statusColor }}-500 text-lg"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start gap-3">
                                    <h5 class="font-bold text-slate-800 text-sm truncate">{{ $leave->jenis_cuti }}</h5>
                                    <span class="text-[10px] font-bold bg-{{ $statusColor }}-50 text-{{ $statusColor }}-600 px-2.5 py-1 rounded-lg capitalize border border-{{ $statusColor }}-100">
                                        {{ $leave->status }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 font-medium mt-1">
                                    {{ $leave->start_date->format('d M Y') }} • <span class="text-slate-800">{{ $leave->duration }} Hari</span>
                                </p>
                            </div>
                        </div>

                    @empty
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="bi bi-folder2-open text-slate-200 text-3xl"></i>
                            </div>
                            <p class="text-slate-400 text-sm font-medium">Belum ada riwayat pengajuan cuti.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>

    </section>

    {{-- Footer --}}
    <div class="text-center pt-8 pb-4">
        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
            © {{ now()->year }} Pemerintah Kabupaten Semarang • Disdikbudpora
        </p>
    </div>
@endsection  