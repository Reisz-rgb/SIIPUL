<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SIIPUL</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-custom-red { background-color: #961E1E; }
        .text-custom-red { color: #961E1E; }
        .bg-custom-dark-red { background-color: #7a1818; }
        
        /* Animasi untuk Notifikasi */
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        .toast-animate {
            animation: slideIn 0.5s ease-out forwards;
        }
        .toast-hide {
            animation: fadeOut 0.5s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen relative overflow-x-hidden">

    <nav class="bg-custom-red text-white py-4 px-6 shadow-md sticky top-0 z-50">
        <div class="container mx-auto flex items-center gap-4">
            <a href="{{ url('/dashboarduser') }}" class="text-white hover:text-gray-200 transition">
                <i class="fa-solid fa-arrow-left text-lg"></i>
            </a>
            <div class="flex items-center gap-3">
                <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo" class="h-8 w-auto">
                <h1 class="font-medium text-lg tracking-wide">Profil Saya</h1>
            </div>
        </div>
    </nav>

    <main class="flex-grow container mx-auto px-4 py-8 flex flex-col items-center">
        
        <div class="w-full max-w-2xl bg-white rounded-xl shadow-lg overflow-hidden mb-6">
            
            <div class="bg-custom-red p-6 flex flex-col md:flex-row items-center md:items-start gap-4 md:gap-6 relative">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-md shrink-0">
                    <span class="text-custom-red text-2xl font-bold">BS</span>
                </div>
                <div class="text-center md:text-left flex-grow text-white">
                    <h2 class="text-2xl font-bold">Budi Santoso</h2>
                    <p class="text-sm font-light opacity-90 mt-1">Guru Matematika</p>
                    <p class="text-xs font-light opacity-80">SMP Negeri 1 Semarang</p>
                </div>
                <a href="{{ url('/edit-profil') }}" class="bg-white text-custom-red px-4 py-2 rounded-lg text-sm font-semibold shadow hover:bg-gray-100 transition flex items-center gap-2 mt-4 md:mt-0">
                    <i class="fa-solid fa-pen"></i> Edit Profil
                </a>
            </div>

            <div class="p-6 md:p-8 space-y-6">
                <div class="flex gap-4 border-b border-gray-100 pb-4">
                    <div class="w-8 flex-shrink-0 pt-1 text-center"><i class="fa-regular fa-user text-custom-red text-lg"></i></div>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">NAMA LENGKAP</p>
                        <p class="text-slate-800 font-medium text-lg">Budi Santoso</p>
                    </div>
                </div>
                <div class="flex gap-4 border-b border-gray-100 pb-4">
                    <div class="w-8 flex-shrink-0 pt-1 text-center"><i class="fa-regular fa-envelope text-custom-red text-lg"></i></div>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">EMAIL</p>
                        <p class="text-slate-800 font-medium text-lg">budi.santoso@example.com</p>
                    </div>
                </div>
                <div class="flex gap-4 border-b border-gray-100 pb-4">
                    <div class="w-8 flex-shrink-0 pt-1 text-center"><i class="fa-solid fa-id-card text-custom-red text-lg"></i></div>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">NIP</p>
                        <p class="text-slate-800 font-medium text-lg">197801011999121001</p>
                    </div>
                </div>
                <div class="flex gap-4 border-b border-gray-100 pb-4">
                    <div class="w-8 flex-shrink-0 pt-1 text-center"><i class="fa-solid fa-briefcase text-custom-red text-lg"></i></div>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">JABATAN</p>
                        <p class="text-slate-800 font-medium text-lg">Guru Matematika</p>
                    </div>
                </div>
                <div class="flex gap-4 pb-2">
                    <div class="w-8 flex-shrink-0 pt-1 text-center"><i class="fa-regular fa-building text-custom-red text-lg"></i></div>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">SEKOLAH/UNIT KERJA</p>
                        <p class="text-slate-800 font-medium text-lg">SMP Negeri 1 Semarang</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full max-w-2xl bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h4 class="text-blue-700 font-semibold mb-2 text-sm">Catatan</h4>
            <p class="text-blue-600/80 text-xs leading-relaxed">
                Untuk mengubah data yang lebih kompleks seperti NIP atau informasi kontrak, silakan hubungi Bagian HRD. Beberapa data mungkin terlindungi dan hanya dapat diubah oleh administrator.
            </p>
        </div>

    </main>

    <footer class="bg-custom-dark-red text-white py-4 text-center text-xs mt-auto">
        &copy; 2024 | SIIPUL Disdikbudpora Kab Semarang
    </footer>

    <div id="notification-toast" class="hidden fixed bottom-16 right-4 md:bottom-10 md:right-10 bg-white border border-gray-200 shadow-2xl rounded-lg p-4 flex items-center gap-3 z-50 max-w-xs md:max-w-sm toast-animate">
        <div class="bg-black text-white rounded-full w-6 h-6 flex items-center justify-center shrink-0">
            <i class="fa-solid fa-check text-xs"></i>
        </div>
        <div class="flex-grow">
            <p class="text-sm font-semibold text-slate-800">Profil berhasil diperbarui!</p>
        </div>
        <button onclick="closeToast()" class="text-slate-400 hover:text-slate-600">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <script>
        // Cek apakah ada '?status=sukses' di URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('status') === 'sukses') {
            const toast = document.getElementById('notification-toast');
            toast.classList.remove('hidden');

            // Hilangkan notifikasi otomatis setelah 4 detik
            setTimeout(() => {
                closeToast();
            }, 4000);
        }

        function closeToast() {
            const toast = document.getElementById('notification-toast');
            toast.classList.add('toast-hide');
            setTimeout(() => {
                toast.classList.add('hidden');
                toast.classList.remove('toast-hide');
            }, 500); // Tunggu animasi selesai
        }
    </script>

</body>
</html>