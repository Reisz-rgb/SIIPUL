<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - SIIPUL</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-custom-red { background-color: #961E1E; }
        .text-custom-red { color: #961E1E; }
        .bg-custom-dark-red { background-color: #7a1818; }
        /* Style focus input */
        .input-focus:focus { 
            outline: 2px solid #961E1E; 
            border-color: #961E1E; 
        }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <nav class="bg-custom-red text-white py-4 px-6 shadow-md sticky top-0 z-50">
        <div class="container mx-auto flex items-center gap-4">
            <a href="{{ url('/profil') }}" class="text-white hover:text-gray-200 transition">
                <i class="fa-solid fa-arrow-left text-lg"></i>
            </a>
            <div class="flex items-center gap-3">
                <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo" class="h-8 w-auto">
                <h1 class="font-medium text-lg tracking-wide">Edit Profil</h1>
            </div>
        </div>
    </nav>

    <main class="flex-grow container mx-auto px-4 py-8 flex flex-col items-center">
        
        <div class="w-full max-w-2xl bg-white rounded-xl shadow-lg overflow-hidden mb-6">
            
            <div class="bg-custom-red p-6 flex items-center gap-6">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-md shrink-0">
                    <span class="text-custom-red text-2xl font-bold">BS</span>
                </div>
                <div class="text-white">
                    <h2 class="text-2xl font-bold">Budi Santoso</h2>
                    <p class="text-sm font-light opacity-90 mt-1">Guru Matematika</p>
                    <p class="text-xs font-light opacity-80">SMP Negeri 1 Semarang</p>
                </div>
            </div>

            <div class="p-6 md:p-8">
                
                <form action="{{ url('/profil') }}" method="GET">
    <input type="hidden" name="status" value="sukses">
                    
                    <div class="mb-5">
                        <label class="block text-slate-600 text-xs font-bold mb-2">Nama Lengkap</label>
                        <input type="text" name="nama" value="Budi Santoso" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-slate-700 focus:bg-white input-focus" placeholder="Nama lengkap">
                    </div>

                    <div class="mb-5">
                        <label class="block text-slate-600 text-xs font-bold mb-2">Email</label>
                        <input type="email" name="email" value="budi.santoso@example.com" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-slate-700 focus:bg-white input-focus" placeholder="Email aktif">
                    </div>

                    <div class="mb-5">
                        <label class="block text-slate-600 text-xs font-bold mb-2">NIP</label>
                        <input type="text" value="197801011999121001" readonly class="w-full px-4 py-3 border border-gray-200 rounded-lg text-slate-500 bg-gray-100 cursor-not-allowed" title="NIP tidak dapat diubah">
                        <p class="text-[10px] text-slate-400 mt-1 italic">NIP tidak dapat diubah</p>
                    </div>

                    <div class="mb-5">
                        <label class="block text-slate-600 text-xs font-bold mb-2">Jabatan</label>
                        <input type="text" name="jabatan" value="Guru Matematika" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-slate-700 focus:bg-white input-focus" placeholder="Jabatan saat ini">
                    </div>

                    <div class="mb-8">
                        <label class="block text-slate-600 text-xs font-bold mb-2">Sekolah/Unit Kerja</label>
                        <input type="text" name="unit_kerja" value="SMP Negeri 1 Semarang" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-slate-700 focus:bg-white input-focus" placeholder="Unit kerja">
                    </div>

                    <div class="flex flex-col md:flex-row gap-4">
                        <button type="submit" class="flex-1 bg-custom-red text-white font-bold py-3 rounded-lg hover:bg-[#7a1818] transition shadow-md flex justify-center items-center gap-2">
                            <i class="fa-regular fa-circle-check"></i> Simpan Perubahan
                        </button>
                        
                        <a href="{{ url('/profil') }}" class="flex-1 bg-white border border-gray-300 text-slate-600 font-bold py-3 rounded-lg hover:bg-gray-50 transition text-center">
                            Batal
                        </a>
                    </div>

                </form>

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
        SIIPUL &copy; 2024 | Disdikbudpora Kab Semarang
    </footer>

</body>
</html>