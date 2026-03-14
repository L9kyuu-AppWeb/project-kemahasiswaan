@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-edit text-white text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Edit Kategori</h2>
                <p class="text-gray-500 text-sm">Perbarui kategori kegiatan umum</p>
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

        <form action="{{ route('admin.kategori-kegiatan-umum.update', $kategoriKegiatanUmum->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategoriKegiatanUmum->nama_kategori) }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500" required>
                    <p class="text-xs text-gray-500 mt-1">Maksimal 100 karakter</p>
                </div>
            </div>

            <div class="flex gap-3 pt-6 mt-6 border-t">
                <button type="submit" class="flex-1 bg-gradient-to-r from-yellow-500 to-orange-600 text-white px-6 py-3 rounded-lg font-semibold">
                    <i class="fas fa-save mr-2"></i>Update
                </button>
                <a href="{{ route('admin.kategori-kegiatan-umum.index') }}" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
