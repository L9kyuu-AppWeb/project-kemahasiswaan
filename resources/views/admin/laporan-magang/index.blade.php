<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Magang - Sistem Kemahasiswaan</title>
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
        <div class="bg-gradient-to-r from-orange-500 to-amber-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold mb-1">
                        <i class="fas fa-briefcase mr-2"></i>
                        Laporan Magang Mahasiswa
                    </h2>
                    <p class="text-orange-100 text-sm">Kelola dan verifikasi laporan magang</p>
                </div>
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
            <form action="{{ route('admin.laporan-magang.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajar</label>
                    <select name="tahun_ajar_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">Semua Tahun Ajar</option>
                        @foreach($tahunAjarList as $ta)
                            <option value="{{ $ta->id }}" {{ request('tahun_ajar_id') == $ta->id ? 'selected' : '' }}>
                                {{ $ta->nama }} ({{ ucfirst($ta->semester) }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Perusahaan</label>
                    <input type="text" name="perusahaan" value="{{ request('perusahaan') }}"
                           placeholder="Nama perusahaan"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                </div>
                <div class="flex items-end">
                    <button type="submit"
                            class="w-full bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg transition duration-200 font-semibold flex items-center justify-center gap-2">
                        <i class="fas fa-search"></i>
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Mahasiswa List (Grouped) -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gradient-to-r from-orange-50 to-amber-50">
                        <tr>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Mahasiswa</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Program Studi</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total Laporan</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Laporan Terakhir</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($mahasiswaList as $mhs)
                            <tr class="hover:bg-orange-50 transition duration-150">
                                <td class="py-4 px-6">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $mhs['mahasiswa']->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $mhs['mahasiswa']->nim }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-sm text-gray-600">{{ $mhs['program_studi']->nama ?? '-' }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        <i class="fas fa-file-alt mr-1"></i> {{ $mhs['total_laporan'] }} Laporan
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex flex-wrap gap-1">
                                        @if($mhs['status_summary']['draft'] > 0)
                                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-semibold" title="Draft">
                                                <i class="fas fa-file"></i> {{ $mhs['status_summary']['draft'] }}
                                            </span>
                                        @endif
                                        @if($mhs['status_summary']['submitted'] > 0)
                                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-semibold" title="Submitted">
                                                <i class="fas fa-clock"></i> {{ $mhs['status_summary']['submitted'] }}
                                            </span>
                                        @endif
                                        @if($mhs['status_summary']['approved'] > 0)
                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold" title="Approved">
                                                <i class="fas fa-check-circle"></i> {{ $mhs['status_summary']['approved'] }}
                                            </span>
                                        @endif
                                        @if($mhs['status_summary']['rejected'] > 0)
                                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-semibold" title="Rejected">
                                                <i class="fas fa-times-circle"></i> {{ $mhs['status_summary']['rejected'] }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-600">
                                    {{ $mhs['latest_report']->created_at->diffForHumans() }}
                                </td>
                                <td class="py-4 px-6">
                                    <a href="{{ route('admin.laporan-magang.mahasiswa', $mhs['mahasiswa_id']) }}"
                                       class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-4 py-2 rounded-lg transition duration-200 text-sm font-medium flex items-center gap-2 inline-flex">
                                        <i class="fas fa-eye"></i>
                                        Lihat Laporan
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 px-6 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                                    <p>Belum ada laporan magang.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
