@extends('layouts.app')

@section('title', 'Kegiatan Umum')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold"><i class="fas fa-folder-open mr-2"></i>Kegiatan Umum</h2>
                <p class="text-purple-100 text-sm">Verifikasi kegiatan umum mahasiswa</p>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
        <i class="fas fa-check-circle"></i>{{ session('success') }}
    </div>
    @endif

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
        <form action="{{ route('admin.kegiatan-umum.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="kategori" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $kategori)
                    <option value="{{ $kategori->nama_kategori }}" {{ request('kategori') == $kategori->nama_kategori ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600 transition">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.kegiatan-umum.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gradient-to-r from-purple-50 to-indigo-50">
                <tr>
                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Mahasiswa</th>
                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Kegiatan</th>
                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Kategori</th>
                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($kegiatans as $index => $kegiatan)
                <tr class="hover:bg-purple-50 transition">
                    <td class="py-4 px-6 text-gray-700">{{ $kegiatans->firstItem() + $index }}</td>
                    <td class="py-4 px-6">
                        <div class="font-semibold text-gray-800">{{ $kegiatan->mahasiswa->nama ?? '-' }}</div>
                        <div class="text-xs text-gray-500">{{ $kegiatan->mahasiswa->nim ?? '-' }}</div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="font-semibold text-gray-800">{{ $kegiatan->nama_kompetisi }}</div>
                        <div class="text-xs text-gray-500">{{ $kegiatan->penyelenggara }}</div>
                    </td>
                    <td class="py-4 px-6">
                        <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs font-medium">{{ $kegiatan->kategori }}</span>
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
                            <a href="{{ route('admin.kegiatan-umum.show', $kegiatan->id) }}" class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded text-xs transition">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            @if($kegiatan->status === 'pending')
                            <form action="{{ route('admin.kegiatan-umum.approve', $kegiatan->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs transition">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('admin.kegiatan-umum.destroy', $kegiatan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
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
                    <td colspan="6" class="py-8 px-4 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                        <p>Belum ada kegiatan umum.</p>
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
