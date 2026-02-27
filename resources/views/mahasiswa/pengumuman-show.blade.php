<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pengumuman->judul }} - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-green-50 to-emerald-100">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-green-600 to-emerald-700 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('mahasiswa.pengumuman.index') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                        <i class="fas fa-arrow-left"></i>
                        <span class="font-semibold">Kembali</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="font-medium">{{ auth()->guard('mahasiswa')->user()->name }}</p>
                        <p class="text-xs text-green-200">{{ auth()->guard('mahasiswa')->user()->nim }}</p>
                    </div>
                    <form action="{{ route('mahasiswa.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="hidden md:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Pengumuman Detail -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-orange-500 to-red-600 p-8 text-white">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-white/20">
                        {{ ucfirst($pengumuman->kategori) }}
                    </span>
                    @if($pengumuman->prioritas === 'tinggi')
                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-red-700">
                            <i class="fas fa-exclamation-triangle mr-1"></i> Penting
                        </span>
                    @endif
                </div>
                <h1 class="text-3xl font-bold mb-4">{{ $pengumuman->judul }}</h1>
                <div class="flex items-center gap-4 text-orange-100 text-sm">
                    <span><i class="fas fa-calendar mr-2"></i>{{ $pengumuman->created_at->format('d M Y') }}</span>
                    <span><i class="fas fa-clock mr-2"></i>{{ $pengumuman->created_at->diffForHumans() }}</span>
                    @if($pengumuman->tanggal_expire)
                        <span><i class="fas fa-hourglass-end mr-2"></i>Berakhir: {{ $pengumuman->tanggal_expire->format('d M Y') }}</span>
                    @endif
                </div>
            </div>

            <!-- Content -->
            <div class="p-8">
                <div class="prose max-w-none">
                    <p class="text-gray-700 text-lg leading-relaxed whitespace-pre-line">{{ $pengumuman->konten }}</p>
                </div>

                <hr class="my-6">

                <div class="flex justify-between items-center">
                    <a href="{{ route('mahasiswa.pengumuman.index') }}" class="text-orange-600 hover:text-orange-700 font-medium flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Daftar Pengumuman
                    </a>
                    <a href="{{ route('mahasiswa.dashboard') }}" class="text-green-600 hover:text-green-700 font-medium flex items-center gap-2">
                        <i class="fas fa-home"></i>
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white/80 backdrop-blur-sm border-t mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Sistem Kemahasiswaan. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
