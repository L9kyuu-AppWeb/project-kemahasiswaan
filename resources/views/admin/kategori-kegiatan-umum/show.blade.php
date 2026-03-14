@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6 pb-4 border-b">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-folder text-white text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $kategoriKegiatanUmum->nama_kategori }}</h2>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-info-circle text-purple-600"></i>Informasi Kategori
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Nama Kategori</span>
                        <span class="font-medium text-gray-800">{{ $kategoriKegiatanUmum->nama_kategori }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Dibuat</span>
                        <span class="font-medium text-gray-800">{{ $kategoriKegiatanUmum->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Terakhir Diupdate</span>
                        <span class="font-medium text-gray-800">{{ $kategoriKegiatanUmum->updated_at->format('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-3 pt-4 border-t">
            <a href="{{ route('admin.kategori-kegiatan-umum.edit', $kategoriKegiatanUmum->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg transition font-semibold">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <form action="{{ route('admin.kategori-kegiatan-umum.destroy', $kategoriKegiatanUmum->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                @csrf @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg transition font-semibold">
                    <i class="fas fa-trash mr-2"></i>Hapus
                </button>
            </form>
            <a href="{{ route('admin.kategori-kegiatan-umum.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg transition font-semibold">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>
</div>
@endsection
