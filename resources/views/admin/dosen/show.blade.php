@extends('layouts.app')

@section('title', 'Detail Dosen')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-8">
        <!-- Header Card -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chalkboard-teacher text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Detail Dosen</h2>
                    <p class="text-gray-500 text-sm">Informasi lengkap dosen</p>
                </div>
            </div>

            <!-- Detail Information -->
            <div class="border-t border-b py-4 my-4">
                <dl class="space-y-3">
                    <div class="flex justify-between items-start">
                        <dt class="text-sm font-medium text-gray-500 w-32">NUPTK</dt>
                        <dd class="text-base text-gray-900 font-mono bg-blue-50 px-3 py-1 rounded-full">{{ $dosen->nuptk }}</dd>
                    </div>
                    <div class="flex justify-between items-start">
                        <dt class="text-sm font-medium text-gray-500 w-32">Nama</dt>
                        <dd class="text-base text-gray-900 font-medium">{{ $dosen->nama }}</dd>
                    </div>
                    <div class="flex justify-between items-start">
                        <dt class="text-sm font-medium text-gray-500 w-32">Dibuat</dt>
                        <dd class="text-base text-gray-900">{{ $dosen->created_at->format('d M Y, H:i') }}</dd>
                    </div>
                    <div class="flex justify-between items-start">
                        <dt class="text-sm font-medium text-gray-500 w-32">Diperbarui</dt>
                        <dd class="text-base text-gray-900">{{ $dosen->updated_at->format('d M Y, H:i') }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 pt-4">
                <a href="{{ route('admin.dosen.edit', $dosen->id) }}"
                   class="flex-1 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white px-6 py-3 rounded-lg hover:from-yellow-600 hover:to-yellow-700 transition duration-200 font-semibold text-center shadow-md">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <form action="{{ route('admin.dosen.destroy', $dosen->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus data dosen ini?');" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition duration-200 font-semibold shadow-md">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus
                    </button>
                </form>
                <a href="{{ route('admin.dosen.index') }}"
                   class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition duration-200 font-semibold text-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
