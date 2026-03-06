<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jenis Rekognisi - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.jenis-rekognisi.index') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                        <i class="fas fa-arrow-left"></i>
                        <span class="font-semibold">Kembali</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="font-medium">{{ auth()->guard('admin')->user()->name }}</p>
                        <p class="text-xs text-blue-200">Administrator</p>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="hidden md:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-plus-circle text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Tambah Jenis Rekognisi</h2>
                    <p class="text-gray-500 text-sm">Tambahkan jenis rekognisi baru ke sistem</p>
                </div>
            </div>

            @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                    <div>
                        <h4 class="font-semibold text-red-800 mb-2">Terdapat {{ count($errors) }} kesalahan:</h4>
                        <ul class="list-disc list-inside space-y-1 text-red-700 text-sm">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <form action="{{ route('admin.jenis-rekognisi.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="nama" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-certificate mr-2 text-emerald-600"></i>
                        Nama Jenis Rekognisi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('nama') border-red-500 @enderror"
                           placeholder="Contoh: Prestasi Akademik, Prestasi Non-Akademik" required>
                    @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 pt-6 border-t">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-6 py-3 rounded-lg hover:from-emerald-600 hover:to-teal-700 transition duration-200 font-semibold shadow-md">
                        <i class="fas fa-save mr-2"></i>Simpan Jenis Rekognisi
                    </button>
                    <a href="{{ route('admin.jenis-rekognisi.index') }}" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition duration-200 font-semibold text-center">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t mt-auto py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Sistem Kemahasiswaan. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
