<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrian Verifikasi - Sistem Kemahasiswaan</title>
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
        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold mb-1">
                        <i class="fas fa-list-ol mr-2"></i>
                        Antrian Verifikasi Kegiatan
                    </h2>
                    <p class="text-purple-100 text-sm">Kelola antrian verifikasi kegiatan mahasiswa</p>
                </div>
                <a href="{{ route('admin.antrian-verifikasi.create') }}" 
                   class="bg-white text-purple-600 px-6 py-3 rounded-lg font-semibold hover:bg-purple-50 transition duration-200 flex items-center gap-2 shadow-md">
                    <i class="fas fa-plus"></i>
                    <span class="hidden md:inline">Tambah Antrian</span>
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        <!-- Antrian Verifikasis Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white">
                        <tr>
                            <th class="py-4 px-6 text-left font-semibold">Nama</th>
                            <th class="py-4 px-6 text-left font-semibold">Periode Pendaftaran</th>
                            <th class="py-4 px-6 text-left font-semibold">Periode Verifikasi</th>
                            <th class="py-4 px-6 text-left font-semibold">Kuota/Hari</th>
                            <th class="py-4 px-6 text-left font-semibold">Status</th>
                            <th class="py-4 px-6 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($antrianVerifikasis as $av)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-6">
                                <div class="font-semibold text-gray-800">{{ $av->nama }}</div>
                                @if($av->deskripsi)
                                <div class="text-sm text-gray-500 truncate max-w-xs">{{ $av->deskripsi }}</div>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-sm">
                                <div class="text-gray-700">{{ $av->tanggal_mulai_pendaftaran->format('d M Y') }}</div>
                                <div class="text-gray-500">s/d {{ $av->tanggal_selesai_pendaftaran->format('d M Y') }}</div>
                            </td>
                            <td class="py-4 px-6 text-sm">
                                <div class="text-gray-700">{{ $av->tanggal_mulai_verifikasi->format('d M Y') }}</div>
                                <div class="text-gray-500">s/d {{ $av->tanggal_selesai_verifikasi->format('d M Y') }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $av->kuota_per_hari }} mahasiswa
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                @if($av->is_active)
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">Aktif</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.antrian-verifikasi.show', $av->id) }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200 text-sm flex items-center gap-1">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('admin.antrian-verifikasi.edit', $av->id) }}" 
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-200 text-sm flex items-center gap-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.antrian-verifikasi.destroy', $av->id) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus antrian verifikasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200 text-sm flex items-center gap-1">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 px-6 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                <p>Belum ada antrian verifikasi.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $antrianVerifikasis->links() }}
        </div>
    </div>
</body>
</html>
