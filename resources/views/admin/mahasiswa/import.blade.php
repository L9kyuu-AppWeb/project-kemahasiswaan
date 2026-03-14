@extends('layouts.app')

@section('title', 'Import Mahasiswa')

@push('styles')
    <style>
        #fileName {
            word-break: break-all;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Header Card -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-file-excel text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Import Mahasiswa dari Excel</h2>
                    <p class="text-gray-500 text-sm">Upload file Excel untuk menambahkan banyak mahasiswa sekaligus</p>
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

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle text-red-500 mt-0.5"></i>
                        <div>
                            <h4 class="font-semibold text-red-800 mb-2">Error</h4>
                            <p class="text-red-700 text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('warning'))
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle text-yellow-500 mt-0.5"></i>
                        <div>
                            <h4 class="font-semibold text-yellow-800 mb-2">Peringatan</h4>
                            <p class="text-yellow-700 text-sm mb-2">{{ session('warning') }}</p>
                            @if(session('failures'))
                                <div class="bg-yellow-100 rounded p-3 mt-2 max-h-48 overflow-y-auto">
                                    <ul class="list-disc list-inside space-y-1 text-yellow-800 text-sm">
                                        @foreach(session('failures') as $failure)
                                            <li>{{ $failure }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                        <div>
                            <h4 class="font-semibold text-green-800 mb-2">Berhasil</h4>
                            <p class="text-green-700 text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold mb-2">Panduan Import:</p>
                        <ul class="list-disc list-inside space-y-1 text-blue-700">
                            <li>Download template Excel terlebih dahulu untuk memastikan format yang benar</li>
                            <li>Kolom <strong>NIM</strong>, <strong>Tahun Masuk</strong>, <strong>Nama</strong>, dan <strong>Email</strong> wajib diisi</li>
                            <li>Kolom <strong>Program Studi</strong> harus sesuai dengan nama atau kode program studi yang ada di sistem</li>
                            <li>Kolom <strong>Password</strong> opsional - jika kosong, password default adalah <code>password123</code></li>
                            <li>File dapat berformat .xlsx, .xls, atau .csv (max 10MB)</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Download Template Button -->
            <div class="mb-6">
                <a href="{{ route('admin.mahasiswa.download-template') }}"
                   class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-200 font-semibold shadow-md">
                    <i class="fas fa-download"></i>
                    Download Template Excel
                </a>
            </div>

            <!-- Upload Form -->
            <form action="{{ route('admin.mahasiswa.import-excel') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-green-500 transition duration-200">
                    <div class="mb-4">
                        <i class="fas fa-file-excel text-6xl text-green-500"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Upload File Excel</h3>
                    <p class="text-gray-500 text-sm mb-4">Pilih file Excel (.xlsx, .xls, .csv)</p>

                    <input type="file" name="file" id="file" accept=".xlsx,.xls,.csv" required
                           class="hidden" onchange="updateFileName()">

                    <label for="file"
                           class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition duration-200 font-semibold cursor-pointer shadow-md">
                        <i class="fas fa-folder-open"></i>
                        Pilih File
                    </label>

                    <p id="fileName" class="mt-4 text-sm text-gray-600 font-medium"></p>
                </div>

                @error('file')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror

                <div class="flex gap-3 pt-6 mt-6 border-t">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 text-white px-6 py-3 rounded-lg hover:from-green-700 hover:to-emerald-700 transition duration-200 font-semibold shadow-md">
                        <i class="fas fa-upload mr-2"></i>
                        Import Data
                    </button>
                    <a href="{{ route('admin.mahasiswa.index') }}" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition duration-200 font-semibold text-center">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Program Studi List -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-university text-green-600"></i>
                Daftar Program Studi Tersedia
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($programStudiList as $prodi)
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $prodi->nama }}</p>
                            <p class="text-sm text-gray-500">Kode: {{ $prodi->kode }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function updateFileName() {
            const input = document.getElementById('file');
            const fileNameDisplay = document.getElementById('fileName');
            if (input.files && input.files[0]) {
                fileNameDisplay.textContent = 'File terpilih: ' + input.files[0].name;
            } else {
                fileNameDisplay.textContent = '';
            }
        }
    </script>
@endpush
