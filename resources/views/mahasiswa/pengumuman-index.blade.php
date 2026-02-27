<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Pengumuman - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-green-50 to-emerald-100">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-green-600 to-emerald-700 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-2 hover:opacity-80 transition">
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

    <div class="max-w-5xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <h2 class="text-2xl font-bold mb-1">
                <i class="fas fa-bullhorn mr-2"></i>
                Semua Pengumuman
            </h2>
            <p class="text-orange-100 text-sm">Daftar pengumuman untuk mahasiswa</p>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <form method="GET" action="{{ route('mahasiswa.pengumuman.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="kategori" class="block text-gray-700 font-medium mb-2 text-sm">Kategori</label>
                        <select name="kategori" id="kategori"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            <option value="umum" {{ request('kategori') == 'umum' ? 'selected' : '' }}>Umum</option>
                            <option value="akademik" {{ request('kategori') == 'akademik' ? 'selected' : '' }}>Akademik</option>
                            <option value="kemahasiswaan" {{ request('kategori') == 'kemahasiswaan' ? 'selected' : '' }}>Kemahasiswaan</option>
                            <option value="beasiswa" {{ request('kategori') == 'beasiswa' ? 'selected' : '' }}>Beasiswa</option>
                        </select>
                    </div>
                    <div>
                        <label for="search" class="block text-gray-700 font-medium mb-2 text-sm">Cari Pengumuman</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Judul / Konten"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition duration-200 font-medium flex items-center justify-center gap-2">
                            <i class="fas fa-search"></i>
                            Filter
                        </button>
                        @if(request('kategori') || request('search'))
                            <a href="{{ route('mahasiswa.pengumuman.index') }}"
                               class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition duration-200 font-medium">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Pengumuman List -->
        <div class="space-y-4">
            @forelse($pengumumen as $pengumuman)
                <a href="{{ route('mahasiswa.pengumuman.show', $pengumuman->id) }}" class="block">
                    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition duration-200 border-l-4 {{ $pengumuman->prioritas === 'tinggi' ? 'border-red-500 bg-red-50' : ($pengumuman->kategori === 'beasiswa' ? 'border-blue-500 bg-blue-50' : ($pengumuman->kategori === 'akademik' ? 'border-purple-500 bg-purple-50' : 'border-green-500 bg-green-50')) }}">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-xs font-semibold px-2 py-1 rounded {{ $pengumuman->kategori === 'beasiswa' ? 'bg-blue-200 text-blue-700' : ($pengumuman->kategori === 'akademik' ? 'bg-purple-200 text-purple-700' : 'bg-green-200 text-green-700') }}">
                                        {{ ucfirst($pengumuman->kategori) }}
                                    </span>
                                    @if($pengumuman->prioritas === 'tinggi')
                                        <span class="text-xs font-semibold px-2 py-1 rounded bg-red-200 text-red-700">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> Penting
                                        </span>
                                    @elseif($pengumuman->prioritas === 'sedang')
                                        <span class="text-xs font-semibold px-2 py-1 rounded bg-yellow-200 text-yellow-700">
                                            <i class="fas fa-exclamation-circle mr-1"></i> Sedang
                                        </span>
                                    @endif
                                    @if($pengumuman->tanggal_expire && $pengumuman->tanggal_expire < now())
                                        <span class="text-xs font-semibold px-2 py-1 rounded bg-gray-200 text-gray-700">
                                            <i class="fas fa-clock mr-1"></i> Expired
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-lg font-bold text-gray-800 mb-2 hover:text-orange-600 transition">{{ $pengumuman->judul }}</h3>
                                <p class="text-gray-600 text-sm mb-3">{{ Str::limit($pengumuman->konten, 150) }}</p>
                                <div class="flex items-center gap-4 text-gray-400 text-xs">
                                    <span><i class="fas fa-calendar mr-1"></i>{{ $pengumuman->created_at->format('d M Y') }}</span>
                                    <span><i class="fas fa-clock mr-1"></i>{{ $pengumuman->created_at->diffForHumans() }}</span>
                                    @if($pengumuman->tanggal_expire)
                                        <span><i class="fas fa-hourglass-end mr-1"></i>Berakhir: {{ $pengumuman->tanggal_expire->format('d M Y') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-4">
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="bg-white rounded-xl shadow-md p-8 text-center">
                    <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                    <p class="text-gray-500">Belum ada pengumuman.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($pengumumen->hasPages())
            <div class="mt-6">
                {{ $pengumumen->links() }}
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-white/80 backdrop-blur-sm border-t mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Sistem Kemahasiswaan. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
