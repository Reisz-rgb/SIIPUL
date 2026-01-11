<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - SIIPUL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen py-10">

    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl overflow-hidden relative">
        
        <div class="bg-[#9E2A2B] py-8 px-8 text-center text-white border-b-4 border-[#802223]">
            <div class="flex justify-center mb-3">
                <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo Kab Semarang" class="h-20 w-auto object-contain drop-shadow-md">
            </div>
            <h1 class="text-2xl font-extrabold tracking-wide mb-1">SIIPUL</h1>
            <p class="text-md font-light opacity-90">Sistem Informasi Cuti (SIIPUL)</p>
        </div>

        <div class="p-10">
            
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Daftar Akun Baru</h2>
                <p class="text-gray-500 text-md">Lengkapi data diri Anda untuk mendaftar</p>
            </div>

            <form action="" method="POST">
                @csrf
                
                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" 
                           class="w-full px-5 py-3 bg-gray-200 border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-[#9E2A2B] focus:outline-none transition placeholder-gray-400 font-semibold" 
                           placeholder="Nama lengkap sesuai SK">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-2">NIP</label>
                    <input type="number" 
                           class="w-full px-5 py-3 bg-gray-200 border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-[#9E2A2B] focus:outline-none transition placeholder-gray-400 font-semibold" 
                           placeholder="19xxxxxxxxxx">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nomor HP / WhatsApp</label>
                    <input type="text" 
                           class="w-full px-5 py-3 bg-gray-200 border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-[#9E2A2B] focus:outline-none transition placeholder-gray-400 font-semibold" 
                           placeholder="0812xxxx">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                    <input type="password" 
                           class="w-full px-5 py-3 bg-gray-200 border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-[#9E2A2B] focus:outline-none transition placeholder-gray-400 font-semibold" 
                           placeholder="********">
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password</label>
                    <input type="password" 
                           class="w-full px-5 py-3 bg-gray-200 border-transparent rounded-xl focus:bg-white focus:ring-2 focus:ring-[#9E2A2B] focus:outline-none transition placeholder-gray-400 font-semibold" 
                           placeholder="********">
                </div>

                <button type="submit" class="w-full bg-[#9E2A2B] text-white font-bold text-lg py-4 rounded-xl hover:bg-red-800 transition shadow-lg transform hover:-translate-y-0.5 mb-6">
                    Daftar
                </button>
            </form>

            <div class="text-center text-sm text-gray-600 mb-10">
                Sudah punya akun? 
                <a href="{{ url('/login') }}" class="text-[#9E2A2B] font-bold hover:underline ml-1">
                    Masuk
                </a>
            </div>

            <div class="border-t pt-6 text-center">
                <a href="{{ url('/') }}" class="inline-flex items-center text-gray-500 hover:text-[#9E2A2B] transition font-medium text-sm mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Halaman Utama
                </a>
                <p class="text-xs text-gray-400">
                    © 2026 &nbsp; Disdikbudpora Kabupaten Semarang
                </p>
            </div>

        </div>
    </div>

</body>
</html>