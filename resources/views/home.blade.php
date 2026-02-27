<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-500 to-purple-600 min-h-screen">
    <nav class="bg-white/10 backdrop-blur-sm border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-white">Sistem Kemahasiswaan</h1>
                <a href="{{ route('login') }}" class="bg-white text-blue-600 px-6 py-2 rounded-lg hover:bg-blue-50 transition duration-200 font-medium flex items-center gap-2">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-16">
        <!-- Hero Section -->
        <div class="text-center text-white mb-16">
            <h2 class="text-5xl font-bold mb-4">Selamat Datang di Sistem Kemahasiswaan</h2>
            <p class="text-xl text-white/80 max-w-3xl mx-auto">Platform terintegrasi untuk pengelolaan beasiswa, magang, dan kegiatan kemahasiswaan dengan mudah dan efisien</p>
        </div>

        <!-- Main Features -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Beasiswa Card -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20 hover:bg-white/20 transition duration-300">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center mb-4 shadow-lg">
                    <i class="fas fa-graduation-cap text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Beasiswa</h3>
                <p class="text-white/70 text-sm">Kelola data beasiswa dan laporan akademik penerima beasiswa</p>
            </div>

            <!-- Magang Card -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20 hover:bg-white/20 transition duration-300">
                <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center mb-4 shadow-lg">
                    <i class="fas fa-briefcase text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Magang</h3>
                <p class="text-white/70 text-sm">Monitor dan kelola laporan kegiatan magang mahasiswa</p>
            </div>

            <!-- Mahasiswa Card -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20 hover:bg-white/20 transition duration-300">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center mb-4 shadow-lg">
                    <i class="fas fa-user-graduate text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Mahasiswa</h3>
                <p class="text-white/70 text-sm">Administrasi data mahasiswa dengan mudah dan efisien</p>
            </div>

            <!-- Pengumuman Card -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20 hover:bg-white/20 transition duration-300">
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mb-4 shadow-lg">
                    <i class="fas fa-bullhorn text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Pengumuman</h3>
                <p class="text-white/70 text-sm">Informasi dan pengumuman kegiatan kemahasiswaan</p>
            </div>
        </div>

        <!-- Info Stats Section -->
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20 mb-12">
            <h3 class="text-2xl font-bold text-white text-center mb-8">Fitur Utama</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center text-white">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-alt text-3xl"></i>
                    </div>
                    <h4 class="font-semibold mb-2">Laporan Terkelola</h4>
                    <p class="text-sm text-white/70">Laporan beasiswa dan magang dikelompokkan per mahasiswa untuk memudahkan monitoring</p>
                </div>
                <div class="text-center text-white">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check-double text-3xl"></i>
                    </div>
                    <h4 class="font-semibold mb-2">Verifikasi Mudah</h4>
                    <p class="text-sm text-white/70">Proses approval dan review laporan dengan sistem yang terstruktur</p>
                </div>
                <div class="text-center text-white">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-download text-3xl"></i>
                    </div>
                    <h4 class="font-semibold mb-2">Export PDF</h4>
                    <p class="text-sm text-white/70">Download laporan individual atau multiple dalam format PDF</p>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="mt-16 text-center">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-white text-blue-600 px-8 py-4 rounded-xl hover:bg-blue-50 transition duration-300 font-semibold text-lg shadow-lg">
                <i class="fas fa-arrow-right"></i>
                Mulai Sekarang
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white/10 backdrop-blur-sm border-t border-white/20 mt-16">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center text-white/60">
            <p>&copy; {{ date('Y') }} Sistem Kemahasiswaan. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
