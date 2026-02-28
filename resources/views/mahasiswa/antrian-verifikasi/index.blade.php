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
        <div class="bg-gradient-to-r from-green-500 to-teal-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <h2 class="text-2xl font-bold">
                <i class="fas fa-list-ol mr-2"></i>
                Antrian Verifikasi Kegiatan
            </h2>
            <p class="text-green-100 text-sm">Daftar antrian untuk verifikasi kegiatan Anda</p>
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

        <!-- Available Antrian -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-calendar-plus mr-2 text-green-600"></i>
                Antrian Verifikasi Tersedia
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($antrianVerifikasis as $av)
                <div class="border border-gray-200 rounded-xl p-4 hover:shadow-lg transition">
                    <div class="flex justify-between items-start mb-3">
                        <h4 class="font-bold text-gray-800">{{ $av->nama }}</h4>
                        @if($av->isPendaftaranOpen())
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Pendaftaran Buka</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">Tutup</span>
                        @endif
                    </div>
                    
                    @if($av->deskripsi)
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $av->deskripsi }}</p>
                    @endif
                    
                    <div class="space-y-2 text-sm text-gray-600 mb-4">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar-alt w-5 text-gray-400"></i>
                            <span>Pendaftaran: {{ $av->tanggal_mulai_pendaftaran->format('d M Y') }} - {{ $av->tanggal_selesai_pendaftaran->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clipboard-check w-5 text-gray-400"></i>
                            <span>Verifikasi: {{ $av->tanggal_mulai_verifikasi->format('d M Y') }} - {{ $av->tanggal_selesai_verifikasi->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-users w-5 text-gray-400"></i>
                            <span>Kuota: {{ $av->kuota_per_hari }} mahasiswa/hari</span>
                        </div>
                    </div>
                    
                    @if($av->isPendaftaranOpen())
                        <a href="{{ route('mahasiswa.antrian-verifikasi.register', $av->id) }}" 
                           class="block w-full bg-gradient-to-r from-green-500 to-teal-600 text-white text-center py-2 rounded-lg font-semibold hover:from-green-600 hover:to-teal-700 transition duration-200">
                            <i class="fas fa-plus-circle mr-1"></i> Daftar Sekarang
                        </a>
                    @else
                        <button disabled class="block w-full bg-gray-300 text-gray-500 text-center py-2 rounded-lg font-semibold cursor-not-allowed">
                            <i class="fas fa-lock mr-1"></i> Pendaftaran Ditutup
                        </button>
                    @endif
                </div>
                @empty
                <div class="col-span-full text-center py-8 text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                    <p>Belum ada antrian verifikasi yang tersedia.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- My Registrations -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-list-check mr-2 text-blue-600"></i>
                Pendaftaran Saya
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Antrian Verifikasi</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal Verifikasi</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">No. Antrian</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($registrations as $reg)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4">
                                <div class="font-semibold text-gray-800">{{ $reg->antrianVerifikasi->nama }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="text-sm text-gray-700">{{ $reg->tanggal_verifikasi->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $reg->tanggal_verifikasi->format('l') }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-mono font-semibold text-blue-600">{{ $reg->nomor_antrian }}</span>
                            </td>
                            <td class="py-3 px-4">
                                @if($reg->status === 'menunggu')
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium">Menunggu</span>
                                @elseif($reg->status === 'terverifikasi')
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Terverifikasi</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">Dibatalkan</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('mahasiswa.antrian-verifikasi.bukti', $reg->id) }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs transition duration-200 flex items-center gap-1">
                                        <i class="fas fa-eye"></i> Bukti
                                    </a>
                                    @if($reg->status === 'menunggu')
                                    <form action="{{ route('mahasiswa.antrian-verifikasi.cancel', $reg->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition duration-200"
                                                onclick="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran ini?')">
                                            <i class="fas fa-times"></i> Batal
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 px-4 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                <p>Anda belum terdaftar di antrian verifikasi manapun.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
