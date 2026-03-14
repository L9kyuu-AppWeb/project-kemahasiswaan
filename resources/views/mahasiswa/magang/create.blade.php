@extends('mahasiswa.layouts.app')

@section('title', 'Tambah Magang')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-plus-circle text-white text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Tambah Magang</h2>
                <p class="text-gray-500 text-sm">Tambahkan data magang Anda</p>
            </div>
        </div>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
                <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                <div>
                    <h4 class="font-semibold text-red-800 mb-2">Terdapat {{ count($errors) }} kesalahan:</h4>
                    <ul class="list-disc list-inside space-y-1 text-red-700 text-sm">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('mahasiswa.magang.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">
                        <i class="fas fa-graduation-cap text-emerald-600 mr-2"></i>Informasi Magang
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Tahun Ajar <span class="text-red-500">*</span></label>
                            <select name="tahun_ajar_id" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-emerald-500" required>
                                <option value="">Pilih Tahun Ajar</option>
                                @foreach($tahunAjarList as $ta)
                                <option value="{{ $ta->id }}" {{ old('tahun_ajar_id') == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->tahun_mulai }}/{{ $ta->tahun_berakhir }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Semester <span class="text-red-500">*</span></label>
                            <select name="semester" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-emerald-500" required>
                                <option value="">Pilih Semester</option>
                                @for($i = 1; $i <= 14; $i++)
                                <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2">Nama Perusahaan <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-emerald-500" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2">Lokasi Perusahaan <span class="text-red-500">*</span></label>
                            <input type="text" name="lokasi_perusahaan" value="{{ old('lokasi_perusahaan') }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-emerald-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Tanggal Mulai <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-emerald-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Tanggal Selesai <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-emerald-500" required>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">
                        <i class="fas fa-users text-emerald-600 mr-2"></i>Pembimbing Lapangan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Nama Pembimbing</label>
                            <input type="text" name="pembimbing_lapangan" value="{{ old('pembimbing_lapangan') }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">No. Telp Pembimbing</label>
                            <input type="text" name="no_telp_pembimbing" value="{{ old('no_telp_pembimbing') }}" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">
                        <i class="fas fa-comment-alt text-emerald-600 mr-2"></i>Catatan
                    </h3>
                    <div>
                        <textarea name="catatan" rows="4" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-emerald-500" placeholder="Catatan tambahan (opsional)">{{ old('catatan') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-6 mt-6 border-t">
                <button type="submit" class="flex-1 bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-6 py-3 rounded-lg font-semibold shadow-md">
                    <i class="fas fa-save mr-2"></i>Simpan Magang
                </button>
                <a href="{{ route('mahasiswa.dashboard') }}" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold text-center">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
