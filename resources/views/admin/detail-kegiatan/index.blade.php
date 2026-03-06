<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Kegiatan - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4"><div class="flex justify-between items-center">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2"><i class="fas fa-arrow-left"></i><span>Dashboard</span></a>
            <div class="flex items-center space-x-4"><div class="text-right hidden md:block"><p class="font-medium">{{ auth()->guard('admin')->user()->name }}</p><p class="text-xs text-blue-200">Administrator</p></div>
            <form action="{{ route('admin.logout') }}" method="POST">@csrf<button class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg"><i class="fas fa-sign-out-alt"></i></button></form></div>
        </div></div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <div class="flex justify-between items-center">
                <div><h2 class="text-2xl font-bold"><i class="fas fa-tasks mr-2"></i>Detail Kegiatan</h2><p class="text-indigo-100 text-sm">Kelola detail kegiatan</p></div>
                <a href="{{ route('admin.master-kegiatan.detail.create') }}" class="bg-white text-indigo-600 hover:bg-indigo-50 px-6 py-3 rounded-lg font-semibold"><i class="fas fa-plus-circle"></i> Tambah</a>
            </div>
        </div>
        @if(session('success'))<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>@endif

        <div class="bg-white rounded-xl shadow-lg p-6">
            <table class="min-w-full">
                <thead class="bg-gray-50"><tr><th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">No</th><th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Jenis Kegiatan</th><th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Nama Detail</th><th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th></tr></thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($detailKegiatans as $index => $detail)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $detailKegiatans->firstItem() + $index }}</td>
                        <td class="py-3 px-4">{{ $detail->jenisKegiatan->nama }}</td>
                        <td class="py-3 px-4 font-medium">{{ $detail->nama }}</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.master-kegiatan.detail.edit', $detail->id) }}" class="bg-yellow-500 text-white px-3 py-1.5 rounded text-xs"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('admin.master-kegiatan.detail.destroy', $detail->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin?');">@csrf @method('DELETE')<button class="bg-red-500 text-white px-3 py-1.5 rounded text-xs"><i class="fas fa-trash"></i> Hapus</button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="py-8 text-center text-gray-500"><i class="fas fa-inbox text-4xl mb-3"></i><p>Belum ada data.</p></td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($detailKegiatans->hasPages())<div class="mt-4">{{ $detailKegiatans->links() }}</div>@endif
        </div>
    </div>
</body>
</html>
