<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIIPUL - Sistem Informasi Pengajuan Cuti</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50: '#f0f9ff', 100: '#e0f2fe', 600: '#0284c7', 700: '#0369a1' },
                    }
                }
            }
        }
    </script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-white">
    <nav class="flex items-center justify-between px-8 py-6 max-w-7xl mx-auto">
        <div class="text-2xl font-bold text-primary-600">SIIPUL</div>
        <div class="space-x-4">
            <a href="{{ route('login') }}" class="text-slate-600 font-medium hover:text-primary-600">Masuk</a>
            <a href="{{ route('register') }}" class="bg-primary-600 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-primary-700 transition">Daftar Sekarang</a>
        </div>
    </nav>

    @yield('content')

    <footer class="py-12 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-8 text-center text-slate-500 text-sm">
            &copy; 2026 SIIPUL - Manajemen Cuti Pegawai Modern.
        </div>
    </footer>
</body>
</html>