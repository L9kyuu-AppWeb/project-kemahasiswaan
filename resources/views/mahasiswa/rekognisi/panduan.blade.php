@extends('mahasiswa.layouts.app')

@section('title', 'Panduan Rekognisi')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-500 to-cyan-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold"><i class="fas fa-book mr-2"></i>Panduan Rekognisi</h2>
                <p class="text-blue-100 text-sm">Informasi jenis rekognisi yang dapat diajukan</p>
            </div>
            <a href="{{ route('mahasiswa.rekognisi.create') }}" class="bg-white text-blue-600 hover:bg-blue-50 px-6 py-3 rounded-lg transition font-semibold flex items-center gap-2">
                <i class="fas fa-plus-circle"></i>Ajukan Rekognisi
            </a>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Karya Teknologi/Seni -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-start gap-3 mb-3">
                <div class="bg-blue-100 text-blue-600 p-3 rounded-lg">
                    <i class="fas fa-microchip text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Karya Teknologi & Seni Budaya</h3>
                    <p class="text-sm text-gray-600">Teknologi tepat guna, seni budaya, produk kreatif</p>
                </div>
            </div>
            <p class="text-gray-700 text-sm mb-3">
                Produk diperoleh dari aktivitas mahasiswa non-kompetisi dalam bentuk karya/kreasi yang digunakan oleh dunia usaha, industri dan/atau masyarakat atau bukan produk luaran dari sebuah proses kompetisi dalam berbagai bidang dan/atau level.
            </p>
            <div class="bg-blue-50 rounded-lg p-3 text-xs text-blue-700">
                <i class="fas fa-info-circle mr-1"></i>
                <strong>Contoh:</strong> Aplikasi mobile, produk kerajinan, desain grafis, pertunjukan seni
            </div>
        </div>

        <!-- Sertifikat Kompetensi -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-start gap-3 mb-3">
                <div class="bg-green-100 text-green-600 p-3 rounded-lg">
                    <i class="fas fa-certificate text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Sertifikat Kompetensi</h3>
                    <p class="text-sm text-gray-600">Nasional dan/atau Internasional</p>
                </div>
            </div>
            <p class="text-gray-700 text-sm mb-3">
                Sertifikat yang menunjukkan kompetensi mahasiswa yang diakui secara nasional atau internasional.
            </p>
            <div class="bg-green-50 rounded-lg p-3 text-xs text-green-700">
                <i class="fas fa-info-circle mr-1"></i>
                <strong>Contoh:</strong> Sertifikat BNSP, Microsoft Certification, Cisco Certification, TOEFL, IELTS
            </div>
        </div>

        <!-- Juri/Pelatih/Wasit -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-start gap-3 mb-3">
                <div class="bg-purple-100 text-purple-600 p-3 rounded-lg">
                    <i class="fas fa-gavel text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Juri/Pelatih/Wasit</h3>
                    <p class="text-sm text-gray-600">Level Kabupaten/Kota/Provinsi/Nasional/Internasional</p>
                </div>
            </div>
            <p class="text-gray-700 text-sm mb-3">
                Berperan sebagai juri, pelatih, atau wasit dalam kompetisi di berbagai level.
            </p>
            <div class="bg-purple-50 rounded-lg p-3 text-xs text-purple-700">
                <i class="fas fa-info-circle mr-1"></i>
                <strong>Contoh:</strong> Juri lomba debat, pelatih tim kompetisi, wasit pertandingan olahraga
            </div>
        </div>

        <!-- Keynote Speaker -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-orange-500">
            <div class="flex items-start gap-3 mb-3">
                <div class="bg-orange-100 text-orange-600 p-3 rounded-lg">
                    <i class="fas fa-microphone-alt text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Keynote Speaker</h3>
                    <p class="text-sm text-gray-600">Conference/Seminar/Workshop Nasional/Internasional</p>
                </div>
            </div>
            <p class="text-gray-700 text-sm mb-3">
                Narasumber utama pada kegiatan seminar, konferensi, workshop, atau pelatihan di tingkat provinsi/nasional/internasional.
            </p>
            <div class="bg-orange-50 rounded-lg p-3 text-xs text-orange-700">
                <i class="fas fa-info-circle mr-1"></i>
                <strong>Contoh:</strong> Keynote speaker konferensi internasional, narasumber webinar nasional
            </div>
        </div>

        <!-- Karya Cipta Lagu/Seni Tari -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-pink-500">
            <div class="flex items-start gap-3 mb-3">
                <div class="bg-pink-100 text-pink-600 p-3 rounded-lg">
                    <i class="fas fa-music text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Karya Cipta Lagu & Seni Tari</h3>
                    <p class="text-sm text-gray-600">Telah dipublikasikan dan mendapatkan HKI</p>
                </div>
            </div>
            <p class="text-gray-700 text-sm mb-3">
                Karya cipta lagu dan seni tari yang telah dipublikasikan dan mendapatkan sertifikat hak kekayaan intelektual.
            </p>
            <div class="bg-pink-50 rounded-lg p-3 text-xs text-pink-700">
                <i class="fas fa-info-circle mr-1"></i>
                <strong>Contoh:</strong> Lagu yang dirilis di platform digital, tari tradisional dengan HKI
            </div>
        </div>

        <!-- Peserta Pameran Seni -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-indigo-500">
            <div class="flex items-start gap-3 mb-3">
                <div class="bg-indigo-100 text-indigo-600 p-3 rounded-lg">
                    <i class="fas fa-palette text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Peserta Pameran Karya Seni</h3>
                    <p class="text-sm text-gray-600">Lukisan, poster, kriya, produk seni</p>
                </div>
            </div>
            <p class="text-gray-700 text-sm mb-3">
                Karya seni yang dipamerkan adalah karya original berupa lukisan, poster, kriya, dan produk karya seni lain.
            </p>
            <div class="bg-indigo-50 rounded-lg p-3 text-xs text-indigo-700">
                <i class="fas fa-info-circle mr-1"></i>
                <strong>Contoh:</strong> Pameran lukisan, pameran fotografi, pameran kriya
            </div>
        </div>

        <!-- Paten -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-start gap-3 mb-3">
                <div class="bg-yellow-100 text-yellow-600 p-3 rounded-lg">
                    <i class="fas fa-file-contract text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Paten/Paten Sederhana</h3>
                    <p class="text-sm text-gray-600">Sebagai penulis pertama/pemilik</p>
                </div>
            </div>
            <p class="text-gray-700 text-sm mb-3">
                Paten atau paten sederhana yang dimiliki mahasiswa sebagai penulis pertama atau pemilik.
            </p>
            <div class="bg-yellow-50 rounded-lg p-3 text-xs text-yellow-700">
                <i class="fas fa-info-circle mr-1"></i>
                <strong>Contoh:</strong> Paten teknologi, paten sederhana produk inovasi
            </div>
        </div>

        <!-- Penulis Buku -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500">
            <div class="flex items-start gap-3 mb-3">
                <div class="bg-red-100 text-red-600 p-3 rounded-lg">
                    <i class="fas fa-book text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Penulis Buku</h3>
                    <p class="text-sm text-gray-600">ISBN dan dipublikasikan online</p>
                </div>
            </div>
            <p class="text-gray-700 text-sm mb-3">
                Buku yang ditulis oleh mahasiswa sebagai nama pertama dan telah terdaftar atau memiliki ISBN dan telah dipublikasikan/dapat diakses/dibeli secara online.
            </p>
            <div class="bg-red-50 rounded-lg p-3 text-xs text-red-700">
                <i class="fas fa-info-circle mr-1"></i>
                <strong>Contoh:</strong> Buku ajar, novel, buku referensi dengan ISBN
            </div>
        </div>

        <!-- Publikasi Artikel Ilmiah -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-teal-500">
            <div class="flex items-start gap-3 mb-3">
                <div class="bg-teal-100 text-teal-600 p-3 rounded-lg">
                    <i class="fas fa-newspaper text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Publikasi Artikel Ilmiah</h3>
                    <p class="text-sm text-gray-600">Jurnal Sinta 3+ / Scopus Q4+</p>
                </div>
            </div>
            <p class="text-gray-700 text-sm mb-3">
                Publikasi karya ilmiah mahasiswa yang diterbitkan di jurnal terakreditasi nasional minimal Sinta 3 dan/atau jurnal internasional bereputasi minimal Scopus Q4 sebagai penulis pertama.
            </p>
            <div class="bg-teal-50 rounded-lg p-3 text-xs text-teal-700">
                <i class="fas fa-info-circle mr-1"></i>
                <strong>Contoh:</strong> Artikel jurnal Sinta 2, Scopus Q3, konferensi internasional
            </div>
        </div>

        <!-- Brand Ambassador -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-cyan-500">
            <div class="flex items-start gap-3 mb-3">
                <div class="bg-cyan-100 text-cyan-600 p-3 rounded-lg">
                    <i class="fas fa-star text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Duta (Brand Ambassador)</h3>
                    <p class="text-sm text-gray-600">Meningkatkan reputasi perguruan tinggi</p>
                </div>
            </div>
            <p class="text-gray-700 text-sm mb-3">
                Menjadi duta (brand ambassador) yang dapat meningkatkan reputasi perguruan tinggi, pemerintah daerah, maupun pemerintah nasional.
            </p>
            <div class="bg-cyan-50 rounded-lg p-3 text-xs text-cyan-700">
                <i class="fas fa-info-circle mr-1"></i>
                <strong>Contoh:</strong> Duta mahasiswa, duta pariwisata, duta lingkungan
            </div>
        </div>
    </div>

    <!-- Catatan Penting -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-6">
        <h3 class="font-bold text-yellow-800 mb-3 flex items-center gap-2">
            <i class="fas fa-exclamation-triangle"></i>
            Catatan Penting
        </h3>
        <ul class="space-y-2 text-yellow-700 text-sm">
            <li class="flex items-start gap-2">
                <i class="fas fa-check-circle mt-0.5"></i>
                <span>Semua rekognisi harus disertai dengan <strong>sertifikat/bukti dokumen</strong> yang sah</span>
            </li>
            <li class="flex items-start gap-2">
                <i class="fas fa-check-circle mt-0.5"></i>
                <span>Dokumen harus dapat diverifikasi keasliannya</span>
            </li>
            <li class="flex items-start gap-2">
                <i class="fas fa-check-circle mt-0.5"></i>
                <span>Rekognisi yang diajukan harus <strong>atas nama mahasiswa</strong> yang bersangkutan</span>
            </li>
            <li class="flex items-start gap-2">
                <i class="fas fa-check-circle mt-0.5"></i>
                <span>Untuk karya bersama, mahasiswa harus sebagai <strong>penulis pertama/kontributor utama</strong></span>
            </li>
        </ul>
    </div>

    <!-- Back Button -->
    <div class="flex gap-3">
        <a href="{{ route('mahasiswa.rekognisi.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg transition font-semibold flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>Kembali ke Daftar Rekognisi
        </a>
        <a href="{{ route('mahasiswa.rekognisi.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition font-semibold flex items-center gap-2">
            <i class="fas fa-plus-circle"></i>Ajukan Rekognisi Baru
        </a>
    </div>
</div>
@endsection
