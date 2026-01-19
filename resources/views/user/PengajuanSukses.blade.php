<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Berhasil - SIIPUL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-custom-red { background-color: #961E1E; }
        .text-custom-red { color: #961E1E; }
    </style>
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center px-4 relative">

    <a href="{{ route('user.dashboard') }}" class="absolute top-8 right-8 text-slate-400 hover:text-slate-600 transition">
        <i class="fa-solid fa-xmark text-2xl"></i>
    </a>

    <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12 max-w-lg w-full text-center relative animate-fade-in-up">
        
        <div class="mb-6 flex justify-center">
            <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center shadow-sm relative">
                <div class="w-16 h-16 bg-[#961E1E] rounded-full flex items-center justify-center shadow-lg animate-bounce-slow">
                    <i class="fa-solid fa-check text-white text-3xl"></i>
                </div>
                <div class="absolute inset-0 rounded-full border-4 border-red-100 animate-pulse"></div>
            </div>
        </div>

        <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mb-3">Pengajuan Berhasil!</h2>
        <p class="text-slate-500 text-sm leading-relaxed mb-8">
            Formulir cuti Anda telah berhasil diunggah ke sistem SIIPUL.
        </p>

        <div class="bg-gray-50 border border-gray-100 rounded-xl p-5 mb-8 text-left">
            <div class="flex justify-between items-center border-b border-gray-200 pb-3 mb-3">
                <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wide">
                    <i class="fa-regular fa-file-lines"></i> No. Referensi
                </div>
                <div class="text-slate-800 font-bold text-sm">CUTI-2026-5531</div>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wide">
                    <i class="fa-regular fa-clock"></i> Waktu Pengajuan
                </div>
                <div class="text-slate-800 font-bold text-xs text-right">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y H:i') }}
                </div>
            </div>
        </div>

        <p class="text-slate-400 text-[10px] mb-6 px-4">
            Notifikasi persetujuan akan dikirimkan melalui WhatsApp dan Email terdaftar.
        </p>

        <a href="{{ route('user.cuti.create') }}" class="block w-full bg-[#961E1E] hover:bg-[#7a1818] text-white font-bold py-4 rounded-xl shadow-lg transition duration-300 flex items-center justify-center gap-2">
            Buat Pengajuan Baru <i class="fa-solid fa-arrow-right"></i>
        </a>

    </div>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
        .animate-bounce-slow { animation: bounce 2s infinite; }
    </style>

</body>
</html>