<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan Beasiswa - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-green-50 to-emerald-100">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-green-600 to-emerald-700 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('mahasiswa.laporan.index') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                        <i class="fas fa-arrow-left"></i>
                        <span class="font-semibold">Kembali</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="font-medium">{{ auth()->guard('mahasiswa')->user()->name }}</p>
                        <p class="text-xs text-green-200">{{ auth()->guard('mahasiswa')->user()->nim }}</p>
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
        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <h2 class="text-2xl font-bold mb-1">
                <i class="fas fa-file-alt mr-2"></i>
                Buat Laporan Beasiswa
            </h2>
            <p class="text-purple-100 text-sm">Isi form di bawah untuk membuat laporan baru</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                    <div>
                        <h4 class="font-semibold text-red-800 mb-2">Terdapat {{ count($errors) }} kesalahan:</h4>
                        <ul class="list-disc list-inside space-y-1 text-red-700 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('mahasiswa.laporan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Data Utama -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-info-circle text-purple-600"></i>
                    Data Utama
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="tahun_ajar_id" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-calendar-alt mr-2 text-purple-600"></i>
                            Tahun Ajar <span class="text-red-500">*</span>
                        </label>
                        <select name="tahun_ajar_id" id="tahun_ajar_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">-- Pilih Tahun Ajar --</option>
                            @foreach($tahunAjarList as $ta)
                                <option value="{{ $ta->id }}" {{ old('tahun_ajar_id') == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="semester" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-book mr-2 text-purple-600"></i>
                            Semester <span class="text-red-500">*</span>
                        </label>
                        <select name="semester" id="semester" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">-- Pilih Semester --</option>
                            @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>
                                    Semester {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

            <!-- 1. Akademik (Wajib) -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-graduation-cap text-blue-600"></i>
                    1. Data Akademik <span class="text-red-500 text-sm">(Wajib)</span>
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="sks" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-credit-card mr-2 text-blue-600"></i>
                            SKS <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="sks" id="sks" value="{{ old('sks') }}" min="1" max="24"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Contoh: 20" required>
                    </div>

                    <div>
                        <label for="indeks_prestasi" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-chart-line mr-2 text-blue-600"></i>
                            Indeks Prestasi <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="indeks_prestasi" id="indeks_prestasi" value="{{ old('indeks_prestasi') }}" 
                               step="0.01" min="0" max="4"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Contoh: 3.50" required>
                    </div>
                </div>

                <div class="mt-4">
                    <label for="file_khs" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-file-pdf mr-2 text-blue-600"></i>
                        Upload KHS <span class="text-red-500">*</span>
                    </label>
                    <input type="file" name="file_khs" id="file_khs" accept=".pdf"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <p class="text-gray-500 text-xs mt-1"><i class="fas fa-info-circle mr-1"></i>Format: PDF, Max: 2MB</p>
                </div>
            </div>

            <!-- 2. Referal (Opsional) -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-user-friends text-green-600"></i>
                    2. Referal <span class="text-gray-400 text-sm">(Opsional)</span>
                </h3>
                <p class="text-gray-500 text-sm mb-4">Isi data referal jika ada (bisa lebih dari 1)</p>
                
                <div id="referal-container" class="space-y-4">
                    <div class="referal-item grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-gray-50 rounded-lg">
                        <input type="text" name="referal_nama[]" placeholder="Nama Referal"
                               class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                        <input type="text" name="referal_telp[]" placeholder="No. Telepon"
                               class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                        <input type="text" name="referal_prodi[]" placeholder="Program Studi"
                               class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                </div>
                <button type="button" onclick="addReferal()" class="mt-4 text-green-600 hover:text-green-700 text-sm font-medium flex items-center gap-1">
                    <i class="fas fa-plus-circle"></i> Tambah Referal
                </button>
            </div>

            <!-- 3. Pendanaan (Opsional) -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-money-bill-wave text-orange-600"></i>
                    3. Pendanaan <span class="text-gray-400 text-sm">(Opsional)</span>
                </h3>
                <p class="text-gray-500 text-sm mb-4">Isi data pendanaan jika ada (bisa lebih dari 1)</p>
                
                <div id="pendanaan-container" class="space-y-4">
                    <div class="pendanaan-item p-4 bg-gray-50 rounded-lg space-y-3">
                        <input type="text" name="pendanaan_nama[]" placeholder="Nama Pendanaan"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <input type="text" name="pendanaan_judul[]" placeholder="Judul Kegiatan/Proyek"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <select name="pendanaan_keterangan[]" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="lolos">Lolos</option>
                                <option value="tidak">Tidak Lolos</option>
                            </select>
                            <select name="pendanaan_posisi[]" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="ketua">Ketua</option>
                                <option value="anggota">Anggota</option>
                            </select>
                            <input type="file" name="pendanaan_bukti[]" accept=".pdf"
                                   class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                    </div>
                </div>
                <button type="button" onclick="addPendanaan()" class="mt-4 text-orange-600 hover:text-orange-700 text-sm font-medium flex items-center gap-1">
                    <i class="fas fa-plus-circle"></i> Tambah Pendanaan
                </button>
            </div>

            <!-- 4. Kompetisi (Opsional) -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-trophy text-yellow-600"></i>
                    4. Kompetisi <span class="text-gray-400 text-sm">(Opsional)</span>
                </h3>
                <p class="text-gray-500 text-sm mb-4">Isi data kompetisi jika ada (bisa lebih dari 1)</p>
                
                <div id="kompetisi-container" class="space-y-4">
                    <div class="kompetisi-item p-4 bg-gray-50 rounded-lg space-y-3">
                        <input type="text" name="kompetisi_nama[]" placeholder="Nama Kompetisi"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        <input type="text" name="kompetisi_judul[]" placeholder="Judul Karya/Proyek"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <input type="text" name="kompetisi_juara[]" placeholder="Juara (1/2/3/Terbaik)"
                                   class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <select name="kompetisi_posisi[]" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                <option value="ketua">Ketua</option>
                                <option value="anggota">Anggota</option>
                            </select>
                            <input type="file" name="kompetisi_bukti[]" accept=".pdf"
                                   class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        </div>
                    </div>
                </div>
                <button type="button" onclick="addKompetisi()" class="mt-4 text-yellow-600 hover:text-yellow-700 text-sm font-medium flex items-center gap-1">
                    <i class="fas fa-plus-circle"></i> Tambah Kompetisi
                </button>
            </div>

            <!-- 5. Publikasi (Opsional) -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-newspaper text-red-600"></i>
                    5. Publikasi <span class="text-gray-400 text-sm">(Opsional)</span>
                </h3>
                <p class="text-gray-500 text-sm mb-4">Isi data publikasi jika ada (bisa lebih dari 1)</p>
                
                <div id="publikasi-container" class="space-y-4">
                    <div class="publikasi-item p-4 bg-gray-50 rounded-lg space-y-3">
                        <input type="text" name="publikasi_judul[]" placeholder="Judul Publikasi"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        <input type="text" name="publikasi_tempat[]" placeholder="Nama Tempat Publikasi"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="url" name="publikasi_link[]" placeholder="Link Jurnal (https://...)"
                                   class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                            <select name="publikasi_kategori[]" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                                <option value="">-- Pilih Kategori --</option>
                                <option value="sinta1">Sinta 1</option>
                                <option value="sinta2">Sinta 2</option>
                                <option value="sinta3">Sinta 3</option>
                                <option value="sinta4">Sinta 4</option>
                                <option value="sinta5">Sinta 5</option>
                                <option value="sinta6">Sinta 6</option>
                                <option value="garuda">Garuda</option>
                                <option value="q1">Q1</option>
                                <option value="q2">Q2</option>
                                <option value="q3">Q3</option>
                                <option value="q4">Q4</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="button" onclick="addPublikasi()" class="mt-4 text-red-600 hover:text-red-700 text-sm font-medium flex items-center gap-1">
                    <i class="fas fa-plus-circle"></i> Tambah Publikasi
                </button>
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-4 pb-8">
                <button type="submit" name="action" value="draft"
                        class="flex-1 bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition duration-200 font-semibold shadow-md">
                    <i class="fas fa-save mr-2"></i>
                    Simpan sebagai Draft
                </button>
                <button type="submit" name="action" value="submit"
                        class="flex-1 bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition duration-200 font-semibold shadow-md">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Submit Laporan
                </button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-white/80 backdrop-blur-sm border-t mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Sistem Kemahasiswaan. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function addReferal() {
            const container = document.getElementById('referal-container');
            const newItem = document.createElement('div');
            newItem.className = 'referal-item grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-gray-50 rounded-lg mt-4';
            newItem.innerHTML = `
                <input type="text" name="referal_nama[]" placeholder="Nama Referal"
                       class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                <input type="text" name="referal_telp[]" placeholder="No. Telepon"
                       class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                <input type="text" name="referal_prodi[]" placeholder="Program Studi"
                       class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            `;
            container.appendChild(newItem);
        }

        function addPendanaan() {
            const container = document.getElementById('pendanaan-container');
            const newItem = document.createElement('div');
            newItem.className = 'pendanaan-item p-4 bg-gray-50 rounded-lg space-y-3 mt-4';
            newItem.innerHTML = `
                <input type="text" name="pendanaan_nama[]" placeholder="Nama Pendanaan"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                <input type="text" name="pendanaan_judul[]" placeholder="Judul Kegiatan/Proyek"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <select name="pendanaan_keterangan[]" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="lolos">Lolos</option>
                        <option value="tidak">Tidak Lolos</option>
                    </select>
                    <select name="pendanaan_posisi[]" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="ketua">Ketua</option>
                        <option value="anggota">Anggota</option>
                    </select>
                    <input type="file" name="pendanaan_bukti[]" accept=".pdf"
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
            `;
            container.appendChild(newItem);
        }

        function addKompetisi() {
            const container = document.getElementById('kompetisi-container');
            const newItem = document.createElement('div');
            newItem.className = 'kompetisi-item p-4 bg-gray-50 rounded-lg space-y-3 mt-4';
            newItem.innerHTML = `
                <input type="text" name="kompetisi_nama[]" placeholder="Nama Kompetisi"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                <input type="text" name="kompetisi_judul[]" placeholder="Judul Karya/Proyek"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <input type="text" name="kompetisi_juara[]" placeholder="Juara (1/2/3/Terbaik)"
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <select name="kompetisi_posisi[]" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        <option value="ketua">Ketua</option>
                        <option value="anggota">Anggota</option>
                    </select>
                    <input type="file" name="kompetisi_bukti[]" accept=".pdf"
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                </div>
            `;
            container.appendChild(newItem);
        }

        function addPublikasi() {
            const container = document.getElementById('publikasi-container');
            const newItem = document.createElement('div');
            newItem.className = 'publikasi-item p-4 bg-gray-50 rounded-lg space-y-3 mt-4';
            newItem.innerHTML = `
                <input type="text" name="publikasi_judul[]" placeholder="Judul Publikasi"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                <input type="text" name="publikasi_tempat[]" placeholder="Nama Tempat Publikasi"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="url" name="publikasi_link[]" placeholder="Link Jurnal (https://...)"
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                    <select name="publikasi_kategori[]" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="sinta1">Sinta 1</option>
                        <option value="sinta2">Sinta 2</option>
                        <option value="sinta3">Sinta 3</option>
                        <option value="sinta4">Sinta 4</option>
                        <option value="sinta5">Sinta 5</option>
                        <option value="sinta6">Sinta 6</option>
                        <option value="garuda">Garuda</option>
                        <option value="q1">Q1</option>
                        <option value="q2">Q2</option>
                        <option value="q3">Q3</option>
                        <option value="q4">Q4</option>
                    </select>
                </div>
            `;
            container.appendChild(newItem);
        }
    </script>
</body>
</html>
