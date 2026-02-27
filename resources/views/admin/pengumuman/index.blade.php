<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengumuman - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                        <i class="fas fa-arrow-left"></i>
                        <span class="font-semibold">Dashboard</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="font-medium">{{ auth()->guard('admin')->user()->name }}</p>
                        <p class="text-xs text-blue-200">Administrator</p>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
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

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold mb-1">
                        <i class="fas fa-bullhorn mr-2"></i>
                        Kelola Pengumuman
                    </h2>
                    <p class="text-orange-100 text-sm">Kelola pengumuman untuk mahasiswa</p>
                </div>
                <a href="{{ route('admin.pengumuman.create') }}"
                   class="bg-white text-orange-600 hover:bg-orange-50 px-6 py-3 rounded-lg transition duration-200 font-semibold flex items-center gap-2 shadow-lg">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Pengumuman
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <form method="GET" action="{{ route('admin.pengumuman.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
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
                        <label for="prioritas" class="block text-gray-700 font-medium mb-2 text-sm">Prioritas</label>
                        <select name="prioritas" id="prioritas"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                onchange="this.form.submit()">
                            <option value="">Semua Prioritas</option>
                            <option value="rendah" {{ request('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="sedang" {{ request('prioritas') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="tinggi" {{ request('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-gray-700 font-medium mb-2 text-sm">Status</label>
                        <select name="status" id="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
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
                        @if(request('kategori') || request('prioritas') || request('status') || request('search'))
                            <a href="{{ route('admin.pengumuman.index') }}"
                               class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition duration-200 font-medium">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Content Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gradient-to-r from-orange-50 to-red-50">
                        <tr>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Prioritas</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($pengumumen as $index => $pengumuman)
                            <tr class="hover:bg-orange-50 transition duration-150">
                                <td class="py-4 px-6 text-gray-700">{{ $pengumumen->firstItem() + $index }}</td>
                                <td class="py-4 px-6">
                                    <p class="font-medium text-gray-800">{{ $pengumuman->judul }}</p>
                                    <p class="text-sm text-gray-500">{{ Str::limit($pengumuman->konten, 50) }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="bg-{{ $pengumuman->kategori === 'beasiswa' ? 'blue' : ($pengumuman->kategori === 'akademik' ? 'purple' : 'green') }}-100 text-{{ $pengumuman->kategori === 'beasiswa' ? 'blue' : ($pengumuman->kategori === 'akademik' ? 'purple' : 'green') }}-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ ucfirst($pengumuman->kategori) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    @if($pengumuman->prioritas === 'tinggi')
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> Tinggi
                                        </span>
                                    @elseif($pengumuman->prioritas === 'sedang')
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            Sedang
                                        </span>
                                    @else
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            Rendah
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    @if($pengumuman->is_published)
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-check-circle mr-1"></i> Published
                                        </span>
                                    @else
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-clock mr-1"></i> Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-gray-600 text-sm">
                                    <p><i class="fas fa-calendar mr-1"></i>{{ $pengumuman->created_at->format('d M Y') }}</p>
                                    <p class="text-xs text-gray-400"><i class="fas fa-clock mr-1"></i>{{ $pengumuman->created_at->diffForHumans() }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.pengumuman.edit', $pengumuman->id) }}"
                                           class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-1.5 rounded-lg transition duration-200 text-sm font-medium flex items-center gap-1">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.pengumuman.destroy', $pengumuman->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded-lg transition duration-200 text-sm font-medium flex items-center gap-1">
                                                <i class="fas fa-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 px-6 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                                    <p>Belum ada data pengumuman.</p>
                                    <a href="{{ route('admin.pengumuman.create') }}" class="text-orange-600 hover:underline mt-2 inline-block">
                                        Tambah pengumuman pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pengumumen->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t">
                    {{ $pengumumen->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Sistem Kemahasiswaan. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
