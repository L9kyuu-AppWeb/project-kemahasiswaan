<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Rekognisi - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('mahasiswa.rekognisi.index') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                    <i class="fas fa-arrow-left"></i><span class="font-semibold">Kembali</span>
                </a>
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="font-medium">{{ auth()->guard('mahasiswa')->user()->name }}</p>
                        <p class="text-xs text-blue-200">{{ auth()->guard('mahasiswa')->user()->nim }}</p>
                    </div>
                    <form action="{{ route('mahasiswa.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition"><i class="fas fa-sign-out-alt"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-edit text-white text-xl"></i>
                </div>
                <div><h2 class="text-2xl font-bold text-gray-800">Edit Rekognisi</h2><p class="text-gray-500 text-sm">Perbarui informasi rekognisi</p></div>
            </div>

            @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6"><ul class="list-disc list-inside text-red-700 text-sm">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif

            <form action="{{ route('mahasiswa.rekognisi.update', $rekognisi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="space-y-6">
                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2"><i class="fas fa-certificate text-cyan-600 mr-2"></i>Informasi Rekognisi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Level <span class="text-red-500">*</span></label>
                                <select name="level" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-cyan-500" required>
                                    <option value="">Pilih Level</option>
                                    <option value="Provinsi" {{ old('level', $rekognisi->level) == 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                                    <option value="Nasional" {{ old('level', $rekognisi->level) == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                    <option value="Internasional" {{ old('level', $rekognisi->level) == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Jenis Rekognisi <span class="text-red-500">*</span></label>
                                <select name="jenis_rekognisi_id" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-cyan-500" required>
                                    <option value="">Pilih Jenis</option>
                                    @foreach($jenisRekognisiList as $jenis)<option value="{{ $jenis->id }}" {{ old('jenis_rekognisi_id', $rekognisi->jenis_rekognisi_id) == $jenis->id ? 'selected' : '' }}>{{ $jenis->nama }}</option>@endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-semibold mb-2">Nama Rekognisi <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_rekognisi" value="{{ old('nama_rekognisi', $rekognisi->nama_rekognisi) }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-cyan-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Nama Penyelenggara <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_penyelenggara" value="{{ old('nama_penyelenggara', $rekognisi->nama_penyelenggara) }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-cyan-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Tanggal Sertifikat</label>
                                <input type="date" name="tanggal_sertifikat" value="{{ old('tanggal_sertifikat', $rekognisi->tanggal_sertifikat?->format('Y-m-d')) }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-cyan-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-semibold mb-2">URL Rekognisi</label>
                                <input type="url" name="url_rekognisi" value="{{ old('url_rekognisi', $rekognisi->url_rekognisi) }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-cyan-500">
                            </div>
                        </div>
                    </div>

                    <!-- Data Kegiatan -->
                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2"><i class="fas fa-clipboard-list text-cyan-600 mr-2"></i>Data Kegiatan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Jenis Kegiatan</label>
                                <select name="jenis_kegiatan_id" id="jenis_kegiatan_id" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-cyan-500" onchange="loadDetails()">
                                    <option value="">Pilih Jenis</option>
                                    @foreach($jenisKegiatans as $jenis)<option value="{{ $jenis->id }}" {{ old('jenis_kegiatan_id', $rekognisi->jenis_kegiatan_id) == $jenis->id ? 'selected' : '' }}>{{ $jenis->nama }}</option>@endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Detail Kegiatan</label>
                                <select name="detail_kegiatan_id" id="detail_kegiatan_id" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-cyan-500" onchange="loadNilai()">
                                    <option value="">Pilih Detail</option>
                                    @if($rekognisi->detailKegiatan)<option value="{{ $rekognisi->detail_kegiatan_id }}" selected>{{ $rekognisi->detailKegiatan->nama }}</option>@endif
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Ruang Lingkup</label>
                                <select name="ruang_lingkup_id" id="ruang_lingkup_id" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-cyan-500" onchange="loadNilai()">
                                    <option value="">Pilih Ruang Lingkup</option>
                                    <option value="1" {{ old('ruang_lingkup_id', $rekognisi->ruang_lingkup_id) == 1 ? 'selected' : '' }}>Lokal</option>
                                    <option value="2" {{ old('ruang_lingkup_id', $rekognisi->ruang_lingkup_id) == 2 ? 'selected' : '' }}>Kota</option>
                                    <option value="3" {{ old('ruang_lingkup_id', $rekognisi->ruang_lingkup_id) == 3 ? 'selected' : '' }}>Provinsi</option>
                                    <option value="4" {{ old('ruang_lingkup_id', $rekognisi->ruang_lingkup_id) == 4 ? 'selected' : '' }}>Wilayah</option>
                                    <option value="5" {{ old('ruang_lingkup_id', $rekognisi->ruang_lingkup_id) == 5 ? 'selected' : '' }}>Nasional</option>
                                    <option value="6" {{ old('ruang_lingkup_id', $rekognisi->ruang_lingkup_id) == 6 ? 'selected' : '' }}>Internasional</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Nilai/Point</label>
                                <input type="number" name="nilai" id="nilai" value="{{ old('nilai', $rekognisi->nilai ?? 0) }}" readonly class="w-full px-4 py-3 border rounded-lg bg-gray-100 font-bold text-indigo-600">
                                <p class="text-xs text-gray-500 mt-1">Otomatis terisi saat memilih detail & ruang lingkup</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2"><i class="fas fa-users text-cyan-600 mr-2"></i>Data Peserta</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-gray-700 font-semibold mb-2">NIM</label><input type="text" value="{{ $rekognisi->nim }}" disabled class="w-full px-4 py-3 border rounded-lg bg-gray-100"></div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Dosen Pembimbing</label>
                                <select name="dosen_id" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-cyan-500">
                                    <option value="">-- Pilih Dosen (Opsional) --</option>
                                    @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->id }}" {{ old('dosen_id', $rekognisi->dosen_id) == $dosen->id ? 'selected' : '' }}>
                                        {{ $dosen->nama }} ({{ $dosen->nuptk }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2"><i class="fas fa-file-upload text-cyan-600 mr-2"></i>Dokumen</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-gray-700 font-semibold mb-2">Dokumen Sertifikat (PDF)</label><input type="file" name="dokumen_sertifikat" accept=".pdf" class="w-full px-4 py-3 border rounded-lg">@if($rekognisi->dokumen_sertifikat)<p class="text-xs text-gray-500 mt-1">File: {{ basename($rekognisi->dokumen_sertifikat) }}</p>@endif</div>
                            <div><label class="block text-gray-700 font-semibold mb-2">Foto Kegiatan</label><input type="file" name="foto_kegiatan" accept="image/*" class="w-full px-4 py-3 border rounded-lg">@if($rekognisi->foto_kegiatan)<p class="text-xs text-gray-500 mt-1">File: {{ basename($rekognisi->foto_kegiatan) }}</p>@endif</div>
                            <div><label class="block text-gray-700 font-semibold mb-2">Dokumen Bukti</label><input type="file" name="dokumen_bukti" accept=".pdf,image/*" class="w-full px-4 py-3 border rounded-lg">@if($rekognisi->dokumen_bukti)<p class="text-xs text-gray-500 mt-1">File: {{ basename($rekognisi->dokumen_bukti) }}</p>@endif</div>
                            <div><label class="block text-gray-700 font-semibold mb-2">Surat Tugas (PDF)</label><input type="file" name="surat_tugas" accept=".pdf" class="w-full px-4 py-3 border rounded-lg">@if($rekognisi->surat_tugas)<p class="text-xs text-gray-500 mt-1">File: {{ basename($rekognisi->surat_tugas) }}</p>@endif</div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-6 mt-6 border-t">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-yellow-500 to-orange-600 text-white px-6 py-3 rounded-lg font-semibold"><i class="fas fa-save mr-2"></i>Update</button>
                    <a href="{{ route('mahasiswa.rekognisi.index') }}" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold text-center"><i class="fas fa-times mr-2"></i>Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
    function loadDetails() {
        const jenisId = document.getElementById('jenis_kegiatan_id').value;
        const detailSelect = document.getElementById('detail_kegiatan_id');
        const ruangLingkupSelect = document.getElementById('ruang_lingkup_id');
        const nilaiInput = document.getElementById('nilai');
        
        // Reset detail, ruang lingkup, and nilai when jenis kegiatan changes
        detailSelect.innerHTML = '<option value="">Pilih Detail</option>';
        ruangLingkupSelect.value = '';
        nilaiInput.value = 0;

        if (jenisId) {
            fetch('/api/rekognisi/detail-kegiatan?jenis_id=' + jenisId)
                .then(r => r.json())
                .then(data => {
                    data.forEach(d => {
                        detailSelect.innerHTML += '<option value="' + d.id + '">' + d.nama + '</option>';
                    });
                })
                .catch(err => console.error('Error loading details:', err));
        }
    }

    function loadNilai() {
        const jenisId = document.getElementById('jenis_kegiatan_id').value;
        const detailId = document.getElementById('detail_kegiatan_id').value;
        const ruangId = document.getElementById('ruang_lingkup_id').value;
        const nilaiInput = document.getElementById('nilai');

        if (jenisId && detailId && ruangId) {
            fetch('/api/rekognisi/nilai?jenis_id=' + jenisId + '&detail_id=' + detailId + '&ruang_id=' + ruangId)
                .then(r => r.json())
                .then(data => {
                    nilaiInput.value = data.nilai || 0;
                })
                .catch(err => console.error('Error loading nilai:', err));
        } else {
            nilaiInput.value = 0;
        }
    }
    </script>
</body>
</html>
