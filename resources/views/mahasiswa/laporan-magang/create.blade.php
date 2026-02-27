<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan Magang - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-orange-50 to-amber-100">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-orange-600 to-amber-700 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('mahasiswa.laporan-magang.index') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                        <i class="fas fa-arrow-left"></i>
                        <span class="font-semibold">Kembali</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="font-medium">{{ auth()->guard('mahasiswa')->user()->name }}</p>
                        <p class="text-xs text-orange-200">{{ auth()->guard('mahasiswa')->user()->nim }}</p>
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

    <div class="max-w-5xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-orange-500 to-amber-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <h2 class="text-2xl font-bold">
                <i class="fas fa-plus-circle mr-2"></i>
                Buat Laporan Magang
            </h2>
            <p class="text-orange-100 text-sm">Formulir laporan kegiatan magang</p>
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

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <p class="font-semibold mb-2"><i class="fas fa-exclamation-triangle mr-2"></i>Validasi Gagal</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('mahasiswa.laporan-magang.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-md p-8">
            @csrf

            <!-- Informasi Laporan -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-file-alt text-orange-600"></i>
                    Informasi Laporan
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="judul_laporan" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Laporan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="judul_laporan" name="judul_laporan" value="{{ old('judul_laporan') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <div class="md:col-span-2">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Laporan <span class="text-red-500">*</span>
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="4" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div>
                        <label for="tahun_ajar_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Tahun Ajar
                        </label>
                        <input type="text" id="tahun_ajar_id" value="{{ $tahunAjarAktif->nama }} ({{ ucfirst($tahunAjarAktif->semester) }})" readonly
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed">
                        <p class="text-xs text-gray-500 mt-1"><i class="fas fa-info-circle"></i> Tahun ajar aktif dipilih otomatis</p>
                    </div>

                    <div>
                        <label for="tanggal_kegiatan" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Kegiatan <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_kegiatan" name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <div>
                        <label for="lokasi_kegiatan" class="block text-sm font-medium text-gray-700 mb-2">
                            Lokasi Kegiatan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="lokasi_kegiatan" name="lokasi_kegiatan" value="{{ old('lokasi_kegiatan') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <div>
                        <label for="waktu_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                            Waktu Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="time" id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <div>
                        <label for="waktu_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                            Waktu Selesai <span class="text-red-500">*</span>
                        </label>
                        <input type="time" id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                </div>
            </div>

            <!-- Log Kegiatan Harian -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-list-check text-orange-600"></i>
                    Log Kegiatan Harian
                </h3>
                <p class="text-sm text-gray-600 mb-4">Tambahkan log kegiatan untuk setiap hari kerja. Upload bukti kegiatan dalam format PDF (bisa lebih dari 1 file).</p>
                
                <div id="log-container">
                    <!-- Log items will be added here -->
                </div>

                <button type="button" onclick="addLog()"
                        class="mt-4 bg-orange-100 text-orange-700 hover:bg-orange-200 px-4 py-2 rounded-lg transition duration-200 font-semibold flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Log Kegiatan
                </button>
            </div>

            <!-- Hidden input for log count -->
            <input type="hidden" id="log-count" value="0">

            <!-- Form Actions -->
            <div class="flex gap-4 mt-8 pt-6 border-t">
                <button type="submit" name="action" value="submit"
                        class="flex-1 bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-lg transition duration-200 font-semibold flex items-center justify-center gap-2 shadow-lg">
                    <i class="fas fa-paper-plane"></i>
                    Kirim Laporan
                </button>
                <button type="submit" name="action" value="draft"
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-3 rounded-lg transition duration-200 font-semibold flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i>
                    Simpan Draft
                </button>
            </div>
        </form>
    </div>

    <!-- Template for Log Item -->
    <template id="log-template">
        <div class="log-item bg-gray-50 border border-gray-200 rounded-xl p-6 mb-4">
            <div class="flex justify-between items-center mb-4">
                <h4 class="font-bold text-gray-800">Log Kegiatan #<span class="log-number">1</span></h4>
                <button type="button" onclick="removeLog(this)" class="text-red-600 hover:text-red-700">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jam Mulai <span class="text-red-500">*</span></label>
                        <input type="time" name="log_jam_mulai[]" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jam Selesai <span class="text-red-500">*</span></label>
                        <input type="time" name="log_jam_selesai[]" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Uraian Kegiatan <span class="text-red-500">*</span></label>
                    <textarea name="log_uraian[]" rows="3" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                              placeholder="Deskripsikan kegiatan yang dilakukan"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hasil Kegiatan</label>
                    <textarea name="log_hasil[]" rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                              placeholder="Hasil yang dicapai"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kendala</label>
                    <textarea name="log_kendala[]" rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                              placeholder="Kendala yang dihadapi (jika ada)"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Bukti Kegiatan (PDF)
                        <span class="text-gray-500 text-xs">(Bisa upload lebih dari 1 file, maksimal 5MB per file)</span>
                    </label>
                    <input type="file" name="bukti_kegiatan[0][]" multiple accept=".pdf"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bukti-input">
                    <p class="text-xs text-gray-500 mt-1"><i class="fas fa-info-circle"></i> Format: PDF (Foto kegiatan, dokumentasi, dll)</p>
                </div>
            </div>
        </div>
    </template>

    <script>
        let logCount = 0;

        function addLog() {
            logCount++;
            const template = document.getElementById('log-template');
            const container = document.getElementById('log-container');
            const clone = template.content.cloneNode(true);
            
            clone.querySelector('.log-number').textContent = logCount;
            
            // Update name attributes with correct index
            const index = logCount - 1;
            clone.querySelectorAll('input[name="bukti_kegiatan[0][]"]').forEach(input => {
                input.name = `bukti_kegiatan[${index}][]`;
            });
            clone.querySelectorAll('input[name="log_jam_mulai[]"]').forEach(input => {
                input.name = `log_jam_mulai[${index}]`;
            });
            clone.querySelectorAll('input[name="log_jam_selesai[]"]').forEach(input => {
                input.name = `log_jam_selesai[${index}]`;
            });
            clone.querySelectorAll('textarea[name="log_uraian[]"]').forEach(textarea => {
                textarea.name = `log_uraian[${index}]`;
            });
            clone.querySelectorAll('textarea[name="log_hasil[]"]').forEach(textarea => {
                textarea.name = `log_hasil[${index}]`;
            });
            clone.querySelectorAll('textarea[name="log_kendala[]"]').forEach(textarea => {
                textarea.name = `log_kendala[${index}]`;
            });
            
            container.appendChild(clone);
            document.getElementById('log-count').value = logCount;
        }

        function removeLog(button) {
            const logItem = button.closest('.log-item');
            logItem.remove();

            // Renumber logs and update name attributes
            document.querySelectorAll('.log-item').forEach((item, index) => {
                item.querySelector('.log-number').textContent = index + 1;
                
                // Update all name attributes
                item.querySelectorAll('input[type="file"]').forEach(input => {
                    input.name = `bukti_kegiatan[${index}][]`;
                });
                item.querySelectorAll('input[name*="log_jam_mulai"]').forEach(input => {
                    input.name = `log_jam_mulai[${index}]`;
                });
                item.querySelectorAll('input[name*="log_jam_selesai"]').forEach(input => {
                    input.name = `log_jam_selesai[${index}]`;
                });
                item.querySelectorAll('textarea[name*="log_uraian"]').forEach(textarea => {
                    textarea.name = `log_uraian[${index}]`;
                });
                item.querySelectorAll('textarea[name*="log_hasil"]').forEach(textarea => {
                    textarea.name = `log_hasil[${index}]`;
                });
                item.querySelectorAll('textarea[name*="log_kendala"]').forEach(textarea => {
                    textarea.name = `log_kendala[${index}]`;
                });
            });

            logCount = document.querySelectorAll('.log-item').length;
            document.getElementById('log-count').value = logCount;
        }

        // Add first log on page load
        addLog();
    </script>

    <!-- Footer -->
    <footer class="bg-white/80 backdrop-blur-sm border-t mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Sistem Kemahasiswaan. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
