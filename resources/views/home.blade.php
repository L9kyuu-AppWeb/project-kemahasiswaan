<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-500 to-purple-600 min-h-screen">
    <nav class="bg-white/10 backdrop-blur-sm border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-white">Sistem Kemahasiswaan</h1>
                <a href="{{ route('login') }}" class="bg-white text-blue-600 px-6 py-2 rounded-lg hover:bg-blue-50 transition duration-200 font-medium">
                    Login
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="text-center text-white mb-16">
            <h2 class="text-5xl font-bold mb-4">Selamat Datang di Sistem Kemahasiswaan</h2>
            <p class="text-xl text-white/80">Platform terintegrasi untuk pengelolaan kegiatan kemahasiswaan</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Kelola Mahasiswa</h3>
                <p class="text-white/70">Administrasi data mahasiswa dengan mudah dan efisien</p>
            </div>

            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Kegiatan</h3>
                <p class="text-white/70">Daftar dan kelola berbagai kegiatan kemahasiswaan</p>
            </div>

            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Laporan</h3>
                <p class="text-white/70">Monitor dan analisis aktivitas kemahasiswaan</p>
            </div>
        </div>

        <div class="mt-16 text-center">
            <a href="{{ route('login') }}" class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg hover:bg-blue-50 transition duration-200 font-semibold text-lg">
                Mulai Sekarang &rarr;
            </a>
        </div>
    </div>

    <footer class="bg-white/10 backdrop-blur-sm border-t border-white/20 mt-16">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center text-white/60">
            <p>&copy; {{ date('Y') }} Sistem Kemahasiswaan. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
