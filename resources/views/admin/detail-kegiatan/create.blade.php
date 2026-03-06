<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><title>Tambah Detail Kegiatan</title><script src="https://cdn.tailwindcss.com"></script><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
<body class="bg-gray-50">
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4"><a href="{{ route('admin.master-kegiatan.detail.index') }}" class="flex items-center gap-2"><i class="fas fa-arrow-left"></i>Kembali</a></div>
    </nav>
    <div class="max-w-3xl mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4 mb-6"><div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center"><i class="fas fa-plus-circle text-white text-xl"></i></div><div><h2 class="text-2xl font-bold">Tambah Detail Kegiatan</h2></div></div>
            @if($errors->any())<div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6"><ul class="list-disc list-inside text-red-700 text-sm">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <form action="{{ route('admin.master-kegiatan.detail.store') }}" method="POST">@csrf
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Jenis Kegiatan <span class="text-red-500">*</span></label>
                    <select name="jenis_id" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500" required>
                        <option value="">Pilih Jenis</option>
                        @foreach($jenisKegiatans as $jenis)<option value="{{ $jenis->id }}" {{ old('jenis_id') == $jenis->id ? 'selected' : '' }}>{{ $jenis->nama }}</option>@endforeach
                    </select>
                </div>
                <div class="mb-6"><label class="block text-gray-700 font-semibold mb-2">Nama Detail <span class="text-red-500">*</span></label><input type="text" name="nama" value="{{ old('nama') }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500" required></div>
                <div class="flex gap-3"><button type="submit" class="flex-1 bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold">Simpan</button><a href="{{ route('admin.master-kegiatan.detail.index') }}" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold text-center">Batal</a></div>
            </form>
        </div>
    </div>
</body>
</html>
