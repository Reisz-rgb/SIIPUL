@extends('layouts.user')

@section('title', 'Edit Profil')
@section('page_title', 'Edit Profil')
@section('page_subtitle', 'Perbarui informasi akun Anda tanpa mengubah NIP.')

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

    .user-form-group {
        margin-bottom: 18px;
    }

    .user-form-label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        color: #64748B;
        font-size: .74rem;
        text-transform: uppercase;
        letter-spacing: .05em;
        font-weight: 800;
    }

    .user-form-control {
        width: 100%;
        border: 1px solid #E5E7EB;
        background: #F9FAFB;
        color: #1F2937;
        border-radius: 10px;
        padding: 12px 15px;
        font-weight: 700;
        outline: none;
        transition: .18s ease;
    }

    .user-form-control:focus {
        background: #fff;
        border-color: var(--maroon);
        box-shadow: 0 0 0 4px rgba(158,42,43,.10);
    }

    .user-form-control[readonly] {
        color: #64748B;
        background: #F1F5F9;
        cursor: not-allowed;
    }

    .user-form-help {
        margin-top: 7px;
        color: #94A3B8;
        font-size: .78rem;
        font-weight: 650;
    }

    .user-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 18px;
        font-weight: 700;
        border: 1px solid transparent;
        background: #FEF2F2;
        color: #B91C1C;
        border-color: #FECACA;
    }

    .user-alert ul {
        margin: 6px 0 0;
        padding-left: 18px;
    }

    .user-profile-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        justify-content: flex-end;
        padding-top: 8px;
        margin-top: 22px;
        border-top: 1px solid #F1F5F9;
    }

    .user-btn {
        border: 0;
        text-decoration: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 22px;
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

        .user-profile-card-title {
            align-items: flex-start;
            flex-direction: column;
        }

        .user-profile-actions {
            flex-direction: column;
        }

        .user-btn {
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
                    <span class="user-title-icon"><i class="bi bi-pencil-square"></i></span>
                    Edit Data Akun
                </h3>
            </div>

            @if ($errors->any())
                <div class="user-alert">
                    <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                    <div>
                        Periksa kembali input Anda.
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('user.profil.update') }}" method="POST">
                @csrf

                <div class="user-form-group">
                    <label class="user-form-label" for="name">
                        <i class="bi bi-person-fill text-red-700"></i>
                        Nama Lengkap
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $authUser->name) }}"
                           required
                           placeholder="Nama lengkap"
                           class="user-form-control @error('name') border-red-300 @enderror">
                </div>

                <div class="user-form-group">
                    <label class="user-form-label" for="email">
                        <i class="bi bi-envelope-fill text-red-700"></i>
                        Email
                    </label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email', $authUser->email) }}"
                           placeholder="Email aktif"
                           class="user-form-control @error('email') border-red-300 @enderror">
                    <p class="user-form-help">Digunakan untuk fitur lupa password dan pemulihan akun.</p>
                </div>

                <div class="user-form-group">
                    <label class="user-form-label" for="phone">
                        <i class="bi bi-telephone-fill text-red-700"></i>
                        Nomor HP
                    </label>
                    <input type="text"
                           id="phone"
                           name="phone"
                           value="{{ old('phone', $authUser->phone) }}"
                           required
                           placeholder="08xxxxxxxxxx"
                           class="user-form-control @error('phone') border-red-300 @enderror">
                </div>

                <div class="user-form-group">
                    <label class="user-form-label" for="nipReadonly">
                        <i class="bi bi-credit-card-2-front-fill text-red-700"></i>
                        NIP
                    </label>
                    <input type="text"
                           id="nipReadonly"
                           value="{{ $authUser->nip }}"
                           readonly
                           class="user-form-control">
                    <p class="user-form-help">NIP tidak dapat diubah.</p>
                </div>

                <div class="user-form-group">
                    <label class="user-form-label" for="jabatan">
                        <i class="bi bi-briefcase-fill text-red-700"></i>
                        Jabatan
                    </label>
                    <input type="text"
                           id="jabatan"
                           name="jabatan"
                           value="{{ old('jabatan', $authUser->jabatan) }}"
                           placeholder="Jabatan saat ini"
                           class="user-form-control @error('jabatan') border-red-300 @enderror">
                </div>

                <div class="user-form-group">
                    <label class="user-form-label" for="bidang_unit">
                        <i class="bi bi-building-fill text-red-700"></i>
                        Sekolah / Unit Kerja
                    </label>
                    <input type="text"
                           id="bidang_unit"
                           name="bidang_unit"
                           value="{{ old('bidang_unit', $authUser->bidang_unit) }}"
                           placeholder="Unit kerja"
                           class="user-form-control @error('bidang_unit') border-red-300 @enderror">
                </div>

                <div class="user-profile-actions">
                    <button type="submit" class="user-btn user-btn-primary">
                        <i class="bi bi-check-circle-fill"></i>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('user.profil') }}" class="user-btn user-btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
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
