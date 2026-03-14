@extends('layouts.app')

@section('title', 'Kelola Dosen')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold mb-1">
                        <i class="fas fa-chalkboard-teacher mr-2"></i>
                        Kelola Dosen
                    </h2>
                    <p class="text-blue-100 text-sm">Kelola data dosen dengan mudah</p>
                </div>
                <a href="{{ route('admin.dosen.create') }}"
                   class="bg-white text-blue-600 hover:bg-blue-50 px-6 py-3 rounded-lg transition duration-200 font-semibold flex items-center gap-2 shadow-lg">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Dosen
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Content Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Search Form -->
            <div class="p-4 border-b bg-gray-50">
                <form action="{{ route('admin.dosen.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari nama atau NUPTK..."
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-search"></i>
                    </button>
                    @if(request('search'))
                    <a href="{{ route('admin.dosen.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-times"></i>
                    </a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gradient-to-r from-blue-50 to-purple-50">
                        <tr>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NUPTK</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($dosens as $index => $dosen)
                            <tr class="hover:bg-blue-50 transition duration-150">
                                <td class="py-4 px-6 text-gray-700">{{ $dosens->firstItem() + $index }}</td>
                                <td class="py-4 px-6">
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                                        {{ $dosen->nuptk }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 font-medium text-gray-800">{{ $dosen->nama }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.dosen.edit', $dosen->id) }}"
                                           class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-1.5 rounded-lg transition duration-200 text-sm font-medium flex items-center gap-1">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.dosen.destroy', $dosen->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus dosen ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded-lg transition duration-200 text-sm font-medium flex items-center gap-1">
                                                <i class="fas fa-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 px-6 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                                    <p>Belum ada data dosen.</p>
                                    <a href="{{ route('admin.dosen.create') }}" class="text-blue-600 hover:underline mt-2 inline-block">
                                        Tambah dosen pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($dosens->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t">
                    {{ $dosens->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
