<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - SIIPUL</title>
    
    {{-- Font & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #991b1b; /* Merah Tua Header */
            --input-bg: #e8e6e6; /* Abu-abu kolom input */
            --text-main: #1f2937;
            --text-muted: #6b7280;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        
        body { 
            background-color: #ffffff; 
            color: var(--text-main); 
            min-height: 100vh; 
            display: flex; 
            flex-direction: column; 
        }

        /* --- HEADER SECTION (MERAH) --- */
        .header-hero {
            background-color: var(--primary);
            color: white;
            padding: 40px 20px;
            text-align: center;
            border-bottom-left-radius: 0; 
            border-bottom-right-radius: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .logo-img {
            height: 60px; /* Sesuaikan ukuran logo */
            width: auto;
            margin-bottom: 10px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }

        .app-title {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .app-subtitle {
            font-size: 14px;
            font-weight: 400;
            opacity: 0.9;
        }

        /* --- FORM CONTAINER --- */
        .register-container {
            width: 100%;
            max-width: 480px;
            margin: 0 auto;
            padding: 40px 25px;
            flex: 1; /* Agar footer copyright turun ke bawah */
        }

        .page-heading {
            text-align: center;
            margin-bottom: 30px;
        }

        .page-heading h2 {
            font-size: 22px;
            font-weight: 700;
            color: #111;
            margin-bottom: 8px;
        }

        .page-heading p {
            font-size: 14px;
            color: var(--text-muted);
        }

        /* --- FORM ELEMENTS --- */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        /* Style Input Abu-abu seperti gambar */
        .form-input {
            width: 100%;
            background-color: var(--input-bg);
            border: 1px solid transparent; /* Tidak ada border default */
            border-radius: 8px;
            padding: 14px 16px;
            font-size: 14px;
            color: #333;
            outline: none;
            transition: all 0.2s;
        }

        .form-input::placeholder {
            color: #a3a3a3;
            font-weight: 400;
        }

        .form-input:focus {
            background-color: #fff;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(153, 27, 27, 0.1);
        }

        /* --- BUTTONS --- */
        .btn-submit {
            width: 100%;
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            margin-bottom: 25px;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background-color: #7f1d1d;
        }

        /* --- LINKS --- */
        .auth-links {
            text-align: center;
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 40px;
        }

        .link-red {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }
        .link-red:hover { text-decoration: underline; }

        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: var(--text-muted);
            font-size: 14px;
            text-decoration: none;
            margin-top: 10px;
            transition: color 0.2s;
        }
        .back-link:hover { color: #111; }

        /* --- FOOTER COPYRIGHT --- */
        .footer-copy {
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            padding: 20px;
            margin-top: auto;
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .register-container { padding: 30px 20px; }
            .header-hero { padding: 30px 20px; }
        }
    </style>
</head>
<body>

    <div class="header-hero">
        {{-- Ganti dengan path logo Anda --}}
        <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo" class="logo-img">
        
        <h1 class="app-title">SIIPUL</h1>
        <p class="app-subtitle">Sistem Informasi Cuti (SIIPUL)</p>
    </div>

    <div class="register-container">
        
        <div class="page-heading">
            <h2>Daftar Akun Baru</h2>
            <p>Lengkapi data diri Anda untuk mendaftar</p>
        </div>
        
        {{-- Error Messages --}}
        @if ($errors->any())
            <div style="background-color: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; padding: 16px; margin-bottom: 20px;">
                @foreach ($errors->all() as $error)
                    <p style="color: #991b1b; font-size: 14px; margin-bottom: 4px;">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="page-heading">
    <h2>Daftar Akun Baru</h2>
    <p>Lengkapi data diri Anda untuk mendaftar</p>
    
    {{-- Info box --}}
    <div style="background-color: #e7f1ff; border: 1px solid #b3d7ff; border-radius: 8px; padding: 12px; margin-top: 15px; text-align: left;">
            <p style="margin: 0; font-size: 13px; color: #0c5460; line-height: 1.5;">
                <strong>Penting:</strong><br>
                1. Masukkan <strong>Nama</strong> dan <strong>NIP</strong> sesuai data pegawai yang terdaftar<br>
                2. Jika pertama kali login, gunakan <strong>NIP sebagai password</strong><br>
                3. Gunakan form ini untuk <strong>mengubah password</strong> dan <strong>mendaftarkan nomor HP</strong> Anda
            </p>
        </div>
    </div>

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-input" placeholder="Nama lengkap sesuai SK" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">NIP</label>
                <input type="text" name="nip" class="form-input" placeholder="19xxxxxxxxxxx" value="{{ old('nip') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Nomor HP / WhatsApp</label>
                <input type="text" name="phone" class="form-input" placeholder="0812xxxx" value="{{ old('phone') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input" placeholder="••••••••" required>
            </div>

            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-input" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-submit">Daftar</button>

            <div class="auth-links">
                Sudah punya akun? <a href="{{ route('login') }}" class="link-red">Masuk</a>
            </div>

            <a href="{{ url('/') }}" class="back-link">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Halaman Utama
            </a>

        </form>

    </div>

    <div class="footer-copy">
        &copy; 2026 &nbsp; Disdikbudpora Kabupaten Semarang
    </div>

</body>
</html>