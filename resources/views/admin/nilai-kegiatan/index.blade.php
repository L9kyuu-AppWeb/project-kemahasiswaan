@extends('layouts.app')

@section('title', 'Nilai Kegiatan')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">
                        <i class="fas fa-star mr-2"></i>
                        Nilai Kegiatan
                    </h2>
                    <p class="text-indigo-100 text-sm">Kelola nilai/point kegiatan</p>
                </div>
                <a href="{{ route('admin.master-kegiatan.nilai.create') }}" class="bg-white text-indigo-600 hover:bg-indigo-50 px-6 py-3 rounded-lg font-semibold">
                    <i class="fas fa-plus-circle"></i> Tambah
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
            <form action="{{ route('admin.master-kegiatan.nilai.index') }}" method="GET" class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filter Jenis Kegiatan</label>
                    <select name="jenis_id" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="">Semua Jenis</option>
                        @foreach($jenisKegiatans as $jenis)
                            <option value="{{ $jenis->id }}" {{ request('jenis_id') == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-indigo-500 text-white px-6 py-2 rounded-lg">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
                <div class="flex items-end">
                    <a href="{{ route('admin.master-kegiatan.nilai.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg p-6">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                        <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Jenis</th>
                        <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Detail</th>
                        <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Ruang Lingkup</th>
                        <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Nilai</th>
                        <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($nilaiKegiatans as $index => $nilai)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $nilaiKegiatans->firstItem() + $index }}</td>
                        <td class="py-3 px-4">{{ $nilai->jenisKegiatan->nama }}</td>
                        <td class="py-3 px-4">{{ $nilai->detailKegiatan->nama }}</td>
                        <td class="py-3 px-4">
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">
                                {{ $nilai->ruangLingkup->nama }}
                            </span>
                        </td>
                        <td class="py-3 px-4 font-bold text-indigo-600">{{ $nilai->nilai }}</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.master-kegiatan.nilai.edit', $nilai->id) }}" class="bg-yellow-500 text-white px-3 py-1.5 rounded text-xs">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.master-kegiatan.nilai.destroy', $nilai->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin?');">
                                @csrf @method('DELETE')
                                <button class="bg-red-500 text-white px-3 py-1.5 rounded text-xs">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-3"></i>
                            <p>Belum ada data nilai kegiatan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @if($nilaiKegiatans->hasPages())
                <div class="mt-4">{{ $nilaiKegiatans->links() }}</div>
            @endif
        </div>
    </div>
@endsection
