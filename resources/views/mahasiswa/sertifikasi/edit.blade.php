<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sertifikasi - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4"><div class="flex justify-between items-center">
            <a href="{{ route('mahasiswa.sertifikasi.index') }}" class="flex items-center gap-2 hover:opacity-80 transition"><i class="fas fa-arrow-left"></i><span class="font-semibold">Kembali</span></a>
            <div class="flex items-center space-x-4"><div class="text-right hidden md:block"><p class="font-medium">{{ auth()->guard('mahasiswa')->user()->name }}</p><p class="text-xs text-blue-200">{{ auth()->guard('mahasiswa')->user()->nim }}</p></div>
            <form action="{{ route('mahasiswa.logout') }}" method="POST" class="inline">@csrf<button type="submit" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition"><i class="fas fa-sign-out-alt"></i></button></form></div>
        </div></div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center"><i class="fas fa-edit text-white text-xl"></i></div>
                <div><h2 class="text-2xl font-bold text-gray-800">Edit Sertifikasi</h2><p class="text-gray-500 text-sm">Perbarui informasi sertifikasi</p></div>
            </div>

            @if($errors->any())<div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6"><ul class="list-disc list-inside text-red-700 text-sm">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

            <form action="{{ route('mahasiswa.sertifikasi.update', $sertifikasi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="space-y-6">
                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2"><i class="fas fa-certificate text-indigo-600 mr-2"></i>Informasi Sertifikasi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-gray-700 font-semibold mb-2">Level <span class="text-red-500">*</span></label>
                                <select name="level" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500" required>
                                    <option value="">Pilih Level</option><option value="Provinsi" {{ old('level', $sertifikasi->level) == 'Provinsi' ? 'selected' : '' }}>Provinsi</option><option value="Nasional" {{ old('level', $sertifikasi->level) == 'Nasional' ? 'selected' : '' }}>Nasional</option><option value="Internasional" {{ old('level', $sertifikasi->level) == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                </select>
                            </div>
                            <div><label class="block text-gray-700 font-semibold mb-2">Nama Sertifikasi <span class="text-red-500">*</span></label><input type="text" name="nama_sertifikasi" value="{{ old('nama_sertifikasi', $sertifikasi->nama_sertifikasi) }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500" required></div>
                            <div><label class="block text-gray-700 font-semibold mb-2">Nama Penyelenggara <span class="text-red-500">*</span></label><input type="text" name="nama_penyelenggara" value="{{ old('nama_penyelenggara', $sertifikasi->nama_penyelenggara) }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500" required></div>
                            <div><label class="block text-gray-700 font-semibold mb-2">Tanggal Sertifikat</label><input type="date" name="tanggal_sertifikat" value="{{ old('tanggal_sertifikat', $sertifikasi->tanggal_sertifikat?->format('Y-m-d')) }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500"></div>
                            <div class="md:col-span-2"><label class="block text-gray-700 font-semibold mb-2">URL Sertifikasi</label><input type="url" name="url_sertifikasi" value="{{ old('url_sertifikasi', $sertifikasi->url_sertifikasi) }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500"></div>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2"><i class="fas fa-users text-indigo-600 mr-2"></i>Data Peserta</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-gray-700 font-semibold mb-2">NIM</label><input type="text" value="{{ $sertifikasi->nim }}" disabled class="w-full px-4 py-3 border rounded-lg bg-gray-100"></div>
                            <div><label class="block text-gray-700 font-semibold mb-2">NIDN/NUPTK</label><input type="text" name="nidn_nuptk" value="{{ old('nidn_nuptk', $sertifikasi->nidn_nuptk) }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500"></div>
                            <div><label class="block text-gray-700 font-semibold mb-2">Nama Dosen</label><input type="text" name="nama_dosen" value="{{ old('nama_dosen', $sertifikasi->nama_dosen) }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500"></div>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2"><i class="fas fa-file-upload text-indigo-600 mr-2"></i>Dokumen</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-gray-700 font-semibold mb-2">Dokumen Sertifikat (PDF)</label><input type="file" name="dokumen_sertifikat" accept=".pdf" class="w-full px-4 py-3 border rounded-lg">@if($sertifikasi->dokumen_sertifikat)<p class="text-xs text-gray-500 mt-1">File: {{ basename($sertifikasi->dokumen_sertifikat) }}</p>@endif</div>
                            <div><label class="block text-gray-700 font-semibold mb-2">Foto Kegiatan</label><input type="file" name="foto_kegiatan" accept="image/*" class="w-full px-4 py-3 border rounded-lg">@if($sertifikasi->foto_kegiatan)<p class="text-xs text-gray-500 mt-1">File: {{ basename($sertifikasi->foto_kegiatan) }}</p>@endif</div>
                            <div><label class="block text-gray-700 font-semibold mb-2">Dokumen Bukti</label><input type="file" name="dokumen_bukti" accept=".pdf,image/*" class="w-full px-4 py-3 border rounded-lg">@if($sertifikasi->dokumen_bukti)<p class="text-xs text-gray-500 mt-1">File: {{ basename($sertifikasi->dokumen_bukti) }}</p>@endif</div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-6 mt-6 border-t">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-yellow-500 to-orange-600 text-white px-6 py-3 rounded-lg font-semibold">Update</button>
                    <a href="{{ route('mahasiswa.sertifikasi.index') }}" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold text-center">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
