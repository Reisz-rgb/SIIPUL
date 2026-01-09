<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - SIIPUL</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-custom-red { background-color: #961E1E; }
        .text-custom-red { color: #961E1E; }
        .input-gray { background-color: #fff; border: 1px solid #d1d5db; }
        .input-gray:focus { outline: 2px solid #961E1E; border-color: #961E1E; }
    </style>
</head>
<body class="bg-white flex flex-col min-h-screen">

    <div class="bg-custom-red py-8 rounded-b-[30px] shadow-lg flex flex-col items-center justify-center">
        <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo Kab Semarang" class="h-16 w-auto mb-2 drop-shadow-md">
        <h1 class="text-white font-bold text-2xl tracking-wide">SIIPUL</h1>
        <p class="text-white/80 text-sm font-light">Sistem Informasi Cuti Pegawai</p>
    </div>

    <div class="flex-grow flex items-center justify-center px-6 py-8">
        <div class="w-full max-w-md bg-white">
            
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-slate-800 mb-3">Lupa Password?</h2>
                <p class="text-slate-500 text-sm leading-relaxed px-4">
                    Masukkan Nomor HP anda yang terdaftar untuk menerima link reset password.
                </p>
            </div>

            <form action="{{ url('/link-reset-terkirim') }}" method="GET"> 
                
                <div class="mb-8">
                    <label class="block text-slate-600 text-sm font-bold mb-2">
                        Nomor HP: <span class="text-red-500">*</span>
                    </label>
                    <input type="text" class="w-full px-5 py-3 rounded-lg border border-gray-300 text-slate-700 placeholder-slate-300 font-medium focus:outline-none focus:ring-2 focus:ring-[#961E1E]" placeholder="08xxxxx">
                </div>

                <button type="submit" class="w-full bg-custom-red text-white font-bold py-3.5 rounded-xl shadow-lg shadow-red-900/20 hover:bg-[#7a1818] transition duration-300 mb-8">
                    Kirim Link Reset
                </button>

            </form>

            <div class="text-center">
                <a href="{{ url('/') }}" class="text-slate-500 hover:text-custom-red text-sm flex items-center justify-center gap-2 transition font-medium">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Halaman Utama
                </a>
            </div>

        </div>
    </div>

    <footer class="py-6 text-center text-[10px] text-slate-400">
        &copy; 2026 &nbsp; Disdikbudpora Kabupaten Semarang
    </footer>

</body>
</html>