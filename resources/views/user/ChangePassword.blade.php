<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password - SIIPUL</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-custom-red { background-color: #961E1E; }
        .input-focus:focus { outline: 2px solid #961E1E; border-color: #961E1E; }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <nav class="bg-custom-red text-white py-4 px-6 shadow-md">
        <div class="container mx-auto flex items-center gap-4">
            <a href="{{ route('user.profil') }}" class="text-white hover:text-gray-200">
                <i class="fa-solid fa-arrow-left text-lg"></i>
            </a>
            <div class="flex items-center gap-3">
                <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo" class="h-8 w-auto">
                <h1 class="font-medium text-lg">Ubah Password</h1>
            </div>
        </div>
    </nav>

    <main class="flex-grow container mx-auto px-4 py-8 flex justify-center">
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
            
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <ul class="text-sm text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.password.update.user') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password Lama</label>
                    <input type="password" name="current_password" 
                        class="w-full px-4 py-3 border rounded-lg input-focus" 
                        placeholder="Masukkan password lama atau NIP" required>
                    <p class="text-xs text-gray-500 mt-1">Jika belum pernah ubah password, gunakan NIP Anda</p>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                    <input type="password" name="password" 
                        class="w-full px-4 py-3 border rounded-lg input-focus" 
                        placeholder="Minimal 6 karakter" required>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" 
                        class="w-full px-4 py-3 border rounded-lg input-focus" 
                        placeholder="Ulangi password baru" required>
                </div>

                <button type="submit" class="w-full bg-custom-red text-white font-bold py-3 rounded-lg hover:bg-[#7a1818] transition">
                    <i class="fa-solid fa-key mr-2"></i>Ubah Password
                </button>
            </form>
        </div>
    </main>

</body>
</html>