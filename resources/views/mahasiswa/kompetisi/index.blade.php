<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kompetisi & Prestasi - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                        <i class="fas fa-arrow-left"></i>
                        <span class="font-semibold">Dashboard</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="font-medium">{{ auth()->guard('mahasiswa')->user()->name }}</p>
                        <p class="text-xs text-blue-200">{{ auth()->guard('mahasiswa')->user()->nim }}</p>
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

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">
                        <i class="fas fa-medal mr-2"></i>
                        Kompetisi & Prestasi
                    </h2>
                    <p class="text-emerald-100 text-sm">Kelola data kompetisi dan prestasi Anda</p>
                </div>
                <a href="{{ route('mahasiswa.kompetisi.create') }}"
                   class="bg-white text-emerald-600 hover:bg-emerald-50 px-6 py-3 rounded-lg transition duration-200 font-semibold flex items-center gap-2 shadow-lg">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Kompetisi
                </a>
            </div>
        </div>

        <!-- Error Message -->
        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
        @endif

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        <!-- Kompetisi List -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-trophy mr-2 text-emerald-600"></i>
                Daftar Kompetisi Saya
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Kompetisi</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Level</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Peringkat</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($kompetisis as $index => $kompetisi)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4 text-gray-700">{{ $kompetisis->firstItem() + $index }}</td>
                            <td class="py-3 px-4">
                                <div class="font-semibold text-gray-800">{{ $kompetisi->nama_kompetisi }}</div>
                                <div class="text-xs text-gray-500">{{ $kompetisi->kategori }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium">{{ $kompetisi->level_kegiatan }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium">{{ $kompetisi->peringkat }}</span>
                            </td>
                            <td class="py-3 px-4">
                                @if($kompetisi->status === 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium">
                                        <i class="fas fa-clock mr-1"></i>Pending
                                    </span>
                                @elseif($kompetisi->status === 'approved')
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
                                    <a href="{{ route('mahasiswa.kompetisi.show', $kompetisi->id) }}"
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs transition duration-200 flex items-center gap-1">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    @if($kompetisi->status === 'pending')
                                        <a href="{{ route('mahasiswa.kompetisi.edit', $kompetisi->id) }}"
                                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs transition duration-200 flex items-center gap-1">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('mahasiswa.kompetisi.destroy', $kompetisi->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition duration-200"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus kompetisi ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 px-4 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                <p>Belum ada data kompetisi.</p>
                                <a href="{{ route('mahasiswa.kompetisi.create') }}" class="text-emerald-600 hover:underline mt-2 inline-block">
                                    Tambah kompetisi pertama Anda
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($kompetisis->hasPages())
            <div class="mt-4">
                {{ $kompetisis->links() }}
            </div>
            @endif
        </div>
    </div>
</body>
</html>
