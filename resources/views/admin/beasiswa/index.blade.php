<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penerima Beasiswa - Sistem Kemahasiswaan</title>
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
        <div class="bg-gradient-to-r from-teal-500 to-cyan-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold mb-1">
                        <i class="fas fa-users mr-2"></i>
                        Data Penerima Beasiswa
                    </h2>
                    <p class="text-teal-100 text-sm">Kelola mahasiswa penerima beasiswa</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.beasiswa.tipe.index') }}"
                       class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition duration-200 font-semibold flex items-center gap-2">
                        <i class="fas fa-graduation-cap"></i>
                        Jenis Beasiswa
                    </a>
                    <a href="{{ route('admin.beasiswa.create') }}"
                       class="bg-white text-teal-600 hover:bg-teal-50 px-6 py-3 rounded-lg transition duration-200 font-semibold flex items-center gap-2 shadow-lg">
                        <i class="fas fa-plus-circle"></i>
                        Tambah Penerima
                    </a>
                </div>
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
            <form method="GET" action="{{ route('admin.beasiswa.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="beasiswa_tipe_id" class="block text-gray-700 font-medium mb-2 text-sm">Jenis Beasiswa</label>
                        <select name="beasiswa_tipe_id" id="beasiswa_tipe_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                                onchange="this.form.submit()">
                            <option value="">Semua Jenis</option>
                            @foreach($beasiswaTipeList as $tipe)
                                <option value="{{ $tipe->id }}" {{ request('beasiswa_tipe_id') == $tipe->id ? 'selected' : '' }}>
                                    {{ $tipe->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-gray-700 font-medium mb-2 text-sm">Status</label>
                        <select name="status" id="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                                onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                    <div>
                        <label for="search" class="block text-gray-700 font-medium mb-2 text-sm">Cari Mahasiswa</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="NIM / Nama"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition duration-200 font-medium flex items-center justify-center gap-2">
                            <i class="fas fa-search"></i>
                            Filter
                        </button>
                        @if(request('beasiswa_tipe_id') || request('status') || request('search'))
                            <a href="{{ route('admin.beasiswa.index') }}"
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
                    <thead class="bg-gradient-to-r from-teal-50 to-cyan-50">
                        <tr>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Mahasiswa</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jenis Beasiswa</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No. SK</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Periode</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($mahasiswaBeasiswas as $index => $mb)
                            <tr class="hover:bg-teal-50 transition duration-150">
                                <td class="py-4 px-6 text-gray-700">{{ $mahasiswaBeasiswas->firstItem() + $index }}</td>
                                <td class="py-4 px-6">
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $mb->mahasiswa->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $mb->mahasiswa->nim }} - {{ $mb->mahasiswa->programStudi->nama ?? '-' }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-lg text-xs font-medium">
                                        {{ $mb->beasiswaTipe->nama }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-gray-600 text-sm">{{ $mb->nomor_sk }}</td>
                                <td class="py-4 px-6 text-gray-600 text-sm">
                                    <div>
                                        <p><i class="fas fa-calendar mr-1"></i>{{ $mb->tanggal_mulai->format('d M Y') }}</p>
                                        @if($mb->tanggal_berakhir)
                                            <p class="text-xs text-gray-500"><i class="fas fa-calendar-check mr-1"></i>{{ $mb->tanggal_berakhir->format('d M Y') }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    @if($mb->status === 'aktif')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-check-circle mr-1"></i> Aktif
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-times-circle mr-1"></i> Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.beasiswa.edit', $mb->id) }}"
                                           class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-1.5 rounded-lg transition duration-200 text-sm font-medium flex items-center gap-1">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.beasiswa.destroy', $mb->id) }}"
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
                                <td colspan="7" class="py-8 px-6 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                                    <p>Belum ada data penerima beasiswa.</p>
                                    <a href="{{ route('admin.beasiswa.create') }}" class="text-teal-600 hover:underline mt-2 inline-block">
                                        Tambah data penerima pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($mahasiswaBeasiswas->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t">
                    {{ $mahasiswaBeasiswas->links() }}
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
