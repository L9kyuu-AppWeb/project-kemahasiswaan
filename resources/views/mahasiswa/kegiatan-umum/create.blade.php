@extends('mahasiswa.layouts.app')

@section('title', 'Tambah Kegiatan Umum')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-plus-circle text-white text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Tambah Kegiatan Umum</h2>
                <p class="text-gray-500 text-sm">Ajukan kegiatan umum Anda</p>
            </div>
        </div>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <ul class="list-disc list-inside text-red-700 text-sm">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('mahasiswa.kegiatan-umum.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <!-- Informasi Kegiatan -->
                <div>
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2"><i class="fas fa-info-circle text-purple-600 mr-2"></i>Informasi Kegiatan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Kategori <span class="text-red-500">*</span></label>
                            <select name="kategori" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoriList as $kategori)
                                <option value="{{ $kategori->nama_kategori }}" {{ old('kategori') == $kategori->nama_kategori ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Nama Kegiatan <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_kompetisi" value="{{ old('nama_kompetisi') }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Penyelenggara <span class="text-red-500">*</span></label>
                            <input type="text" name="penyelenggara" value="{{ old('penyelenggara') }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">URL Kegiatan</label>
                            <input type="url" name="url_kegiatan" value="{{ old('url_kegiatan') }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
                        </div>
                    </div>
                </div>

                <!-- Data Kegiatan (Optional) -->
                <div>
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2"><i class="fas fa-clipboard-list text-purple-600 mr-2"></i>Data Kegiatan (Opsional)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Jenis Kegiatan</label>
                            <select name="jenis_kegiatan_id" id="jenis_kegiatan_id" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500" onchange="loadDetails()">
                                <option value="">Pilih Jenis</option>
                                @foreach($jenisKegiatans as $jenis)
                                <option value="{{ $jenis->id }}" {{ old('jenis_kegiatan_id') == $jenis->id ? 'selected' : '' }}>{{ $jenis->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Detail Kegiatan</label>
                            <select name="detail_kegiatan_id" id="detail_kegiatan_id" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500" onchange="loadNilai()">
                                <option value="">Pilih Detail</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Ruang Lingkup</label>
                            <select name="ruang_lingkup_id" id="ruang_lingkup_id" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500" onchange="loadNilai()">
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
                            <input type="number" name="nilai" id="nilai" value="{{ old('nilai', 0) }}" readonly class="w-full px-4 py-3 border rounded-lg bg-gray-100 font-bold text-purple-600">
                            <p class="text-xs text-gray-500 mt-1">Otomatis terisi saat memilih detail & ruang lingkup</p>
                        </div>
                    </div>
                </div>

                <!-- Data Dosen -->
                <div>
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2"><i class="fas fa-chalkboard-teacher text-purple-600 mr-2"></i>Dosen Pembimbing</h3>
                    <div>
                        <select name="dosen_id" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
                            <option value="">-- Pilih Dosen (Opsional) --</option>
                            @foreach($dosens as $dosen)
                            <option value="{{ $dosen->id }}" {{ old('dosen_id') == $dosen->id ? 'selected' : '' }}>{{ $dosen->nama }} ({{ $dosen->nuptk }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Dokumen -->
                <div>
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2"><i class="fas fa-file-upload text-purple-600 mr-2"></i>Dokumen</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Dokumen Sertifikat (PDF) <span class="text-red-500">*</span></label>
                            <input type="file" name="dokumen_sertifikat" accept=".pdf" class="w-full px-4 py-3 border rounded-lg" required>
                            <p class="text-xs text-gray-500 mt-1">Maksimal 5MB</p>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Tanggal Sertifikat</label>
                            <input type="date" name="tanggal_sertifikat" value="{{ old('tanggal_sertifikat') }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Surat Tugas (PDF)</label>
                            <input type="file" name="url_surat_tugas" accept=".pdf" class="w-full px-4 py-3 border rounded-lg">
                            <p class="text-xs text-gray-500 mt-1">Maksimal 5MB</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-6 mt-6 border-t">
                <button type="submit" class="flex-1 bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-6 py-3 rounded-lg font-semibold">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
                <a href="{{ route('mahasiswa.kegiatan-umum.index') }}" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold text-center">
                    Batal
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

    detailSelect.innerHTML = '<option value="">Pilih Detail</option>';
    ruangLingkupSelect.value = '';
    nilaiInput.value = 0;

    if (jenisId) {
        fetch('/mahasiswa/kegiatan-umum/api/detail-kegiatan?jenis_id=' + jenisId)
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
        fetch('/mahasiswa/kegiatan-umum/api/nilai?jenis_id=' + jenisId + '&detail_id=' + detailId + '&ruang_id=' + ruangId)
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
