@extends('layouts.app')

@section('title', 'Kelola Sertifikasi')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <h2 class="text-2xl font-bold"><i class="fas fa-certificate mr-2"></i>Kelola Sertifikasi</h2>
            <p class="text-indigo-100 text-sm">Verifikasi dan kelola data sertifikasi mahasiswa</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
            <form action="{{ route('admin.sertifikasi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="">Semua Status</option><option value="pending">Pending</option><option value="approved">Disetujui</option><option value="rejected">Ditolak</option>
                    </select>
                </div>
                <div class="flex items-end"><button type="submit" class="w-full bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600 transition"><i class="fas fa-filter mr-2"></i>Filter</button></div>
                <div class="flex items-end"><a href="{{ route('admin.sertifikasi.index') }}" class="w-full bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition text-center"><i class="fas fa-redo mr-2"></i>Reset</a></div>
            </form>
        </div>

        @if(session('success'))<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2"><i class="fas fa-check-circle"></i>{{ session('success') }}</div>@endif

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4"><i class="fas fa-list mr-2 text-indigo-600"></i>Daftar Sertifikasi</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Mahasiswa</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Sertifikasi</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($sertifikasis as $index => $s)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4 text-gray-700">{{ $sertifikasis->firstItem() + $index }}</td>
                            <td class="py-3 px-4"><div class="font-semibold text-gray-800">{{ $s->nama_mahasiswa }}</div><div class="text-xs text-gray-500">{{ $s->nim }}</div></td>
                            <td class="py-3 px-4"><div class="font-semibold text-gray-800">{{ $s->nama_sertifikasi }}</div><div class="text-xs text-gray-500">{{ $s->nama_penyelenggara }}</div></td>
                            <td class="py-3 px-4">
                                @if($s->status === 'pending')<span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium"><i class="fas fa-clock mr-1"></i>Pending</span>
                                @elseif($s->status === 'approved')<span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium"><i class="fas fa-check-circle mr-1"></i>Disetujui</span>
                                @else<span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium"><i class="fas fa-times-circle mr-1"></i>Ditolak</span>@endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.sertifikasi.show', $s->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs transition"><i class="fas fa-eye"></i> Detail</a>
                                    <a href="{{ route('admin.sertifikasi.edit', $s->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs transition"><i class="fas fa-edit"></i> Edit</a>
                                    <form action="{{ route('admin.sertifikasi.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">@csrf @method('DELETE')<button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition"><i class="fas fa-trash"></i></button></form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="py-8 px-4 text-center text-gray-500"><i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i><p>Belum ada data sertifikasi.</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($sertifikasis->hasPages())<div class="mt-4">{{ $sertifikasis->links() }}</div>@endif
        </div>
    </div>
@endsection
