<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pendaftaran Verifikasi - Sistem Kemahasiswaan</title>
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

    <div class="max-w-3xl mx-auto px-4 py-8">
        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        <!-- Bukti Card -->
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-500 to-teal-600 text-white p-6 text-center">
                <i class="fas fa-ticket-alt text-4xl mb-2"></i>
                <h2 class="text-2xl font-bold">Bukti Pendaftaran Verifikasi</h2>
                <p class="text-green-100 text-sm">Simpan bukti ini untuk ditunjukkan saat verifikasi</p>
            </div>

            <!-- Content -->
            <div class="p-8">
                <!-- Nomor Antrian -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 mb-6 text-center">
                    <div class="text-sm text-gray-500 mb-1">Nomor Antrian Anda</div>
                    <div class="text-4xl font-bold font-mono text-green-600">{{ $detail->nomor_antrian }}</div>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 mb-1">Nama Kegiatan</label>
                        <div class="text-gray-800 font-semibold">{{ $detail->antrianVerifikasi->nama }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 mb-1">Tanggal Verifikasi</label>
                        <div class="text-gray-800 font-semibold">{{ $detail->tanggal_verifikasi->format('d M Y') }}</div>
                        <div class="text-sm text-gray-500">{{ $detail->tanggal_verifikasi->format('l') }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 mb-1">Nama Mahasiswa</label>
                        <div class="text-gray-800 font-semibold">{{ $detail->mahasiswa->name }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 mb-1">NIM</label>
                        <div class="text-gray-800 font-semibold">{{ $detail->mahasiswa->nim }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 mb-1">Program Studi</label>
                        <div class="text-gray-800 font-semibold">{{ $detail->mahasiswa->programStudi->nama ?? '-' }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 mb-1">Status</label>
                        <div>
                            @if($detail->status === 'menunggu')
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-medium">Menunggu Verifikasi</span>
                            @elseif($detail->status === 'terverifikasi')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">Terverifikasi</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">Dibatalkan</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- QR Code Placeholder -->
                <div class="border-t pt-6 text-center">
                    <div class="inline-block bg-gray-100 rounded-lg p-4 mb-3">
                        <i class="fas fa-qrcode text-6xl text-gray-400"></i>
                    </div>
                    <p class="text-sm text-gray-500">Tunjukkan bukti ini kepada petugas verifikasi</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-4 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-sm text-gray-500 text-center md:text-left">
                    <i class="fas fa-info-circle mr-1"></i>
                    Harap hadir 15 menit sebelum jadwal verifikasi
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('mahasiswa.antrian-verifikasi.download-bukti', $detail->id) }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-200 flex items-center gap-2">
                        <i class="fas fa-download"></i>
                        Download PDF
                    </a>
                    <a href="{{ route('mahasiswa.antrian-verifikasi.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg font-semibold transition duration-200">
                        <i class="fas fa-list mr-1"></i>
                        Lihat Pendaftaran
                    </a>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <i class="fas fa-lightbulb text-yellow-600 text-xl mt-0.5"></i>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold mb-1">Tips:</p>
                    <ul class="list-disc list-inside space-y-1 text-blue-700">
                        <li>Cetak atau simpan bukti ini di ponsel Anda</li>
                        <li>Hadir tepat waktu pada tanggal verifikasi yang ditentukan</li>
                        <li>Bawa dokumen pendukung yang diperlukan</li>
                        <li>Jika berhalangan hadir, segera batalkan melalui sistem</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
