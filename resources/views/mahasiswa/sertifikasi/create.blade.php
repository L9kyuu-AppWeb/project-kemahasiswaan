@extends('mahasiswa.layouts.app')

@section('title', 'Tambah Sertifikasi')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-plus-circle text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Tambah Sertifikasi</h2>
                    <p class="text-gray-500 text-sm">Tambahkan sertifikasi Anda</p>
                </div>
            </div>

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                    <div>
                        <h4 class="font-semibold text-red-800 mb-2">Terdapat {{ count($errors) }} kesalahan:</h4>
                        <ul class="list-disc list-inside space-y-1 text-red-700 text-sm">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <form action="{{ route('mahasiswa.sertifikasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-certificate text-indigo-600 mr-2"></i>Informasi Sertifikasi
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Nama Sertifikasi <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_sertifikasi" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Nama Penyelenggara <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_penyelenggara" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Tanggal Sertifikat</label>
                                <input type="date" name="tanggal_sertifikat" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-semibold mb-2">URL Sertifikasi</label>
                                <input type="url" name="url_sertifikasi" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Data Kegiatan -->
                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-clipboard-list text-indigo-600 mr-2"></i>Data Kegiatan
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Jenis Kegiatan</label>
                                <select name="jenis_kegiatan_id" id="jenis_kegiatan_id" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500" onchange="loadDetails()">
                                    <option value="">Pilih Jenis</option>
                                    @foreach($jenisKegiatans as $jenis)
                                    <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Detail Kegiatan</label>
                                <select name="detail_kegiatan_id" id="detail_kegiatan_id" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500" onchange="loadNilai()">
                                    <option value="">Pilih Detail</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Ruang Lingkup</label>
                                <select name="ruang_lingkup_id" id="ruang_lingkup_id" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500" onchange="loadNilai()">
                                    <option value="">Pilih Ruang Lingkup</option>
                                    <option value="1">Lokal</option>
                                    <option value="2">Kota</option>
                                    <option value="3">Provinsi</option>
                                    <option value="4">Wilayah</option>
                                    <option value="5">Nasional</option>
                                    <option value="6">Internasional</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Nilai/Point</label>
                                <input type="number" name="nilai" id="nilai" value="0" readonly class="w-full px-4 py-3 border rounded-lg bg-gray-100 font-bold text-indigo-600">
                                <p class="text-xs text-gray-500 mt-1">Otomatis terisi saat memilih detail & ruang lingkup</p>
                            </div>
                        </div>
                    </div>

                    <!-- Data Peserta -->
                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-users text-indigo-600 mr-2"></i>Data Peserta
                        </h3>
                        
                        <!-- Mahasiswa (Automatis) -->
                        <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 mb-4">
                            <h4 class="font-semibold text-indigo-800 mb-3">
                                <i class="fas fa-user-graduate mr-2"></i>Data Mahasiswa (Otomatis)
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-indigo-700 font-semibold mb-2">NIM</label>
                                    <input type="text" value="{{ $mahasiswa->nim }}" disabled
                                           class="w-full px-4 py-3 border border-indigo-300 rounded-lg bg-white font-medium text-gray-700">
                                </div>
                                <div>
                                    <label class="block text-indigo-700 font-semibold mb-2">Nama</label>
                                    <input type="text" value="{{ $mahasiswa->name }}" disabled
                                           class="w-full px-4 py-3 border border-indigo-300 rounded-lg bg-white font-medium text-gray-700">
                                </div>
                            </div>
                            <input type="hidden" name="mahasiswa_id" value="{{ $mahasiswa->id }}">
                        </div>

                        <!-- Dosen (Pilihan) -->
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-3">
                                <i class="fas fa-chalkboard-teacher mr-2"></i>Data Dosen Pembimbing
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-gray-700 font-semibold mb-2">Pilih Dosen</label>
                                    <select name="dosen_id" id="dosen_id" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                                        <option value="">-- Pilih Dosen Pembimbing (Opsional) --</option>
                                        @foreach($dosens as $dosen)
                                        <option value="{{ $dosen->id }}" {{ old('dosen_id') == $dosen->id ? 'selected' : '' }}>
                                            {{ $dosen->nama }} ({{ $dosen->nuptk }})
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('dosen_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-file-upload text-indigo-600 mr-2"></i>Dokumen
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Dokumen Sertifikat (PDF) <span class="text-red-500">*</span></label>
                                <input type="file" name="dokumen_sertifikat" accept=".pdf" class="w-full px-4 py-3 border rounded-lg" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Foto Kegiatan</label>
                                <input type="file" name="foto_kegiatan" accept="image/*" class="w-full px-4 py-3 border rounded-lg">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Dokumen Bukti (PDF/Image) <span class="text-red-500">*</span></label>
                                <input type="file" name="dokumen_bukti" accept=".pdf,image/*" class="w-full px-4 py-3 border rounded-lg" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-6 mt-6 border-t">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold shadow-md">
                        <i class="fas fa-save mr-2"></i>Simpan Sertifikasi
                    </button>
                    <a href="{{ route('mahasiswa.sertifikasi.index') }}" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold text-center">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
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
            fetch('/api/sertifikasi/detail-kegiatan?jenis_id=' + jenisId)
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
            fetch('/api/sertifikasi/nilai?jenis_id=' + jenisId + '&detail_id=' + detailId + '&ruang_id=' + ruangId)
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
@endsection
