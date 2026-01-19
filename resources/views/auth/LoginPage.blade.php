<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIIPUL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen py-10">

    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden relative">
        
        <div class="bg-[#9E2A2B] p-8 text-center text-white">
            <div class="flex justify-center mb-3">
                <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo Kab Semarang" class="h-16 w-auto object-contain drop-shadow-sm">
            </div>
            <h1 class="text-2xl font-bold tracking-wide">SIIPUL</h1>
            <p class="text-sm font-light opacity-90">Sistem Informasi Cuti Pegawai</p>
        </div>

        <div class="p-8">
            
            <div class="mb-4">
                <a href="{{ route('landing') }}" class="text-gray-500 hover:text-[#9E2A2B] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
            </div>

            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Login Pegawai</h2>
                <p class="text-sm text-gray-500 mt-1">Silakan masuk menggunakan akun Anda</p>
            </div>

            <form action="{{ route('login.process') }}" method="POST">
                @csrf
                
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">NIP</label>
                    <input type="text" 
                           class="w-full px-4 py-3 bg-gray-200 border-transparent rounded-lg focus:bg-white focus:ring-2 focus:ring-[#9E2A2B] focus:outline-none transition placeholder-gray-400 font-medium" 
                           placeholder="19XXXXX">
                </div>

                <div class="mb-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" 
                           class="w-full px-4 py-3 bg-gray-200 border-transparent rounded-lg focus:bg-white focus:ring-2 focus:ring-[#9E2A2B] focus:outline-none transition placeholder-gray-400 font-medium" 
                           placeholder="********">
                </div>

                <div class="flex justify-end mb-8">
                    <a href="{{ url('/lupa-password') }}" class="text-sm font-bold text-[#9E2A2B] hover:underline">
                        Lupa Password?
                    </a>
                </div>

                <button type="submit" class="w-full bg-[#9E2A2B] text-white font-bold py-3 rounded-lg hover:bg-red-800 transition shadow-md">
                    Masuk
                </button>
            </form>

            <div class="mt-6 text-center text-sm text-gray-600">
                Belum punya akun? 
                <a href="{{ url('/register') }}" class="text-[#9E2A2B] font-bold hover:underline">
                    Daftar Sekarang
                </a>
            </div>

            <div class="mt-12 text-center">
                <p class="text-xs text-gray-400">
                    © 2026 &nbsp; Disdikbudpora Kabupaten Semarang
                </p>
            </div>

        </div>
    </div>

</body>
</html>