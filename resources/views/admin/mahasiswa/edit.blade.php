@extends('layouts.app')

@section('title', 'Edit Mahasiswa')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-8">
        <!-- Header Card -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-edit text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Edit Mahasiswa</h2>
                    <p class="text-gray-500 text-sm">Perbarui informasi mahasiswa</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
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

            <form action="{{ route('admin.mahasiswa.update', $mahasiswa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nim" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-id-card mr-2 text-green-600"></i>
                            NIM
                        </label>
                        <input type="text" name="nim" id="nim" value="{{ old('nim', $mahasiswa->nim) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('nim') border-red-500 @enderror"
                               required>
                        @error('nim')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tahun_masuk" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-calendar mr-2 text-green-600"></i>
                            Tahun Masuk
                        </label>
                        <input type="text" name="tahun_masuk" id="tahun_masuk" value="{{ old('tahun_masuk', $mahasiswa->tahun_masuk) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('tahun_masuk') border-red-500 @enderror"
                               required>
                        @error('tahun_masuk')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label for="program_studi_id" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-university mr-2 text-green-600"></i>
                        Program Studi <span class="text-gray-400 font-normal">(Opsional)</span>
                    </label>
                    <select name="program_studi_id" id="program_studi_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('program_studi_id') border-red-500 @enderror">
                        <option value="">-- Pilih Program Studi --</option>
                        @foreach($programStudiList as $prodi)
                            <option value="{{ $prodi->id }}" {{ old('program_studi_id', $mahasiswa->program_studi_id) == $prodi->id ? 'selected' : '' }}>
                                {{ $prodi->nama }} ({{ $prodi->singkatan ?? $prodi->kode }})
                            </option>
                        @endforeach
                    </select>
                    @error('program_studi_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-user mr-2 text-green-600"></i>
                        Nama Lengkap
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $mahasiswa->name) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-envelope mr-2 text-green-600"></i>
                        Email
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $mahasiswa->email) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('email') border-red-500 @enderror"
                           required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-lock mr-2 text-yellow-600"></i>
                        Password Baru <span class="text-gray-400 font-normal">(Opsional)</span>
                    </label>
                    <input type="password" name="password" id="password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('password') border-red-500 @enderror"
                           placeholder="Kosongkan jika tidak ingin mengubah">
                    <p class="text-gray-500 text-xs mt-1"><i class="fas fa-info-circle mr-1"></i>Kosongkan jika tidak ingin mengubah password</p>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 pt-6 mt-6 border-t">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-yellow-500 to-orange-600 text-white px-6 py-3 rounded-lg hover:from-yellow-600 hover:to-orange-700 transition duration-200 font-semibold shadow-md">
                        <i class="fas fa-save mr-2"></i>
                        Update Mahasiswa
                    </button>
                    <a href="{{ route('admin.mahasiswa.index') }}" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition duration-200 font-semibold text-center">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
