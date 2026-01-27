<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SIIPUL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-red: #9E2A2B;
            --bg-color: #F9FAFB; /* Abu-abu sangat muda (Gray 50) */
            --text-primary: #111827;
            --text-secondary: #6B7280;
            --border-color: #E5E7EB;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-primary);
        }

        .login-card {
            background: white;
            width: 100%;
            max-width: 400px; /* Lebar optimal agar mata nyaman */
            border-radius: 12px;
            /* Shadow super halus, tidak hitam pekat */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--border-color);
            padding: 40px;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 24px;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-control {
            background-color: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 12px 16px; /* Padding besar agar modern */
            font-size: 0.95rem;
            color: var(--text-primary);
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary-red);
            /* Glow merah tipis saat diketik */
            box-shadow: 0 0 0 4px rgba(158, 42, 43, 0.1);
        }

        .form-control::placeholder {
            color: #9CA3AF;
        }

        .btn-primary-custom {
            background-color: var(--primary-red);
            border: 1px solid transparent;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            width: 100%;
            transition: background-color 0.2s;
        }

        .btn-primary-custom:hover {
            background-color: #7f1d1d;
        }

        .link-secondary {
            color: var(--text-secondary);
            font-size: 0.875rem;
            text-decoration: none;
            transition: color 0.2s;
        }
        .link-secondary:hover {
            color: var(--primary-red);
        }

        .footer-text {
            text-align: center;
            margin-top: 32px;
            font-size: 0.75rem;
            color: #9CA3AF;
        }

        /* Alert minimalis */
        .alert-mini {
            font-size: 0.875rem;
            background-color: #FEF2F2; /* Merah sangat muda */
            border: 1px solid #FECACA;
            color: #991B1B;
            border-radius: 8px;
            padding: 12px;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="logo-container">
            <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo Kab Semarang" height="48">
        </div>

        <div class="text-center mb-5">
            <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 8px;">Masuk ke SIIPUL</h1>
            <p style="color: var(--text-secondary); font-size: 0.9rem;">Sistem Informasi Cuti Pegawai</p>
        </div>

        @if ($errors->any())
            <div class="alert-mini mb-4">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success rounded-3 p-3 mb-4" style="font-size: 0.875rem;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="form-label">Nomor Induk Pegawai</label>
                <input type="text" name="nip" class="form-control" placeholder="Masukan NIP Anda" value="{{ old('nip') }}" required autofocus>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <label class="form-label mb-0">Password</label>
                    <a href="{{ route('password.request') }}" class="link-secondary" style="font-size: 0.8rem;">Lupa password?</a>
                </div>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-primary-custom text-white">
                Masuk
            </button>
        </form>

        <div class="text-center mt-4">
            <p style="font-size: 0.875rem; color: var(--text-secondary);">
                Belum punya akun? <a href="{{ route('register') }}" class="fw-semibold text-decoration-none" style="color: var(--primary-red);">Daftar</a>
            </p>
        </div>

        <div class="footer-text">
            &copy; 2026 Disdikbudpora Kabupaten Semarang<br>
            <a href="{{ route('landing') }}" class="text-decoration-none text-muted mt-2 d-inline-block">Kembali ke Beranda</a>
        </div>
    </div>

</body>
</html>