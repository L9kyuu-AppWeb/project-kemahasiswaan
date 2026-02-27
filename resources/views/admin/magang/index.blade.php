<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahasiswa Magang - Sistem Kemahasiswaan</title>
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
        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold mb-1">
                        <i class="fas fa-briefcase mr-2"></i>
                        Mahasiswa Magang
                    </h2>
                    <p class="text-emerald-100 text-sm">Kelola data mahasiswa yang sedang magang</p>
                </div>
                <a href="{{ route('admin.magang.create') }}"
                   class="bg-white text-emerald-600 hover:bg-emerald-50 px-6 py-3 rounded-lg transition duration-200 font-semibold flex items-center gap-2 shadow-lg">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Mahasiswa Magang
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
            <form action="{{ route('admin.magang.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Mahasiswa</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Nama atau NIM"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajar</label>
                    <select name="tahun_ajar_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Semua Tahun Ajar</option>
                        @foreach($tahunAjarList as $ta)
                            <option value="{{ $ta->id }}" {{ request('tahun_ajar_id') == $ta->id ? 'selected' : '' }}>
                                {{ $ta->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition duration-200 font-semibold flex items-center justify-center gap-2">
                        <i class="fas fa-search"></i>
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Magang List -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gradient-to-r from-emerald-50 to-teal-50">
                        <tr>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Mahasiswa</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tahun Ajar</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Perusahaan</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Periode</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($magangs as $magang)
                            <tr class="hover:bg-emerald-50 transition duration-150">
                                <td class="py-4 px-6">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $magang->mahasiswa->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $magang->mahasiswa->nim }}</p>
                                        <p class="text-xs text-gray-400">{{ $magang->mahasiswa->programStudi->nama ?? '-' }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-gray-600">{{ $magang->tahunAjar->nama }}</td>
                                <td class="py-4 px-6">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $magang->nama_perusahaan }}</p>
                                        <p class="text-sm text-gray-500">{{ $magang->lokasi_perusahaan }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-gray-600 text-sm">
                                    <div>
                                        <p>{{ $magang->tanggal_mulai->format('d M Y') }}</p>
                                        <p>{{ $magang->tanggal_selesai->format('d M Y') }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    @if($magang->status === 'aktif')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-circle text-[8px] mr-1"></i> Aktif
                                        </span>
                                    @elseif($magang->status === 'selesai')
                                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-check-circle text-[8px] mr-1"></i> Selesai
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-times-circle text-[8px] mr-1"></i> Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.magang.show', $magang->id) }}"
                                           class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1.5 rounded-lg transition duration-200 text-sm font-medium flex items-center gap-1">
                                            <i class="fas fa-eye"></i>
                                            Detail
                                        </a>
                                        <a href="{{ route('admin.magang.edit', $magang->id) }}"
                                           class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-1.5 rounded-lg transition duration-200 text-sm font-medium flex items-center gap-1">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.magang.destroy', $magang->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus data ini?');">
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
                                <td colspan="6" class="py-8 px-6 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                                    <p>Belum ada data mahasiswa magang.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($magangs->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t">
                    {{ $magangs->links() }}
                </div>
            @endif
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
