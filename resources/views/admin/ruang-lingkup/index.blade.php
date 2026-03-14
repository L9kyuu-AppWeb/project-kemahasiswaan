@extends('layouts.app')

@section('title', 'Ruang Lingkup')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">
                        <i class="fas fa-globe mr-2"></i>
                        Ruang Lingkup
                    </h2>
                    <p class="text-indigo-100 text-sm">Kelola ruang lingkup kegiatan</p>
                </div>
                <a href="{{ route('admin.master-kegiatan.ruang-lingkup.create') }}" class="bg-white text-indigo-600 hover:bg-indigo-50 px-6 py-3 rounded-lg font-semibold">
                    <i class="fas fa-plus-circle"></i> Tambah
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg p-6">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                        <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Nama Ruang Lingkup</th>
                        <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($ruangLingkups as $index => $ruang)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $ruangLingkups->firstItem() + $index }}</td>
                        <td class="py-3 px-4 font-medium">{{ $ruang->nama }}</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.master-kegiatan.ruang-lingkup.edit', $ruang->id) }}" class="bg-yellow-500 text-white px-3 py-1.5 rounded text-xs">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.master-kegiatan.ruang-lingkup.destroy', $ruang->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin?');">
                                @csrf @method('DELETE')
                                <button class="bg-red-500 text-white px-3 py-1.5 rounded text-xs">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-3"></i>
                            <p>Belum ada data.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @if($ruangLingkups->hasPages())
                <div class="mt-4">{{ $ruangLingkups->links() }}</div>
            @endif
        </div>
    </div>
@endsection
