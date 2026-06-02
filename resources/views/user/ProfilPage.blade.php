@extends('layouts.user')

@section('title', 'Profil Saya')
@section('page_title', 'Profil')
@section('page_subtitle', 'Periksa dan kelola informasi akun Anda.')

@push('head')
<style>
    .user-profile-shell {
        max-width: 800px;
        margin: 0 auto;
    }

    .user-profile-banner {
        background: linear-gradient(135deg, var(--maroon) 0%, var(--maroon-dark) 100%);
        color: #fff;
        border-radius: 18px;
        padding: 30px;
        display: flex;
        align-items: center;
        gap: 22px;
        margin-bottom: 22px;
        box-shadow: 0 16px 32px -12px rgba(158, 42, 43, .45);
    }

    .user-profile-avatar {
        width: 86px;
        height: 86px;
        border-radius: 999px;
        background: #fff;
        color: var(--maroon);
        border: 3px solid rgba(255,255,255,.95);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.9rem;
        font-weight: 800;
        flex-shrink: 0;
        box-shadow: 0 8px 18px rgba(0,0,0,.18);
    }

    .user-profile-name {
        font-size: 1.45rem;
        line-height: 1.2;
        font-weight: 800;
        margin: 0 0 8px;
    }

    .user-profile-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        color: rgba(255,255,255,.78);
        font-size: .88rem;
        font-weight: 600;
    }

    .user-role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 999px;
        background: rgba(255,255,255,.18);
        border: 1px solid rgba(255,255,255,.28);
        color: #fff;
        font-size: .8rem;
        font-weight: 800;
        backdrop-filter: blur(5px);
    }

    .user-profile-tabs {
        display: flex;
        gap: 6px;
        background: #fff;
        border: 1px solid #E5E7EB;
        border-radius: 14px;
        padding: 6px;
        margin-bottom: 20px;
        box-shadow: 0 8px 22px -18px rgba(15, 23, 42, .45);
    }

    .user-profile-tab {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 14px;
        border-radius: 10px;
        color: #64748B;
        font-size: .88rem;
        font-weight: 800;
        text-decoration: none;
        transition: .18s ease;
    }

    .user-profile-tab:hover {
        background: #F8FAFC;
        color: #1F2937;
    }

    .user-profile-tab.active {
        background: var(--maroon);
        color: #fff;
        box-shadow: 0 8px 16px -10px rgba(158,42,43,.65);
    }

    .user-profile-card {
        background: #fff;
        border: 1px solid #E5E7EB;
        border-radius: 18px;
        padding: 30px;
        margin-bottom: 22px;
        box-shadow: 0 12px 26px -22px rgba(15,23,42,.55);
    }

    .user-profile-card-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding-bottom: 18px;
        margin-bottom: 22px;
        border-bottom: 1px solid #F1F5F9;
    }

    .user-profile-card-title h3 {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
        font-size: 1.02rem;
        font-weight: 800;
        color: #111827;
    }

    .user-title-icon {
        width: 36px;
        height: 36px;
        border-radius: 11px;
        background: #FEF2F2;
        color: var(--maroon);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .user-info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .user-info-item {
        min-height: 88px;
        border: 1px solid #E5E7EB;
        background: #F9FAFB;
        border-radius: 14px;
        padding: 18px;
    }

    .user-info-item.warning {
        border-color: #FDE68A;
        background: #FFFBEB;
    }

    .user-info-label {
        margin: 0 0 8px;
        color: #94A3B8;
        font-size: .72rem;
        letter-spacing: .055em;
        text-transform: uppercase;
        font-weight: 800;
    }

    .user-info-value {
        margin: 0;
        color: #334155;
        font-size: 1rem;
        font-weight: 800;
        word-break: break-word;
    }

    .user-info-help {
        margin: 8px 0 0;
        color: #B45309;
        font-size: .78rem;
        font-weight: 650;
    }

    .user-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 18px;
        font-weight: 750;
        border: 1px solid transparent;
    }

    .user-alert.success {
        background: #ECFDF5;
        color: #047857;
        border-color: #A7F3D0;
    }

    .user-alert.error {
        background: #FEF2F2;
        color: #B91C1C;
        border-color: #FECACA;
    }

    .user-profile-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 22px;
    }

    .user-btn {
        border: 0;
        text-decoration: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 20px;
        border-radius: 10px;
        font-size: .92rem;
        font-weight: 800;
        transition: .18s ease;
    }

    .user-btn-primary {
        background: var(--maroon);
        color: #fff;
    }

    .user-btn-primary:hover {
        background: var(--maroon-dark);
        color: #fff;
        transform: translateY(-1px);
    }

    .user-btn-secondary {
        background: #fff;
        color: #475569;
        border: 1px solid #E5E7EB;
    }

    .user-btn-secondary:hover {
        background: #F8FAFC;
        color: #1E293B;
    }

    .user-btn-danger {
        background: #fff;
        color: #DC2626;
        border: 1px solid #FECACA;
    }

    .user-btn-danger:hover {
        background: #FEF2F2;
        color: #B91C1C;
    }

    .user-note {
        display: flex;
        gap: 12px;
        background: #EFF6FF;
        border: 1px solid #DBEAFE;
        color: #1E40AF;
        border-radius: 14px;
        padding: 18px;
        line-height: 1.6;
        font-size: .9rem;
        font-weight: 600;
    }

    @media (max-width: 640px) {
        .user-profile-banner {
            flex-direction: column;
            text-align: center;
            padding: 24px 20px;
        }

        .user-profile-meta {
            justify-content: center;
        }

        .user-profile-card {
            padding: 22px;
        }

        .user-info-grid {
            grid-template-columns: 1fr;
        }

        .user-profile-card-title {
            align-items: flex-start;
            flex-direction: column;
        }

        .user-btn,
        .user-profile-actions form {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
    @php
        $authUser = $user ?? auth()->user();
        $name = trim($authUser->name ?? 'User');
        $nameParts = preg_split('/\s+/', $name);
        $initials = strtoupper(substr($nameParts[0] ?? 'U', 0, 1) . substr($nameParts[1] ?? '', 0, 1));
        $initials = $initials ?: 'U';
    @endphp

    <div class="user-profile-shell">
        <section class="user-profile-banner">
            <div class="user-profile-avatar">{{ $initials }}</div>
            <div>
                <h2 class="user-profile-name">{{ $authUser->name ?? '-' }}</h2>
                <div class="user-profile-meta">
                    <span class="user-role-badge">
                        <i class="bi bi-person-badge-fill"></i>
                        {{ ucfirst($authUser->role ?? 'Pegawai') }}
                    </span>
                    <span>{{ $authUser->jabatan ?? 'Pegawai' }}</span>
                    <span>•</span>
                    <span>{{ $authUser->bidang_unit ?? 'Kabupaten Semarang' }}</span>
                </div>
            </div>
        </section>

        @if (session('status') === 'sukses')
            <div class="user-alert success">
                <i class="bi bi-check-circle-fill"></i>
                Profil berhasil diperbarui!
            </div>
        @elseif (session('status') === 'password_updated')
            <div class="user-alert success">
                <i class="bi bi-check-circle-fill"></i>
                Password berhasil diperbarui!
            </div>
        @endif

        @if (session('success'))
            <div class="user-alert success">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="user-alert error">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        <nav class="user-profile-tabs" aria-label="Navigasi profil">
            <a href="{{ route('user.profil') }}" class="user-profile-tab active">
                <i class="bi bi-person-fill"></i>
                Informasi Akun
            </a>
            <a href="{{ route('user.password.change') }}" class="user-profile-tab">
                <i class="bi bi-shield-lock-fill"></i>
                Ubah Password
            </a>
        </nav>

        <section class="user-profile-card">
            <div class="user-profile-card-title">
                <h3>
                    <span class="user-title-icon"><i class="bi bi-person-fill"></i></span>
                    Data Akun
                </h3>
                <a href="{{ route('user.profil.edit') }}" class="user-btn user-btn-primary">
                    <i class="bi bi-pencil-square"></i>
                    Edit Profil
                </a>
            </div>

            <div class="user-info-grid">
                <div class="user-info-item">
                    <p class="user-info-label">Nama Lengkap</p>
                    <p class="user-info-value">{{ $authUser->name ?? '-' }}</p>
                </div>

                <div class="user-info-item {{ empty($authUser->email) ? 'warning' : '' }}">
                    <p class="user-info-label">Email</p>
                    @if(empty($authUser->email))
                        <p class="user-info-value text-amber-700">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            Belum diisi
                        </p>
                        <p class="user-info-help">Diperlukan untuk fitur lupa password.</p>
                    @else
                        <p class="user-info-value">{{ $authUser->email }}</p>
                    @endif
                </div>

                <div class="user-info-item">
                    <p class="user-info-label">No. HP</p>
                    <p class="user-info-value">{{ $authUser->phone ?? 'Belum diisi' }}</p>
                </div>

                <div class="user-info-item">
                    <p class="user-info-label">NIP</p>
                    <p class="user-info-value">{{ $authUser->nip ?? '-' }}</p>
                </div>

                <div class="user-info-item">
                    <p class="user-info-label">Jabatan</p>
                    <p class="user-info-value">{{ $authUser->jabatan ?? '-' }}</p>
                </div>

                <div class="user-info-item">
                    <p class="user-info-label">Bidang / Unit</p>
                    <p class="user-info-value">{{ $authUser->bidang_unit ?? '-' }}</p>
                </div>
            </div>

            <div class="user-profile-actions">
                <a href="{{ route('user.password.change') }}" class="user-btn user-btn-secondary">
                    <i class="bi bi-shield-lock-fill"></i>
                    Ubah Password
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="user-btn user-btn-danger">
                        <i class="bi bi-box-arrow-right"></i>
                        Log Out
                    </button>
                </form>
            </div>
        </section>

        <div class="user-note">
            <i class="bi bi-info-circle-fill text-lg mt-1"></i>
            <div>
                <strong>Catatan Penting</strong><br>
                Perubahan pada NIP atau data kepegawaian utama hanya dapat dilakukan oleh administrator. Hubungi admin jika terdapat kesalahan data.
            </div>
        </div>
    </div>
@endsection
