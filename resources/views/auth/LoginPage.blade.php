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

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Info untuk pegawai baru --}}
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-blue-800">
                            <strong>Pegawai Baru?</strong> Login menggunakan NIP Anda sebagai password.<br>
                            Setelah login, segera ubah password di menu Profil.
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('login.process') }}" method="POST">
                @csrf
                
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">NIP</label>
                    <input type="text" 
                           name="nip"
                           value="{{ old('nip') }}"
                           class="w-full px-4 py-3 bg-gray-200 border-transparent rounded-lg focus:bg-white focus:ring-2 focus:ring-[#9E2A2B] focus:outline-none transition placeholder-gray-400 font-medium @error('nip') border-red-500 @enderror" 
                           placeholder="19XXXXX"
                           required>
                </div>

                <div class="mb-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" 
                           name="password"
                           class="w-full px-4 py-3 bg-gray-200 border-transparent rounded-lg focus:bg-white focus:ring-2 focus:ring-[#9E2A2B] focus:outline-none transition placeholder-gray-400 font-medium @error('password') border-red-500 @enderror" 
                           placeholder="********"
                           required>
                </div>

                <div class="flex justify-end mb-8">
                    <a href="{{ route('password.request') }}" class="text-sm font-bold text-[#9E2A2B] hover:underline">
                        Lupa Password?
                    </a>
                </div>

                <button type="submit" class="w-full bg-[#9E2A2B] text-white font-bold py-3 rounded-lg hover:bg-red-800 transition shadow-md">
                    Masuk
                </button>
            </form>

            <div class="mt-6 text-center text-sm text-gray-600">
                <a href="{{ route('panduan.login') }}" class="text-[#9E2A2B] font-bold hover:underline">
                    Lihat Panduan Login
                </a>
            </div>

            <div class="mt-6 text-center text-sm text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-[#9E2A2B] font-bold hover:underline">
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