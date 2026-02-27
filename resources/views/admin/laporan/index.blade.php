<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Beasiswa - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                        <i class="fas fa-arrow-left"></i>
                        <span class="font-semibold">Dashboard</span>
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

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold mb-1">
                        <i class="fas fa-file-alt mr-2"></i>
                        Laporan Beasiswa Mahasiswa
                    </h2>
                    <p class="text-purple-100 text-sm">Kelola dan verifikasi laporan beasiswa</p>
                </div>
                <div class="flex gap-3">
                    <button onclick="downloadSelected()" id="downloadBtn"
                            class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition duration-200 font-semibold flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                        <i class="fas fa-file-pdf"></i>
                        Download PDF (<span id="selectedCount">0</span>)
                    </button>
                    <button onclick="selectAll()" id="selectAllBtn"
                            class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition duration-200 font-semibold flex items-center gap-2">
                        <i class="fas fa-check-square"></i>
                        Pilih Semua
                    </button>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <form method="GET" action="{{ route('admin.laporan.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label for="status" class="block text-gray-700 font-medium mb-2 text-sm">Status</label>
                        <select name="status" id="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Submitted</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div>
                        <label for="beasiswa_tipe_id" class="block text-gray-700 font-medium mb-2 text-sm">Jenis Beasiswa</label>
                        <select name="beasiswa_tipe_id" id="beasiswa_tipe_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                onchange="this.form.submit()">
                            <option value="">Semua Jenis</option>
                            @foreach($beasiswaTipeList as $tipe)
                                <option value="{{ $tipe->id }}" {{ request('beasiswa_tipe_id') == $tipe->id ? 'selected' : '' }}>
                                    {{ $tipe->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="tahun_ajar_id" class="block text-gray-700 font-medium mb-2 text-sm">Tahun Ajar</label>
                        <select name="tahun_ajar_id" id="tahun_ajar_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                onchange="this.form.submit()">
                            <option value="">Semua Tahun Ajar</option>
                            @foreach($tahunAjarList as $ta)
                                <option value="{{ $ta->id }}" {{ request('tahun_ajar_id') == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->nama ?? $ta->tahun_mulai . '/' . $ta->tahun_akhir }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="search" class="block text-gray-700 font-medium mb-2 text-sm">Cari Mahasiswa</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="NIM / Nama"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition duration-200 font-medium flex items-center justify-center gap-2">
                            <i class="fas fa-search"></i>
                            Filter
                        </button>
                        @if(request('status') || request('beasiswa_tipe_id') || request('tahun_ajar_id') || request('search'))
                            <a href="{{ route('admin.laporan.index') }}"
                               class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition duration-200 font-medium">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Content Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <form id="downloadForm" action="{{ route('admin.laporan.download-multiple-pdf') }}" method="POST">
                @csrf
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gradient-to-r from-purple-50 to-indigo-50">
                            <tr>
                                <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <input type="checkbox" id="headerCheckbox" onchange="toggleAllCheckboxes()" class="w-4 h-4">
                                </th>
                                <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                                <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Mahasiswa</th>
                                <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Beasiswa</th>
                                <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tahun Ajar</th>
                                <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Semester</th>
                                <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Submit</th>
                                <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($laporans as $index => $laporan)
                                <tr class="hover:bg-purple-50 transition duration-150">
                                    <td class="py-4 px-6">
                                        <input type="checkbox" name="laporan_ids[]" value="{{ $laporan->id }}" 
                                               onchange="updateSelectedCount()" class="laporan-checkbox w-4 h-4">
                                    </td>
                                    <td class="py-4 px-6 text-gray-700">{{ $laporans->firstItem() + $index }}</td>
                                    <td class="py-4 px-6">
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $laporan->mahasiswa->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $laporan->mahasiswa->nim }} - {{ $laporan->mahasiswa->programStudi->nama ?? '-' }}</p>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-xs font-medium">
                                            {{ $laporan->beasiswaTipe->nama }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-gray-600 text-sm">
                                        {{ $laporan->tahunAjar->nama ?? $laporan->tahunAjar->tahun_mulai . '/' . $laporan->tahunAjar->tahun_akhir }}
                                    </td>
                                    <td class="py-4 px-6 text-gray-600 text-sm">
                                        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-medium">
                                            Semester {{ $laporan->semester }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($laporan->status === 'approved')
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                                <i class="fas fa-check-circle mr-1"></i> Approved
                                            </span>
                                        @elseif($laporan->status === 'rejected')
                                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                                <i class="fas fa-times-circle mr-1"></i> Rejected
                                            </span>
                                        @elseif($laporan->status === 'submitted')
                                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                                <i class="fas fa-clock mr-1"></i> Submitted
                                            </span>
                                        @else
                                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">
                                                <i class="fas fa-file mr-1"></i> Draft
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-gray-600 text-sm">
                                        {{ $laporan->submitted_at ? $laporan->submitted_at->format('d M Y, H:i') : '-' }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.laporan.show', $laporan->id) }}"
                                               class="bg-purple-100 text-purple-700 hover:bg-purple-200 px-3 py-1.5 rounded-lg transition duration-200 text-sm font-medium flex items-center gap-1 inline-flex">
                                                <i class="fas fa-eye"></i>
                                                Detail
                                            </a>
                                            <a href="{{ route('admin.laporan.download-pdf', $laporan->id) }}"
                                               class="bg-indigo-100 text-indigo-700 hover:bg-indigo-200 px-3 py-1.5 rounded-lg transition duration-200 text-sm font-medium flex items-center gap-1 inline-flex">
                                                <i class="fas fa-file-pdf"></i>
                                                PDF
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="py-8 px-6 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                                        <p>Belum ada laporan beasiswa.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($laporans->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t">
                        {{ $laporans->links() }}
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Sistem Kemahasiswaan. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function toggleAllCheckboxes() {
            const headerCheckbox = document.getElementById('headerCheckbox');
            const checkboxes = document.querySelectorAll('.laporan-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = headerCheckbox.checked;
            });
            updateSelectedCount();
        }

        function updateSelectedCount() {
            const checkboxes = document.querySelectorAll('.laporan-checkbox:checked');
            const count = checkboxes.length;
            document.getElementById('selectedCount').textContent = count;
            
            const downloadBtn = document.getElementById('downloadBtn');
            if (count > 0) {
                downloadBtn.disabled = false;
            } else {
                downloadBtn.disabled = true;
            }

            // Update header checkbox state
            const headerCheckbox = document.getElementById('headerCheckbox');
            const allCheckboxes = document.querySelectorAll('.laporan-checkbox');
            headerCheckbox.checked = count === allCheckboxes.length && count > 0;
        }

        function selectAll() {
            const checkboxes = document.querySelectorAll('.laporan-checkbox');
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
            });
            updateSelectedCount();
        }

        function downloadSelected() {
            const checkboxes = document.querySelectorAll('.laporan-checkbox:checked');
            if (checkboxes.length === 0) {
                alert('Pilih minimal 1 laporan untuk didownload.');
                return;
            }
            
            if (confirm(`Download ${checkboxes.length} laporan yang dipilih dalam format PDF?`)) {
                document.getElementById('downloadForm').submit();
            }
        }
    </script>
</body>
</html>
