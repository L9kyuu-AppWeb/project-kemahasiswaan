<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikasi Saya - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4"><div class="flex justify-between items-center">
            <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-2 hover:opacity-80 transition"><i class="fas fa-arrow-left"></i><span class="font-semibold">Dashboard</span></a>
            <div class="flex items-center space-x-4"><div class="text-right hidden md:block"><p class="font-medium">{{ auth()->guard('mahasiswa')->user()->name }}</p><p class="text-xs text-blue-200">{{ auth()->guard('mahasiswa')->user()->nim }}</p></div>
            <form action="{{ route('mahasiswa.logout') }}" method="POST" class="inline">@csrf<button type="submit" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition"><i class="fas fa-sign-out-alt"></i></button></form></div>
        </div></div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <div class="flex justify-between items-center">
                <div><h2 class="text-2xl font-bold"><i class="fas fa-certificate mr-2"></i>Sertifikasi Saya</h2><p class="text-indigo-100 text-sm">Kelola data sertifikasi Anda</p></div>
                <a href="{{ route('mahasiswa.sertifikasi.create') }}" class="bg-white text-indigo-600 hover:bg-indigo-50 px-6 py-3 rounded-lg transition font-semibold flex items-center gap-2"><i class="fas fa-plus-circle"></i>Tambah Sertifikasi</a>
            </div>
        </div>

        @if(session('error'))<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2"><i class="fas fa-exclamation-circle"></i>{{ session('error') }}</div>@endif
        @if(session('success'))<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2"><i class="fas fa-check-circle"></i>{{ session('success') }}</div>@endif

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4"><i class="fas fa-list mr-2 text-indigo-600"></i>Daftar Sertifikasi Saya</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Sertifikasi</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Level</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($sertifikasis as $index => $s)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4 text-gray-700">{{ $sertifikasis->firstItem() + $index }}</td>
                            <td class="py-3 px-4"><div class="font-semibold text-gray-800">{{ $s->nama_sertifikasi }}</div><div class="text-xs text-gray-500">{{ $s->nama_penyelenggara }}</div></td>
                            <td class="py-3 px-4"><span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium">{{ $s->level }}</span></td>
                            <td class="py-3 px-4">
                                @if($s->status === 'pending')<span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium"><i class="fas fa-clock mr-1"></i>Pending</span>
                                @elseif($s->status === 'approved')<span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium"><i class="fas fa-check-circle mr-1"></i>Disetujui</span>
                                @else<span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium"><i class="fas fa-times-circle mr-1"></i>Ditolak</span>@endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('mahasiswa.sertifikasi.show', $s->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs transition"><i class="fas fa-eye"></i> Detail</a>
                                    @if($s->status === 'pending')
                                    <a href="{{ route('mahasiswa.sertifikasi.edit', $s->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs transition"><i class="fas fa-edit"></i> Edit</a>
                                    <form action="{{ route('mahasiswa.sertifikasi.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">@csrf @method('DELETE')<button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition"><i class="fas fa-trash"></i> Hapus</button></form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="py-8 px-4 text-center text-gray-500"><i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i><p>Belum ada data sertifikasi.</p><a href="{{ route('mahasiswa.sertifikasi.create') }}" class="text-indigo-600 hover:underline mt-2 inline-block">Tambah sertifikasi pertama Anda</a></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($sertifikasis->hasPages())<div class="mt-4">{{ $sertifikasis->links() }}</div>@endif
        </div>
    </div>
</body>
</html>
