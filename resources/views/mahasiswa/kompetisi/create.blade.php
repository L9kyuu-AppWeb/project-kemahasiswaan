@extends('mahasiswa.layouts.app')

@section('title', 'Tambah Kompetisi')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-plus-circle text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Tambah Kompetisi</h2>
                    <p class="text-gray-500 text-sm">Tambahkan prestasi kompetisi Anda</p>
                </div>
            </div>

            @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
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

            <form action="{{ route('mahasiswa.kompetisi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <!-- Informasi Kompetisi -->
                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-trophy text-emerald-600 mr-2"></i>Informasi Kompetisi
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Kategori <span class="text-red-500">*</span></label>
                                <select name="kategori" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategoriList as $kategori)
                                    <option value="{{ $kategori->nama }}">{{ $kategori->nama }}</option>
                                    @endforeach
                                </select>
                                @error('kategori')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-semibold mb-2">Nama Kompetisi/Lomba <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_kompetisi" value="{{ old('nama_kompetisi') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                                @error('nama_kompetisi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Nama Cabang</label>
                                <input type="text" name="nama_cabang" value="{{ old('nama_cabang') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                @error('nama_cabang')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Peringkat <span class="text-red-500">*</span></label>
                                <select name="peringkat" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                                    <option value="">Pilih Peringkat</option>
                                    <option value="Juara 1">Juara 1</option>
                                    <option value="Juara 2">Juara 2</option>
                                    <option value="Juara 3">Juara 3</option>
                                    <option value="Harapan 1">Harapan 1</option>
                                    <option value="Harapan 2">Harapan 2</option>
                                    <option value="Harapan 3">Harapan 3</option>
                                    <option value="Apresiasi Kejuaraan">Apresiasi Kejuaraan</option>
                                    <option value="Penghargaan Tambahan">Penghargaan Tambahan</option>
                                    <option value="Juara Umum">Juara Umum</option>
                                    <option value="Peserta">Peserta</option>
                                </select>
                                @error('peringkat')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Kegiatan Fields -->
                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-clipboard-list text-emerald-600 mr-2"></i>Data Kegiatan
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Jenis Kegiatan</label>
                                <select name="jenis_kegiatan_id" id="jenis_kegiatan_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" onchange="loadDetails()">
                                    <option value="">Pilih Jenis</option>
                                    @foreach($jenisKegiatans as $jenis)
                                    <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Detail Kegiatan</label>
                                <select name="detail_kegiatan_id" id="detail_kegiatan_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" onchange="loadNilai()">
                                    <option value="">Pilih Detail</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Ruang Lingkup</label>
                                <select name="ruang_lingkup_id" id="ruang_lingkup_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" onchange="loadNilai()">
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
                                <input type="number" name="nilai" id="nilai" value="{{ old('nilai', 0) }}" readonly
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 font-bold text-indigo-600">
                                <p class="text-xs text-gray-500 mt-1">Otomatis terisi saat memilih detail & ruang lingkup</p>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Kompetisi -->
                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-info-circle text-emerald-600 mr-2"></i>Detail Kompetisi
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Penyelenggara <span class="text-red-500">*</span></label>
                                <input type="text" name="penyelenggara" value="{{ old('penyelenggara') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                                @error('penyelenggara')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Jumlah PT/Negara Peserta</label>
                                <input type="text" name="jumlah_pt_negara_peserta" value="{{ old('jumlah_pt_negara_peserta') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                @error('jumlah_pt_negara_peserta')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Kepesertaan <span class="text-red-500">*</span></label>
                                <select name="kepesertaan" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                                    <option value="">Pilih Kepesertaan</option>
                                    <option value="Individu">Individu</option>
                                    <option value="Kelompok">Kelompok</option>
                                </select>
                                @error('kepesertaan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Bentuk <span class="text-red-500">*</span></label>
                                <select name="bentuk" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                                    <option value="">Pilih Bentuk</option>
                                    <option value="Luring/Hibrida">Luring/Hibrida</option>
                                    <option value="Daring">Daring</option>
                                </select>
                                @error('bentuk')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-semibold mb-2">URL Kompetisi</label>
                                <input type="url" name="url_kompetisi" value="{{ old('url_kompetisi') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                @error('url_kompetisi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Data Peserta -->
                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-users text-emerald-600 mr-2"></i>Data Peserta
                        </h3>
                        
                        <!-- Mahasiswa (Automatis) -->
                        <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 mb-4">
                            <h4 class="font-semibold text-emerald-800 mb-3">
                                <i class="fas fa-user-graduate mr-2"></i>Data Mahasiswa (Otomatis)
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-emerald-700 font-semibold mb-2">NIM</label>
                                    <input type="text" value="{{ $mahasiswa->nim }}" disabled
                                           class="w-full px-4 py-3 border border-emerald-300 rounded-lg bg-white font-medium text-gray-700">
                                </div>
                                <div>
                                    <label class="block text-emerald-700 font-semibold mb-2">Nama</label>
                                    <input type="text" value="{{ $mahasiswa->name }}" disabled
                                           class="w-full px-4 py-3 border border-emerald-300 rounded-lg bg-white font-medium text-gray-700">
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
                                    <select name="dosen_id" id="dosen_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
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

                        <!-- Surat Tugas -->
                        <div class="mt-4">
                            <label class="block text-gray-700 font-semibold mb-2">Surat Tugas (PDF)</label>
                            <input type="file" name="url_surat_tugas" accept=".pdf"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <p class="text-xs text-gray-500 mt-1">Maksimal 5MB</p>
                            @error('url_surat_tugas')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Dokumen -->
                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-file-upload text-emerald-600 mr-2"></i>Dokumen
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Dokumen Sertifikat (PDF) <span class="text-red-500">*</span></label>
                                <input type="file" name="dokumen_sertifikat" accept=".pdf"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                                <p class="text-xs text-gray-500 mt-1">Maksimal 5MB</p>
                                @error('dokumen_sertifikat')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Tanggal Sertifikat</label>
                                <input type="date" name="tanggal_sertifikat" value="{{ old('tanggal_sertifikat') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                @error('tanggal_sertifikat')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Foto UPP (JPG/PNG)</label>
                                <input type="file" name="foto_upp" accept="image/*"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                <p class="text-xs text-gray-500 mt-1">Maksimal 5MB</p>
                                @error('foto_upp')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Dokumen Undangan</label>
                                <input type="file" name="dokumen_undangan" accept=".pdf,image/*"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                <p class="text-xs text-gray-500 mt-1">Maksimal 5MB</p>
                                @error('dokumen_undangan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-6 mt-6 border-t">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-6 py-3 rounded-lg hover:from-emerald-600 hover:to-teal-700 transition duration-200 font-semibold shadow-md">
                        <i class="fas fa-save mr-2"></i>Simpan Kompetisi
                    </button>
                    <a href="{{ route('mahasiswa.kompetisi.index') }}" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition duration-200 font-semibold text-center">
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
            fetch('/api/kompetisi/detail-kegiatan?jenis_id=' + jenisId)
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
            fetch('/api/kompetisi/nilai?jenis_id=' + jenisId + '&detail_id=' + detailId + '&ruang_id=' + ruangId)
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
