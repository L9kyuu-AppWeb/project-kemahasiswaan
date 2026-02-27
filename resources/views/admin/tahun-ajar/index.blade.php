<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tahun Ajar - Sistem Kemahasiswaan</title>
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
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Manajemen Tahun Ajar
                    </h2>
                    <p class="text-orange-100 text-sm">Kelola tahun ajaran dan tentukan tahun ajar aktif</p>
                </div>
                <a href="{{ route('admin.tahun-ajar.create') }}"
                   class="bg-white text-orange-600 hover:bg-orange-50 px-6 py-3 rounded-lg transition duration-200 font-semibold flex items-center gap-2 shadow-lg">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Tahun Ajar
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <form method="GET" action="{{ route('admin.tahun-ajar.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="semester" class="block text-gray-700 font-medium mb-2 text-sm">Semester</label>
                        <select name="semester" id="semester"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                onchange="this.form.submit()">
                            <option value="">Semua Semester</option>
                            <option value="ganjil" {{ request('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="genap" {{ request('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-gray-700 font-medium mb-2 text-sm">Status</label>
                        <select name="status" id="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        @if(request('semester') || request('status'))
                            <a href="{{ route('admin.tahun-ajar.index') }}"
                               class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition duration-200 font-medium">
                                <i class="fas fa-times"></i>
                                Reset Filter
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
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tahun Ajar</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Semester</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($tahunAjars as $index => $ta)
                            <tr class="hover:bg-orange-50 transition duration-150 {{ $ta->is_active ? 'bg-green-50' : '' }}">
                                <td class="py-4 px-6 text-gray-700">{{ $tahunAjars->firstItem() + $index }}</td>
                                <td class="py-4 px-6">
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $ta->nama }}</p>
                                        <p class="text-sm text-gray-500">{{ $ta->tahun_mulai }} - {{ $ta->tahun_selesai }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $ta->semester === 'ganjil' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                                        <i class="fas fa-{{ $ta->semester === 'ganjil' ? 'sun' : 'cloud' }} mr-1"></i>
                                        {{ ucfirst($ta->semester) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    @if($ta->is_active)
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-check-circle mr-1"></i> Aktif
                                        </span>
                                    @else
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-times-circle mr-1"></i> Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex gap-2">
                                        @if(!$ta->is_active)
                                            <form action="{{ route('admin.tahun-ajar.set-active', $ta->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="bg-green-100 text-green-700 hover:bg-green-200 px-3 py-1.5 rounded-lg transition duration-200 text-sm font-medium flex items-center gap-1"
                                                        onclick="return confirm('Set tahun ajar ini sebagai aktif? Tahun ajar aktif lainnya akan menjadi tidak aktif.')">
                                                    <i class="fas fa-check-circle"></i>
                                                    Set Aktif
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('admin.tahun-ajar.edit', $ta->id) }}"
                                           class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-1.5 rounded-lg transition duration-200 text-sm font-medium flex items-center gap-1">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                        @if(!$ta->is_active)
                                            <form action="{{ route('admin.tahun-ajar.destroy', $ta->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus tahun ajar ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded-lg transition duration-200 text-sm font-medium flex items-center gap-1">
                                                    <i class="fas fa-trash"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 px-6 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                                    <p>Belum ada tahun ajar.</p>
                                    <a href="{{ route('admin.tahun-ajar.create') }}" class="text-orange-600 hover:underline mt-2 inline-block">
                                        Tambah tahun ajar pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($tahunAjars->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t">
                    {{ $tahunAjars->links() }}
                </div>
            @endif
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mt-6">
            <div class="flex items-start gap-4">
                <div class="text-blue-600 text-2xl">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-blue-800 mb-2">Informasi</h4>
                    <ul class="text-blue-700 text-sm space-y-1">
                        <li>• Hanya <strong>1 tahun ajar</strong> yang dapat berstatus aktif pada satu waktu.</li>
                        <li>• Tahun ajar aktif digunakan sebagai default saat mahasiswa membuat laporan beasiswa.</li>
                        <li>• Tahun ajar yang sedang aktif <strong>tidak dapat dihapus</strong>.</li>
                    </ul>
                </div>
            </div>
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
