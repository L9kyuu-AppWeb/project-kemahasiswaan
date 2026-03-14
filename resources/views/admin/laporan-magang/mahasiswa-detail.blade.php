@extends('layouts.app')

@section('title', 'Laporan Magang - ' . $mahasiswa->name)

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header Mahasiswa -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-graduate text-3xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold">{{ $mahasiswa->name }}</h2>
                    <p class="text-blue-100">{{ $mahasiswa->nim }} • {{ $mahasiswa->programStudi->nama ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-gray-400">
                <p class="text-gray-500 text-sm">Total Laporan</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalLaporan }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-gray-400">
                <p class="text-gray-500 text-sm">Draft</p>
                <p class="text-2xl font-bold text-gray-700">{{ $statusSummary['draft'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-yellow-400">
                <p class="text-gray-500 text-sm">Submitted</p>
                <p class="text-2xl font-bold text-yellow-700">{{ $statusSummary['submitted'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-green-400">
                <p class="text-gray-500 text-sm">Approved</p>
                <p class="text-2xl font-bold text-green-700">{{ $statusSummary['approved'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-red-400">
                <p class="text-gray-500 text-sm">Rejected</p>
                <p class="text-2xl font-bold text-red-700">{{ $statusSummary['rejected'] }}</p>
            </div>
        </div>

        <!-- All Reports -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 border-b">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-list text-orange-600"></i>
                    Semua Laporan Magang ({{ $totalLaporan }})
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Judul Laporan</th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Tahun Ajar</th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Perusahaan</th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Log</th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($laporans as $laporan)
                            <tr class="hover:bg-orange-50 transition duration-150">
                                <td class="py-4 px-6">
                                    <p class="font-semibold text-gray-800">{{ Str::limit($laporan->judul_laporan, 50) }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold">
                                        {{ $laporan->tahunAjar->nama }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-sm text-gray-600">{{ Str::limit($laporan->mahasiswaMagang->nama_perusahaan, 25) }}</p>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-600">
                                    {{ $laporan->tanggal_kegiatan->format('d M Y') }}
                                </td>
                                <td class="py-4 px-6">
                                    <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs font-semibold">
                                        {{ $laporan->logKegiatans->count() }} Log
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    @if($laporan->status === 'draft')
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-file mr-1"></i> Draft
                                        </span>
                                    @elseif($laporan->status === 'submitted')
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-clock mr-1"></i> Submitted
                                        </span>
                                    @elseif($laporan->status === 'approved')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-check-circle mr-1"></i> Approved
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-times-circle mr-1"></i> Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.laporan-magang.show', $laporan->id) }}"
                                           class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1.5 rounded-lg transition duration-200 text-sm font-medium flex items-center gap-1">
                                            <i class="fas fa-eye"></i>
                                            Detail
                                        </a>
                                        <a href="{{ route('admin.laporan-magang.download-pdf', $laporan->id) }}"
                                           class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded-lg transition duration-200 text-sm font-medium flex items-center gap-1">
                                            <i class="fas fa-file-pdf"></i>
                                            PDF
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 px-6 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                                    <p>Belum ada laporan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
