<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pegawai - SIIPUL</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-custom-red { background-color: #961E1E; }
        .text-custom-red { color: #961E1E; }
        .input-gray { background-color: #EAEAEA; }
        .input-gray:focus { outline: 2px solid #961E1E; background-color: #fff; }
    </style>
</head>
<body class="bg-white flex flex-col min-h-screen">

    <div class="bg-custom-red py-8 rounded-b-[30px] shadow-lg flex flex-col items-center justify-center">
        <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo Kab Semarang" class="h-16 w-auto mb-2 drop-shadow-md">
        <h1 class="text-white font-bold text-2xl tracking-wide">SIIPUL</h1>
        <p class="text-white/80 text-sm font-light">Sistem Informasi Cuti (SIIPUL)</p>
    </div>

    <div class="flex-grow flex items-center justify-center px-6 -mt-8">
        <div class="w-full max-w-md bg-white p-4">
            
            <div class="mb-6">
                <a href="{{ url('/dashboard') }}" class="text-slate-400 hover:text-custom-red transition text-lg">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>

            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-slate-800 mb-1">Login Pegawai</h2>
                <p class="text-slate-400 text-sm">Silakan masuk menggunakan akun Anda</p>
            </div>

            <form action="{{ url('/dashboard') }}" method="GET"> 
                
                <div class="mb-5">
                    <label class="block text-slate-600 text-sm font-bold mb-2">Nomor Telepon</label>
                    <input type="text" class="w-full px-5 py-3 rounded-lg input-gray text-slate-700 placeholder-slate-300 font-medium" placeholder="08XXXXX">
                </div>

                <div class="mb-2">
                    <label class="block text-slate-600 text-sm font-bold mb-2">Password</label>
                    <input type="password" class="w-full px-5 py-3 rounded-lg input-gray text-slate-700 placeholder-slate-300 font-medium tracking-widest" placeholder="********">
                </div>

                <div class="flex justify-end mb-8">
                    <a href="{{ url('/lupa-password') }}" class="text-xs font-bold text-custom-red hover:underline">Lupa Password?</a>
                </div>

                <button type="submit" class="w-full bg-custom-red text-white font-bold py-3.5 rounded-xl shadow-lg shadow-red-900/20 hover:bg-[#7a1818] transition duration-300">
                    Masuk
                </button>

            </form>

            <div class="mt-8 text-center text-sm text-slate-400">
                <p>Belum punya akun? <a href="{{ url('/register') }}" class="text-custom-red font-bold hover:underline">Daftar Sekarang</a></p>
            </div>

        </div>
    </div>

    <footer class="py-6 text-center text-[10px] text-slate-400">
        &copy; 2026 &nbsp; Disdikbudpora Kabupaten Semarang
    </footer>

</body>
</html>