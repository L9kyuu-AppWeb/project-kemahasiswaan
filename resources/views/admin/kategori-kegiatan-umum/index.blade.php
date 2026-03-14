@extends('layouts.app')

@section('title', 'Kategori Kegiatan Umum')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold"><i class="fas fa-folder mr-2"></i>Kategori Kegiatan Umum</h2>
                <p class="text-purple-100 text-sm">Kelola referensi kategori kegiatan</p>
            </div>
            <a href="{{ route('admin.kategori-kegiatan-umum.create') }}" class="bg-white text-purple-600 hover:bg-purple-50 px-6 py-3 rounded-lg transition font-semibold flex items-center gap-2">
                <i class="fas fa-plus-circle"></i>Tambah Kategori
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
        <i class="fas fa-check-circle"></i>{{ session('success') }}
    </div>
    @endif

    <!-- Search & Filter -->
    <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
        <form action="{{ route('admin.kategori-kegiatan-umum.index') }}" method="GET" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>
            <button type="submit" class="bg-purple-500 text-white px-6 py-2 rounded-lg hover:bg-purple-600 transition">
                <i class="fas fa-search"></i>
            </button>
            <a href="{{ route('admin.kategori-kegiatan-umum.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-redo"></i>
            </a>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gradient-to-r from-purple-50 to-indigo-50">
                <tr>
                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Nama Kategori</th>
                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($kategoriList as $index => $kategori)
                <tr class="hover:bg-purple-50 transition">
                    <td class="py-4 px-6 text-gray-700">{{ $kategoriList->firstItem() + $index }}</td>
                    <td class="py-4 px-6">
                        <span class="font-semibold text-gray-800">{{ $kategori->nama_kategori }}</span>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.kategori-kegiatan-umum.show', $kategori->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs transition">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <a href="{{ route('admin.kategori-kegiatan-umum.edit', $kategori->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs transition">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.kategori-kegiatan-umum.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-8 px-4 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                        <p>Belum ada kategori kegiatan umum.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($kategoriList->hasPages())
    <div class="mt-4">{{ $kategoriList->links() }}</div>
    @endif
</div>
@endsection
