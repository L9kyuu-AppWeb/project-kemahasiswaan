<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Antrian Verifikasi - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('mahasiswa.antrian-verifikasi.index') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                        <i class="fas fa-arrow-left"></i>
                        <span class="font-semibold">Kembali</span>
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

    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-green-500 to-teal-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <h2 class="text-2xl font-bold">
                <i class="fas fa-calendar-check mr-2"></i>
                Daftar Antrian Verifikasi
            </h2>
            <p class="text-green-100 text-sm">{{ $antrianVerifikasi->nama }}</p>
        </div>

        <!-- Error Message -->
        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
        @endif

        <!-- Info Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-info-circle mr-2 text-green-600"></i>
                Informasi Antrian Verifikasi
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm text-gray-500 mb-1">Periode Pendaftaran</div>
                    <div class="font-semibold text-gray-800">{{ $antrianVerifikasi->tanggal_mulai_pendaftaran->format('d M Y') }}</div>
                    <div class="text-sm text-gray-600">s/d {{ $antrianVerifikasi->tanggal_selesai_pendaftaran->format('d M Y') }}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm text-gray-500 mb-1">Periode Verifikasi</div>
                    <div class="font-semibold text-gray-800">{{ $antrianVerifikasi->tanggal_mulai_verifikasi->format('d M Y') }}</div>
                    <div class="text-sm text-gray-600">s/d {{ $antrianVerifikasi->tanggal_selesai_verifikasi->format('d M Y') }}</div>
                </div>
            </div>
            @if($antrianVerifikasi->deskripsi)
            <div class="mt-4 pt-4 border-t">
                <div class="text-sm text-gray-500 mb-1">Deskripsi</div>
                <p class="text-gray-700">{{ $antrianVerifikasi->deskripsi }}</p>
            </div>
            @endif
        </div>

        <!-- Available Dates -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-calendar-day mr-2 text-green-600"></i>
                Pilih Tanggal Verifikasi
            </h3>
            
            @if(count($availableDates) > 0)
            <form action="{{ route('mahasiswa.antrian-verifikasi.store', $antrianVerifikasi->id) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                    @foreach($availableDates as $date)
                    <label class="relative cursor-pointer">
                        <input type="radio" 
                               name="tanggal_verifikasi" 
                               value="{{ $date['tanggal'] }}"
                               class="peer sr-only"
                               required>
                        <div class="border-2 border-gray-200 rounded-xl p-4 peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-green-300 transition">
                            <div class="flex justify-between items-start mb-2">
                                <i class="fas fa-calendar-day text-2xl text-green-600"></i>
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">
                                    {{ $date['sisa_kuota'] }} slot
                                </span>
                            </div>
                            <div class="font-semibold text-gray-800">{{ $date['nama_hari'] }}</div>
                        </div>
                    </label>
                    @endforeach
                </div>

                <div class="flex gap-4">
                    <button type="submit" 
                            class="bg-gradient-to-r from-green-500 to-teal-600 text-white px-8 py-3 rounded-lg font-semibold hover:from-green-600 hover:to-teal-700 transition duration-200 shadow-md flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        Konfirmasi Pendaftaran
                    </button>
                    <a href="{{ route('mahasiswa.antrian-verifikasi.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-8 py-3 rounded-lg font-semibold transition duration-200 flex items-center gap-2">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                </div>
            </form>
            @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-calendar-times text-4xl mb-3 text-gray-300"></i>
                <p>Tidak ada tanggal tersedia untuk saat ini.</p>
                <p class="text-sm mt-2">Semua kuota sudah penuh atau tanggal verifikasi berada di akhir pekan.</p>
            </div>
            @endif
        </div>

        <!-- Info Box -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <i class="fas fa-info-circle text-blue-600 text-xl mt-0.5"></i>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold mb-1">Catatan Penting:</p>
                    <ul class="list-disc list-inside space-y-1 text-blue-700">
                        <li>Pilih tanggal verifikasi yang masih tersedia slotnya</li>
                        <li>Sabtu dan Minggu tidak tersedia untuk verifikasi</li>
                        <li>Satu mahasiswa hanya bisa terdaftar sekali per antrian</li>
                        <li>Harap hadir tepat waktu pada tanggal yang dipilih</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
