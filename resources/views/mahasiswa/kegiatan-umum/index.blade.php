@extends('mahasiswa.layouts.app')

@section('title', 'Kegiatan Umum Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold"><i class="fas fa-folder-open mr-2"></i>Kegiatan Umum Saya</h2>
                <p class="text-purple-100 text-sm">Kelola kegiatan umum Anda</p>
            </div>
            <a href="{{ route('mahasiswa.kegiatan-umum.create') }}" class="bg-white text-purple-600 hover:bg-purple-50 px-6 py-3 rounded-lg transition font-semibold flex items-center gap-2">
                <i class="fas fa-plus-circle"></i>Tambah Kegiatan
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
        <i class="fas fa-check-circle"></i>{{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
        <i class="fas fa-exclamation-circle"></i>{{ session('error') }}
    </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gradient-to-r from-purple-50 to-indigo-50">
                <tr>
                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Kegiatan</th>
                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Kategori</th>
                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Nilai</th>
                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($kegiatans as $index => $kegiatan)
                <tr class="hover:bg-purple-50 transition">
                    <td class="py-4 px-6 text-gray-700">{{ $kegiatans->firstItem() + $index }}</td>
                    <td class="py-4 px-6">
                        <div class="font-semibold text-gray-800">{{ $kegiatan->nama_kompetisi }}</div>
                        <div class="text-xs text-gray-500">{{ $kegiatan->penyelenggara }}</div>
                    </td>
                    <td class="py-4 px-6">
                        <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs font-medium">{{ $kegiatan->kategori }}</span>
                    </td>
                    <td class="py-4 px-6">
                        <span class="font-bold text-purple-600">{{ $kegiatan->nilai }}</span>
                    </td>
                    <td class="py-4 px-6">
                        @if($kegiatan->status === 'pending')
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium">
                            <i class="fas fa-clock mr-1"></i>Pending
                        </span>
                        @elseif($kegiatan->status === 'approved')
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">
                            <i class="fas fa-check-circle mr-1"></i>Disetujui
                        </span>
                        @else
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">
                            <i class="fas fa-times-circle mr-1"></i>Ditolak
                        </span>
                        @endif
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex gap-2">
                            <a href="{{ route('mahasiswa.kegiatan-umum.show', $kegiatan->id) }}" class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded text-xs transition">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            @if($kegiatan->status === 'pending')
                            <a href="{{ route('mahasiswa.kegiatan-umum.edit', $kegiatan->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs transition">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('mahasiswa.kegiatan-umum.destroy', $kegiatan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 px-4 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                        <p>Belum ada kegiatan umum.</p>
                        <a href="{{ route('mahasiswa.kegiatan-umum.create') }}" class="text-purple-600 hover:underline mt-2 inline-block">Tambah kegiatan umum pertama Anda</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($kegiatans->hasPages())
    <div class="mt-4">{{ $kegiatans->links() }}</div>
    @endif
</div>
@endsection
