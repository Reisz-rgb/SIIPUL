@extends('layouts.admin')
@section('title', 'Profil Saya - E-CUTI')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --primary-red:   #9E2A2B;
        --primary-hover: #7F1D1D;
        --bg-body:       #F3F4F6;
        --text-main:     #111827;
        --text-muted:    #6B7280;
    }

    body {
        background-color: var(--bg-body);
        font-family: 'Inter', sans-serif;
        color: var(--text-main);
        padding-bottom: 40px;
    }

    .top-header {
        background-color: var(--primary-red);
        color: white;
        padding: 16px 24px;
        font-weight: 600;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 16px;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .btn-back {
        color: white; text-decoration: none; font-size: 1.25rem;
        display: flex; align-items: center; transition: transform 0.2s;
    }
    .btn-back:hover { color: #e0e0e0; transform: translateX(-3px); }

    .profile-container {
        max-width: 800px;
        margin: 24px auto;
        padding: 0 16px;
    }

    .profile-banner-card {
        background: linear-gradient(135deg, var(--primary-red) 0%, #7F1D1D 100%);
        color: white;
        border-radius: 16px;
        padding: 32px;
        display: flex;
        align-items: center;
        gap: 24px;
        margin-bottom: 24px;
        box-shadow: 0 10px 25px -5px rgba(158, 42, 43, 0.4);
    }

    .profile-avatar-large {
        width: 90px; height: 90px;
        background-color: white;
        color: var(--primary-red);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 2.2rem; font-weight: 700;
        flex-shrink: 0;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    /* Tab Navigation */
    .tab-nav {
        display: flex;
        gap: 4px;
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        padding: 6px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .tab-btn {
        flex: 1;
        padding: 10px 16px;
        border: none;
        background: transparent;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.88rem;
        color: var(--text-muted);
        cursor: pointer;
        transition: all 0.2s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }

    .tab-btn.active {
        background-color: var(--primary-red);
        color: white;
        box-shadow: 0 2px 8px rgba(158, 42, 43, 0.3);
    }

    .tab-btn:hover:not(.active) {
        background-color: #F3F4F6;
        color: var(--text-main);
    }

    /* Tab content */
    .tab-pane { display: none; }
    .tab-pane.active { display: block; }

    /* Card */
    .card-clean {
        background: white; border: 1px solid #E5E7EB;
        border-radius: 16px; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        padding: 32px; margin-bottom: 24px;
    }

    .card-section-title {
        font-size: 1rem; font-weight: 700; color: var(--text-main);
        margin-bottom: 24px; padding-bottom: 16px;
        border-bottom: 1px solid #F3F4F6;
        display: flex; align-items: center; gap: 10px;
    }

    .card-section-title .title-icon {
        width: 36px; height: 36px; border-radius: 10px;
        background-color: #FEF2F2; color: var(--primary-red);
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
    }

    .form-label-custom {
        font-size: 0.78rem; color: var(--text-muted); font-weight: 600;
        margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;
        display: flex; align-items: center; gap: 8px;
    }

    .form-control-custom {
        background-color: #F9FAFB; border: 1px solid #E5E7EB;
        padding: 12px 16px; border-radius: 8px; color: var(--text-main);
        transition: all 0.2s; width: 100%;
    }
    .form-control-custom:focus {
        background-color: white; border-color: var(--primary-red);
        box-shadow: 0 0 0 3px rgba(158, 42, 43, 0.1); outline: none;
    }
    .form-control-custom[readonly] {
        background-color: #F3F4F6; color: var(--text-muted); cursor: not-allowed;
    }

    /* Password strength */
    .password-wrapper { position: relative; }
    .password-toggle {
        position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
        cursor: pointer; color: var(--text-muted); border: none; background: none;
        font-size: 1rem; line-height: 1; z-index: 5;
    }
    .password-toggle:hover { color: var(--text-main); }

    .strength-bar {
        height: 4px; border-radius: 4px; margin-top: 8px;
        background: #E5E7EB; overflow: hidden;
    }
    .strength-fill {
        height: 100%; border-radius: 4px; width: 0%;
        transition: width 0.4s, background-color 0.4s;
    }
    .strength-text { font-size: 0.75rem; margin-top: 4px; font-weight: 600; }

    /* Divider */
    .form-divider {
        border: none; border-top: 1px solid #F3F4F6; margin: 24px 0;
    }

    /* Info Box */
    .info-note {
        background-color: #EFF6FF; border: 1px solid #DBEAFE;
        color: #1E40AF; padding: 20px; border-radius: 12px;
        font-size: 0.9rem; line-height: 1.6; display: flex; gap: 12px;
    }

    .warning-note {
        background-color: #FFFBEB; border: 1px solid #FDE68A;
        color: #92400E; padding: 16px 20px; border-radius: 10px;
        font-size: 0.875rem; display: flex; gap: 10px; align-items: flex-start;
    }

    /* Buttons */
    .action-buttons {
        display: flex; justify-content: flex-end; gap: 12px; flex-wrap: wrap;
    }

    .btn-custom {
        padding: 12px 24px; border-radius: 8px; font-weight: 600; font-size: 0.95rem;
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        border: none; transition: 0.2s; text-decoration: none; cursor: pointer;
    }

    .btn-save          { background-color: #10B981; color: white; }
    .btn-save:hover    { background-color: #059669; transform: translateY(-1px); }

    .btn-danger        { background-color: var(--primary-red); color: white; }
    .btn-danger:hover  { background-color: var(--primary-hover); transform: translateY(-1px); }

    .btn-logout        { background-color: white; border: 1px solid #FECACA; color: #DC2626; }
    .btn-logout:hover  { background-color: #FEF2F2; border-color: #DC2626; }

    .btn-secondary     { background-color: white; border: 1px solid #E5E7EB; color: var(--text-muted); }
    .btn-secondary:hover { background-color: #F9FAFB; }

    /* Alert Animasi */
    .floating-alert {
        position: fixed; top: 30px; left: 50%; transform: translate(-50%, -150%);
        padding: 12px 24px; border-radius: 50px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        z-index: 1050; opacity: 0; transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: flex; align-items: center; gap: 10px; font-weight: 600;
    }
    .floating-alert.show { transform: translate(-50%, 0); opacity: 1; }
    .alert-success { background-color: #D1FAE5; color: #065F46; border: 1px solid #A7F3D0; }
    .alert-error   { background-color: #FEE2E2; color: #991B1B; border: 1px solid #FECACA; }

    /* Badge */
    .badge-role {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3);
        color: white; font-size: 0.8rem; font-weight: 600;
        padding: 4px 12px; border-radius: 20px;
        backdrop-filter: blur(4px);
    }

    input[type="file"]::file-selector-button {
        background-color: #E5E7EB; border: none; padding: 8px 12px; margin-right: 12px;
        border-radius: 6px; cursor: pointer; color: var(--text-main); font-weight: 500;
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 576px) {
        .profile-banner-card { flex-direction: column; text-align: center; padding: 24px 20px; }
        .card-clean { padding: 20px; }
        .action-buttons { flex-direction: column; }
        .btn-custom { width: 100%; }
        .tab-btn { font-size: 0.78rem; padding: 9px 8px; }
    }
</style>
@endpush

@section('content')
<div class="top-header">
    <a href="{{ route('admin.dashboard') }}" class="btn-back"><i class="bi bi-arrow-left"></i></a>
    <span>Profil Saya</span>
</div>

{{-- Floating Alerts --}}
<div id="alertSuccess" class="floating-alert alert-success">
    <i class="bi bi-check-circle-fill fs-5"></i>
    <span id="alertSuccessText">Berhasil disimpan!</span>
</div>
<div id="alertError" class="floating-alert alert-error">
    <i class="bi bi-x-circle-fill fs-5"></i>
    <span id="alertErrorText">Terjadi kesalahan.</span>
</div>

<div class="profile-container">

    {{-- Banner --}}
    <div class="profile-banner-card">
        @if(Auth::user()->photo)
            <img src="{{ asset('storage/' . Auth::user()->photo) }}"
                 id="bannerInitial"
                 style="width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid white;flex-shrink:0;box-shadow:0 4px 6px rgba(0,0,0,0.2);"
                 alt="Foto Profil">
        @else
            <div class="profile-avatar-large" id="bannerInitial">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
            </div>
        @endif
        <div>
            <h4 class="mb-1 fw-bold" id="bannerName">{{ Auth::user()->name ?? 'Nama Pengguna' }}</h4>
            <div style="opacity:0.85; font-size:0.9rem;">
                <span class="badge-role">
                    <i class="bi bi-shield-fill"></i>
                    {{ ucfirst(Auth::user()->role) }}
                </span>
                <span style="margin-left:8px; opacity:0.8;">Kabupaten Semarang</span>
            </div>
        </div>
    </div>

    {{-- Laravel flash messages --}}
    @if (session('success'))
        <div class="mb-3 p-3 rounded-3 text-success bg-success bg-opacity-10 border border-success border-opacity-25 d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-3 p-3 rounded-3 text-danger bg-danger bg-opacity-10 border border-danger border-opacity-25 d-flex align-items-center gap-2">
            <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Tab Navigation --}}
    <div class="tab-nav">
        <button class="tab-btn active" onclick="switchTab('info', this)">
            <i class="bi bi-person-fill"></i> Informasi Akun
        </button>
        <button class="tab-btn" onclick="switchTab('password', this)">
            <i class="bi bi-shield-lock-fill"></i> Ubah Password
        </button>
    </div>

    {{-- TAB 1: Informasi Akun (Nama & Email) --}}
    <div id="tab-info" class="tab-pane active">
        <div class="card-clean">
            <div class="card-section-title">
                <div class="title-icon"><i class="bi bi-person-fill"></i></div>
                Data Akun
            </div>

            <form id="formInfo" action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="form_type" value="info">

                <div class="mb-4">
                    <label class="form-label-custom">
                        <i class="bi bi-person text-danger"></i> Nama Lengkap
                    </label>
                    <input type="text"
                           name="name"
                           id="inputName"
                           class="form-control form-control-custom @error('name') border-danger @enderror"
                           value="{{ old('name', Auth::user()->name) }}"
                           required>
                    @error('name')
                        <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label-custom">
                        <i class="bi bi-envelope text-danger"></i> Alamat Email
                    </label>
                    <input type="email"
                           name="email"
                           class="form-control form-control-custom @error('email') border-danger @enderror"
                           value="{{ old('email', Auth::user()->email) }}"
                           placeholder="email@domain.com">
                    @error('email')
                        <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                    <div class="form-text text-muted small mt-2">
                        <i class="bi bi-info-circle"></i> Digunakan untuk notifikasi dan pemulihan akun.
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label-custom">
                        <i class="bi bi-image text-danger"></i> Foto Profil
                    </label>
                    <input type="file" name="photo" class="form-control form-control-custom w-100" accept="image/jpeg,image/png">
                    <div class="form-text text-muted small mt-2">Format: JPG, PNG. Maksimal 2MB.</div>
                </div>

                <hr class="form-divider">

                <div class="action-buttons">
                    <button type="submit" class="btn-custom btn-save" id="btnSaveInfo">
                        <i class="bi bi-check-lg"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- TAB 2: Ubah Password --}}
    <div id="tab-password" class="tab-pane">
        <div class="card-clean">
            <div class="card-section-title">
                <div class="title-icon"><i class="bi bi-shield-lock-fill"></i></div>
                Ubah Password
            </div>

            <div class="warning-note mb-4">
                <i class="bi bi-exclamation-triangle-fill" style="margin-top:2px; flex-shrink:0;"></i>
                <div>
                    Pastikan password baru memiliki minimal <strong>8 karakter</strong> dan kombinasi huruf serta angka agar akun Anda lebih aman.
                </div>
            </div>

            <form id="formPassword" action="{{ route('admin.profil.password') }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Password Lama --}}
                <div class="mb-4">
                    <label class="form-label-custom">
                        <i class="bi bi-lock text-danger"></i> Password Saat Ini
                    </label>
                    <div class="password-wrapper">
                        <input type="password"
                               name="current_password"
                               id="currentPassword"
                               class="form-control form-control-custom @error('current_password') border-danger @enderror"
                               placeholder="Masukkan password saat ini"
                               required>
                        <button type="button" class="password-toggle" onclick="togglePassword('currentPassword', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('current_password')
                        <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <hr class="form-divider">

                {{-- Password Baru --}}
                <div class="mb-4">
                    <label class="form-label-custom">
                        <i class="bi bi-lock-fill text-danger"></i> Password Baru
                    </label>
                    <div class="password-wrapper">
                        <input type="password"
                               name="password"
                               id="newPassword"
                               class="form-control form-control-custom @error('password') border-danger @enderror"
                               placeholder="Minimal 8 karakter"
                               oninput="checkStrength(this.value)"
                               required>
                        <button type="button" class="password-toggle" onclick="togglePassword('newPassword', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="strength-bar mt-2">
                        <div class="strength-fill" id="strengthFill"></div>
                    </div>
                    <div class="strength-text" id="strengthText" style="color: var(--text-muted);">Ketik password untuk melihat kekuatannya</div>
                    @error('password')
                        <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-4">
                    <label class="form-label-custom">
                        <i class="bi bi-lock-fill text-danger"></i> Konfirmasi Password Baru
                    </label>
                    <div class="password-wrapper">
                        <input type="password"
                               name="password_confirmation"
                               id="confirmPassword"
                               class="form-control form-control-custom"
                               placeholder="Ulangi password baru"
                               oninput="checkMatch()"
                               required>
                        <button type="button" class="password-toggle" onclick="togglePassword('confirmPassword', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="strength-text" id="matchText" style="color: var(--text-muted);">—</div>
                </div>

                <hr class="form-divider">

                <div class="action-buttons">
                    <button type="submit" class="btn-custom btn-danger" id="btnSavePassword">
                        <i class="bi bi-shield-check"></i> Perbarui Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Info Note --}}
    <div class="info-note mb-4">
        <i class="bi bi-info-circle-fill fs-5 mt-1"></i>
        <div>
            <strong>Catatan Penting</strong><br>
            Perubahan pada NIP atau Unit Kerja hanya dapat dilakukan oleh Administrator Utama. Hubungi admin jika terdapat kesalahan data kepegawaian.
        </div>
    </div>

    {{-- Logout --}}
    <div class="action-buttons">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-custom btn-logout">
                <i class="bi bi-box-arrow-right"></i> Log Out
            </button>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // ─── Tab Switching ───────────────────────────────────────
    function switchTab(tab, btn) {
        document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.getElementById('tab-' + tab).classList.add('active');
        btn.classList.add('active');
    }

    // ─── Toggle Password Visibility ──────────────────────────
    function togglePassword(id, btn) {
        const input = document.getElementById(id);
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        btn.querySelector('i').className = isHidden ? 'bi bi-eye-slash' : 'bi bi-eye';
    }

    // ─── Password Strength Checker ───────────────────────────
    function checkStrength(val) {
        const fill = document.getElementById('strengthFill');
        const text = document.getElementById('strengthText');
        let score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const levels = [
            { pct: '0%',   color: '#E5E7EB', label: '' },
            { pct: '25%',  color: '#EF4444', label: '⚠ Lemah' },
            { pct: '50%',  color: '#F59E0B', label: '~ Cukup' },
            { pct: '75%',  color: '#3B82F6', label: '✓ Kuat' },
            { pct: '100%', color: '#10B981', label: '✓ Sangat Kuat' },
        ];

        const lvl = val.length === 0 ? levels[0] : levels[score] || levels[1];
        fill.style.width = lvl.pct;
        fill.style.backgroundColor = lvl.color;
        text.textContent = val.length === 0 ? 'Ketik password untuk melihat kekuatannya' : lvl.label;
        text.style.color = lvl.color === '#E5E7EB' ? 'var(--text-muted)' : lvl.color;

        checkMatch();
    }

    // ─── Password Match Checker ──────────────────────────────
    function checkMatch() {
        const pw  = document.getElementById('newPassword').value;
        const cpw = document.getElementById('confirmPassword').value;
        const txt = document.getElementById('matchText');
        if (!cpw) { txt.textContent = '—'; txt.style.color = 'var(--text-muted)'; return; }
        if (pw === cpw) {
            txt.textContent = '✓ Password cocok';
            txt.style.color = '#10B981';
        } else {
            txt.textContent = '✗ Password tidak cocok';
            txt.style.color = '#EF4444';
        }
    }

    // ─── Button Loading State ─────────────────────────────────
    function setLoading(btn, isLoading, originalHTML) {
        if (isLoading) {
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
            btn.disabled = true;
        } else {
            btn.innerHTML = originalHTML;
            btn.disabled = false;
        }
    }

    // ─── Show Floating Alert ──────────────────────────────────
    function showAlert(type, message) {
        const el = document.getElementById(type === 'success' ? 'alertSuccess' : 'alertError');
        const textEl = document.getElementById(type === 'success' ? 'alertSuccessText' : 'alertErrorText');
        textEl.textContent = message;
        el.classList.add('show');
        setTimeout(() => el.classList.remove('show'), 3500);
    }

    // ─── Form Submit: Info ────────────────────────────────────
    document.getElementById('formInfo').addEventListener('submit', function(e) {
        // Allow normal form submission; show loading state
        const btn = document.getElementById('btnSaveInfo');
        const orig = btn.innerHTML;
        setLoading(btn, true, orig);
        // Form akan submit biasa ke server
        // Jika ingin AJAX, uncomment kode di bawah:
        /*
        e.preventDefault();
        const data = new FormData(this);
        fetch(this.action, { method: 'POST', body: data, headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
            .then(r => r.json())
            .then(res => {
                setLoading(btn, false, orig);
                if (res.success) {
                    document.getElementById('bannerName').textContent = res.name;
                    document.getElementById('bannerInitial').textContent = res.initial;
                    showAlert('success', 'Profil berhasil diperbarui!');
                } else {
                    showAlert('error', res.message || 'Terjadi kesalahan.');
                }
            }).catch(() => { setLoading(btn, false, orig); showAlert('error', 'Koneksi gagal.'); });
        */
    });

    // ─── Form Submit: Password ────────────────────────────────
    document.getElementById('formPassword').addEventListener('submit', function(e) {
        const pw  = document.getElementById('newPassword').value;
        const cpw = document.getElementById('confirmPassword').value;
        if (pw !== cpw) {
            e.preventDefault();
            showAlert('error', 'Konfirmasi password tidak cocok!');
            return;
        }
        const btn = document.getElementById('btnSavePassword');
        const orig = btn.innerHTML;
        setLoading(btn, true, orig);
    });

    // ─── Auto-open tab if there are errors ───────────────────
    @if ($errors->has('current_password') || $errors->has('password'))
        switchTab('password', document.querySelectorAll('.tab-btn')[1]);
    @endif

    @if ($errors->has('name') || $errors->has('email'))
        switchTab('info', document.querySelectorAll('.tab-btn')[0]);
    @endif

    // ─── Flash success animation on load ─────────────────────
    @if (session('success'))
        document.addEventListener('DOMContentLoaded', () => showAlert('success', '{{ session('success') }}'));
    @endif
    @if (session('error'))
        document.addEventListener('DOMContentLoaded', () => showAlert('error', '{{ session('error') }}'));
    @endif
</script>
@endpush