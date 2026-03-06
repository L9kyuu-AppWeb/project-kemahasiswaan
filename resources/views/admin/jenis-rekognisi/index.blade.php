<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jenis Rekognisi - Sistem Kemahasiswaan</title>
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
                        <i class="fas fa-certificate mr-2"></i>
                        Kelola Jenis Rekognisi
                    </h2>
                    <p class="text-emerald-100 text-sm">Kelola data jenis rekognisi dengan mudah</p>
                </div>
                <a href="{{ route('admin.jenis-rekognisi.create') }}"
                   class="bg-white text-emerald-600 hover:bg-emerald-50 px-6 py-3 rounded-lg transition duration-200 font-semibold flex items-center gap-2 shadow-lg">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Jenis
                </a>
            </div>
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
                <i class="fas fa-list mr-2 text-emerald-600"></i>
                Daftar Jenis Rekognisi
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Nama Jenis Rekognisi</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($jenisRekognisiList as $index => $jenis)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-3 px-4 text-gray-700">{{ $jenisRekognisiList->firstItem() + $index }}</td>
                                <td class="py-3 px-4 font-medium text-gray-800">{{ $jenis->nama }}</td>
                                <td class="py-3 px-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.jenis-rekognisi.edit', $jenis->id) }}"
                                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded text-xs transition duration-200 flex items-center gap-1">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.jenis-rekognisi.destroy', $jenis->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus jenis rekognisi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-xs transition duration-200 flex items-center gap-1">
                                                <i class="fas fa-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 px-4 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                    <p>Belum ada data jenis rekognisi.</p>
                                    <a href="{{ route('admin.jenis-rekognisi.create') }}" class="text-emerald-600 hover:underline mt-2 inline-block">
                                        Tambah jenis rekognisi pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($jenisRekognisiList->hasPages())
                <div class="mt-4">
                    {{ $jenisRekognisiList->links() }}
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
