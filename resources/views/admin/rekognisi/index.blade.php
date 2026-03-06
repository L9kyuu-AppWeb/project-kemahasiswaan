<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Rekognisi - Sistem Kemahasiswaan</title>
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
        <div class="bg-gradient-to-r from-cyan-500 to-blue-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <h2 class="text-2xl font-bold">
                <i class="fas fa-certificate mr-2"></i>
                Kelola Rekognisi
            </h2>
            <p class="text-cyan-100 text-sm">Verifikasi dan kelola data rekognisi mahasiswa</p>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
            <form action="{{ route('admin.rekognisi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Level</label>
                    <select name="level" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <option value="">Semua Level</option>
                        <option value="Provinsi" {{ request('level') == 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                        <option value="Nasional" {{ request('level') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                        <option value="Internasional" {{ request('level') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-cyan-500 text-white px-4 py-2 rounded-lg hover:bg-cyan-600 transition">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                </div>
                <div class="flex items-end">
                    <a href="{{ route('admin.rekognisi.index') }}" class="w-full bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition text-center">
                        <i class="fas fa-redo mr-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>

        @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        <!-- Content Card -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-list mr-2 text-cyan-600"></i>
                Daftar Rekognisi
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Mahasiswa</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Rekognisi</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Level</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($rekognisis as $index => $rekognisi)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4 text-gray-700">{{ $rekognisis->firstItem() + $index }}</td>
                            <td class="py-3 px-4">
                                <div class="font-semibold text-gray-800">{{ $rekognisi->nama_mahasiswa }}</div>
                                <div class="text-xs text-gray-500">{{ $rekognisi->nim }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-semibold text-gray-800">{{ $rekognisi->nama_rekognisi }}</div>
                                <div class="text-xs text-gray-500">{{ $rekognisi->jenisRekognisi->nama ?? '-' }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium">{{ $rekognisi->level }}</span>
                            </td>
                            <td class="py-3 px-4">
                                @if($rekognisi->status === 'pending')
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium">
                                    <i class="fas fa-clock mr-1"></i>Pending
                                </span>
                                @elseif($rekognisi->status === 'approved')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">
                                    <i class="fas fa-check-circle mr-1"></i>Disetujui
                                </span>
                                @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">
                                    <i class="fas fa-times-circle mr-1"></i>Ditolak
                                </span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.rekognisi.show', $rekognisi->id) }}"
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs transition duration-200 flex items-center gap-1">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('admin.rekognisi.edit', $rekognisi->id) }}"
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs transition duration-200 flex items-center gap-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.rekognisi.destroy', $rekognisi->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition duration-200">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 px-4 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                <p>Belum ada data rekognisi.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($rekognisis->hasPages())
            <div class="mt-4">
                {{ $rekognisis->links() }}
            </div>
            @endif
        </div>
    </div>
</body>
</html>
