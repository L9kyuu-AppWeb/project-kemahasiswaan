<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Antrian Verifikasi - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.antrian-verifikasi.index') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                        <i class="fas fa-arrow-left"></i>
                        <span class="font-semibold">Kembali</span>
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
            <h2 class="text-2xl font-bold">
                <i class="fas fa-info-circle mr-2"></i>
                Detail Antrian Verifikasi
            </h2>
            <p class="text-purple-100 text-sm">{{ $antrianVerifikasi->nama }}</p>
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow p-4">
                <div class="text-sm text-gray-500 mb-1">Periode Pendaftaran</div>
                <div class="font-semibold text-gray-800">{{ $antrianVerifikasi->tanggal_mulai_pendaftaran->format('d M Y') }}</div>
                <div class="text-xs text-gray-500">s/d {{ $antrianVerifikasi->tanggal_selesai_pendaftaran->format('d M Y') }}</div>
            </div>
            <div class="bg-white rounded-xl shadow p-4">
                <div class="text-sm text-gray-500 mb-1">Periode Verifikasi</div>
                <div class="font-semibold text-gray-800">{{ $antrianVerifikasi->tanggal_mulai_verifikasi->format('d M Y') }}</div>
                <div class="text-xs text-gray-500">s/d {{ $antrianVerifikasi->tanggal_selesai_verifikasi->format('d M Y') }}</div>
            </div>
            <div class="bg-white rounded-xl shadow p-4">
                <div class="text-sm text-gray-500 mb-1">Kuota Per Hari</div>
                <div class="font-semibold text-gray-800">{{ $antrianVerifikasi->kuota_per_hari }} mahasiswa</div>
            </div>
            <div class="bg-white rounded-xl shadow p-4">
                <div class="text-sm text-gray-500 mb-1">Total Terdaftar</div>
                <div class="font-semibold text-gray-800">{{ $antrianVerifikasi->details()->where('status', '!=', 'dibatalkan')->count() }} mahasiswa</div>
            </div>
        </div>

        <!-- Summary Per Tanggal -->
        @if($summaryPerTanggal->count() > 0)
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-chart-bar mr-2 text-purple-600"></i>
                Ringkasan Pendaftaran Per Tanggal
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                @foreach($summaryPerTanggal as $summary)
                <div class="bg-purple-50 rounded-lg p-3 text-center">
                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($summary->tanggal_verifikasi)->format('d M') }}</div>
                    <div class="text-lg font-bold text-purple-600">{{ $summary->total }}</div>
                    <div class="text-xs text-gray-500">mahasiswa</div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        <!-- Details Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-purple-500 to-indigo-600 text-white">
                <h3 class="text-lg font-bold">
                    <i class="fas fa-list mr-2"></i>
                    Daftar Mahasiswa Terdaftar
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">No. Antrian</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Mahasiswa</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal Verifikasi</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Kehadiran</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($details as $detail)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4">
                                <span class="font-mono font-semibold text-purple-600">{{ $detail->nomor_antrian }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-semibold text-gray-800">{{ $detail->mahasiswa->name }}</div>
                                <div class="text-xs text-gray-500">{{ $detail->mahasiswa->nim }}</div>
                                <div class="text-xs text-gray-500">{{ $detail->mahasiswa->programStudi->nama ?? '-' }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="text-sm text-gray-700">{{ $detail->tanggal_verifikasi->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $detail->tanggal_verifikasi->format('l') }}</div>
                            </td>
                            <td class="py-3 px-4">
                                @if($detail->status === 'menunggu')
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium">Menunggu</span>
                                @elseif($detail->status === 'terverifikasi')
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Terverifikasi</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">Dibatalkan</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <form action="{{ route('admin.antrian-verifikasi.mark-attendance', $detail->id) }}" method="POST">
                                    @csrf
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" 
                                               name="hadir" 
                                               value="1"
                                               {{ $detail->hadir_verifikasi ? 'checked' : '' }}
                                               onchange="this.form.submit()"
                                               class="w-4 h-4 text-green-600 rounded focus:ring-green-500">
                                        <span class="text-xs text-gray-600">{{ $detail->hadir_verifikasi ? 'Hadir' : 'Belum Hadir' }}</span>
                                    </label>
                                </form>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex gap-2">
                                    <!-- Update Status -->
                                    <button onclick="openStatusModal({{ $detail->id }}, '{{ $detail->status }}')" 
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs transition duration-200">
                                        <i class="fas fa-edit"></i> Status
                                    </button>
                                    @if($detail->status !== 'dibatalkan')
                                    <form action="{{ route('admin.antrian-verifikasi.cancel', $detail->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition duration-200"
                                                onclick="return confirm('Batalkan pendaftaran mahasiswa ini?')">
                                            <i class="fas fa-times"></i> Batal
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
                                <p>Belum ada mahasiswa yang terdaftar.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($details->hasPages())
            <div class="px-6 py-4 border-t">
                {{ $details->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Status Modal -->
    <div id="statusModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md mx-4">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-edit mr-2"></i>
                Update Status
            </h3>
            <form id="statusForm" method="POST">
                @csrf
                @method('POST')
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="menunggu">Menunggu</option>
                        <option value="terverifikasi">Terverifikasi</option>
                        <option value="dibatalkan">Dibatalkan</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan</label>
                    <textarea name="keterangan" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-200">
                        Simpan
                    </button>
                    <button type="button" onclick="closeStatusModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg font-semibold transition duration-200">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openStatusModal(detailId, currentStatus) {
            document.getElementById('statusForm').action = "{{ route('admin.antrian-verifikasi.update-status', '__ID__') }}".replace('__ID__', detailId);
            document.getElementById('statusForm').querySelector('select[name="status"]').value = currentStatus;
            document.getElementById('statusModal').classList.remove('hidden');
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
        }
    </script>
</body>
</html>
