<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - DISDIKBUDPORA Kab. Semarang</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .bg-custom-red {
            background-color: #961E1E; /* Merah Marun Khas */
        }
        .text-custom-red {
            color: #961E1E;
        }
        .hover-bg-red:hover {
            background-color: #7a1818;
        }
    </style>
</head>
<body class="bg-white flex flex-col min-h-screen">

    <nav class="bg-custom-red text-white py-3 px-6 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo Kab Semarang" class="h-10 w-auto">
                <div class="leading-tight">
                    <h1 class="font-bold text-lg tracking-wide">DISDIKBUDPORA</h1>
                    <p class="text-[10px] font-light tracking-wider uppercase">Kab. Semarang</p>
                </div>
            </div>

            <a href="{{ url('/login') }}" class="bg-white text-custom-red px-4 py-2 rounded shadow-sm text-sm font-bold flex items-center gap-2 hover:bg-gray-100 transition">
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                Login/Register
            </a>
        </div>
    </nav>

    <main class="flex-grow">
        
        <div class="container mx-auto px-4 py-12 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-custom-red mb-2">Selamat Datang di Aplikasi</h2>
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-8">SIIPUL</h1>

            <div class="flex justify-center mb-6">
                <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo Besar" class="h-32 w-auto drop-shadow-md">
            </div>

            <h3 class="font-bold text-slate-700 text-lg mb-2">Sistem Informasi Izin dan Cuti Pegawai</h3>
            <p class="text-slate-500 max-w-2xl mx-auto leading-relaxed text-sm md:text-base">
                Disdikbudpora Kab. Semarang. Aplikasi resmi untuk pengajuan dan pengelolaan izin cuti pegawai di lingkungan Dinas Pendidikan, Kebudayaan, Kepemudaan dan Olahraga.
            </p>
        </div>

        <div class="bg-gray-50 py-16">
            <div class="container mx-auto px-4 text-center">
                
                <h3 class="text-2xl font-bold text-custom-red mb-2">Layanan Kami</h3>
                <div class="w-16 h-1 bg-custom-red mx-auto mb-4 rounded"></div>
                <p class="text-slate-500 text-sm mb-12">Silakan pilih layanan yang tersedia di bawah ini untuk memulai pengajuan.</p>

                <div class="flex justify-center">
                    
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 p-8 w-full max-w-sm border border-gray-100">
                        <div class="flex justify-center mb-6">
                            <div class="w-20 h-20 bg-red-50 rounded-2xl flex items-center justify-center">
                                <i class="fa-regular fa-calendar-days text-3xl text-custom-red"></i>
                            </div>
                        </div>

                        <h4 class="text-xl font-bold text-slate-800 mb-3">Pengajuan Cuti</h4>
                        <p class="text-slate-500 text-sm mb-8 leading-relaxed">
                            Layanan pengajuan berbagai jenis cuti pegawai secara online, cepat, dan terintegrasi.
                        </p>

                        <a href="{{ url('/login') }}" class="block w-full bg-custom-red text-white font-bold py-3 rounded-lg hover-bg-red transition flex items-center justify-center gap-2">
                            Ajukan Sekarang 
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </main>

    <footer class="bg-custom-red text-white py-6 mt-auto">
        <div class="container mx-auto px-4 flex flex-col md:flex-row justify-between items-center text-xs font-light opacity-90">
            <p>&copy; 2026</p>
            <p class="mt-2 md:mt-0 text-center">Dinas Pendidikan, Kebudayaan, Kepemudaan dan Olahraga Kabupaten Semarang</p>
        </div>
    </footer>

</body>
</html>