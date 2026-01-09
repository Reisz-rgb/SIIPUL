<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIIPUL - Disdikbudpora Kab. Semarang</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .bg-custom-red {
            background-color: #961E1E; 
        }
        .text-custom-red {
            color: #961E1E;
        }
        .dashed-circle {
            background-image: url("data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' rx='1000' ry='1000' stroke='rgba(255,255,255,0.2)' stroke-width='2' stroke-dasharray='6%2c 14' stroke-dashoffset='0' stroke-linecap='square'/%3e%3c/svg%3e");
            border-radius: 50%;
        }
    </style>
</head>
<body class="bg-white flex flex-col min-h-screen">

    <div class="bg-custom-red relative w-full h-[65vh] flex items-center justify-center overflow-hidden">
        
        <div class="absolute w-[600px] h-[600px] border border-white/10 rounded-full flex items-center justify-center">
            <div class="w-[500px] h-[500px] dashed-circle flex items-center justify-center">
                <div class="w-[350px] h-[350px] border border-white/20 rounded-full"></div>
            </div>
        </div>

        <div class="relative w-[400px] h-[400px] flex items-center justify-center">
            <div class="bg-white rounded-full w-48 h-48 flex flex-col items-center justify-center shadow-xl z-10 relative">
                <h2 class="text-custom-red font-bold text-center leading-tight">
                    Pengelolaan <br> Cuti Pegawai
                </h2>
                <span class="text-gray-400 text-xs mt-1">SIIPUL</span>
            </div>

            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-4 flex flex-col items-center z-20">
                <div class="relative">
                    <div class="bg-white w-16 h-16 rounded-full flex items-center justify-center shadow-lg text-custom-red font-bold text-xl">1</div>
                    <i class="fa-solid fa-file-lines text-yellow-400 absolute -top-1 -right-2 text-lg"></i>
                </div>
                <div class="bg-white px-4 py-1 rounded-full mt-2 shadow-md">
                    <span class="text-custom-red font-bold text-sm">Pengajuan</span>
                </div>
            </div>

            <div class="absolute right-0 top-1/2 transform translate-x-4 -translate-y-1/2 flex flex-col items-center z-20">
                <div class="relative">
                    <div class="bg-white w-16 h-16 rounded-full flex items-center justify-center shadow-lg text-custom-red font-bold text-xl">2</div>
                    <i class="fa-solid fa-magnifying-glass text-yellow-400 absolute -top-1 -right-2 text-lg"></i>
                </div>
                <div class="bg-white px-4 py-1 rounded-full mt-2 shadow-md">
                    <span class="text-custom-red font-bold text-sm">Verifikasi</span>
                </div>
            </div>

            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-8 flex flex-col items-center z-20">
                <div class="bg-white px-4 py-1 rounded-full mb-2 shadow-md">
                    <span class="text-custom-red font-bold text-sm">Persetujuan</span>
                </div>
                <div class="relative">
                    <div class="bg-white w-16 h-16 rounded-full flex items-center justify-center shadow-lg text-custom-red font-bold text-xl">3</div>
                    <i class="fa-solid fa-check text-yellow-400 absolute -top-1 -right-2 text-lg"></i>
                </div>
            </div>

            <div class="absolute left-0 top-1/2 transform -translate-x-4 -translate-y-1/2 flex flex-col items-center z-20">
                <div class="relative">
                    <div class="bg-white w-16 h-16 rounded-full flex items-center justify-center shadow-lg text-custom-red font-bold text-xl">4</div>
                    <i class="fa-solid fa-calendar-check text-yellow-400 absolute -top-1 -right-2 text-lg"></i>
                </div>
                <div class="bg-white px-4 py-1 rounded-full mt-2 shadow-md">
                    <span class="text-custom-red font-bold text-sm">Selesai</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white flex-1 flex flex-col items-center justify-start pt-8 pb-12 px-4">
        
        <div class="mb-4">
            <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo Kabupaten Semarang" class="h-16 w-auto object-contain">
        </div>

        <h1 class="text-4xl font-bold text-slate-700 tracking-wide mb-1">SIIPUL</h1>
        <p class="text-xs text-slate-500 mb-6 uppercase tracking-wider font-semibold">Sistem Informasi Cuti</p>

        <h2 class="text-xl font-bold text-custom-red mb-8">Disdikbudpora Kab. Semarang</h2>

        <div class="w-full max-w-md border-t border-gray-100 mb-6"></div>

        <p class="text-slate-400 text-sm mb-6">Silahkan login/register melalui Aplikasi SIIPUL</p>

        <a href="{{ url('/dashboard') }}" class="bg-custom-red hover:bg-[#7a1818] text-white font-bold py-3 px-24 rounded-lg shadow-lg shadow-red-900/20 transition duration-300">
            ke SIIPUL
        </a>

    </div>

    <footer class="bg-custom-red text-white py-4 text-center text-xs font-light">
        &copy; 2026 &nbsp; Disdikbudpora Kab. Semarang
    </footer>

</body>
</html>