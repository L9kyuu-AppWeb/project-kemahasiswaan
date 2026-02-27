<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Beasiswa Mahasiswa</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 1.5cm 1cm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #333;
            padding-left: 5px;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 10px;
        }
        
        .header h1 {
            font-size: 16pt;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 3px;
        }
        
        .header h2 {
            font-size: 12pt;
            font-weight: normal;
            color: #666;
        }
        
        .section {
            margin-bottom: 15px;
        }
        
        .section-title {
            font-size: 12pt;
            font-weight: bold;
            color: #1e40af;
            border-bottom: 2px solid #93c5fd;
            padding-bottom: 3px;
            margin-bottom: 10px;
        }
        
        .info-table {
            width: 100%;
            margin-bottom: 10px;
        }
        
        .info-table td {
            padding: 3px 0;
        }
        
        .info-label {
            width: 140px;
            font-weight: bold;
            color: #555;
        }
        
        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 9pt;
            font-weight: bold;
            border: 1px solid;
        }
        
        .status-approved {
            background-color: #dcfce7;
            color: #166534;
            border-color: #86efac;
        }
        
        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
            border-color: #fca5a5;
        }
        
        .status-submitted {
            background-color: #fef3c7;
            color: #92400e;
            border-color: #fcd34d;
        }
        
        .status-draft {
            background-color: #f3f4f6;
            color: #374151;
            border-color: #d1d5db;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 10pt;
        }
        
        table th {
            background-color: #eff6ff;
            padding: 6px 8px;
            text-align: left;
            font-weight: bold;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }
        
        table td {
            padding: 6px 8px;
            border: 1px solid #e5e7eb;
        }
        
        .item-card {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 3px;
            padding: 8px;
            margin-bottom: 8px;
        }
        
        .item-title {
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 5px;
            font-size: 10pt;
        }
        
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 9pt;
            color: #666;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
        
        .summary-header {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .summary-header h3 {
            color: #1e40af;
            font-size: 14pt;
            margin-bottom: 10px;
        }
        
        .summary-grid {
            display: table;
            width: 100%;
        }
        
        .summary-row {
            display: table-row;
        }
        
        .summary-cell {
            display: table-cell;
            padding: 5px 10px;
            width: 25%;
        }
        
        .summary-label {
            font-size: 9pt;
            color: #666;
        }
        
        .summary-value {
            font-size: 11pt;
            font-weight: bold;
            color: #1e40af;
        }
    </style>
</head>
<body>
    <!-- Summary Page -->
    <div class="summary-header">
        <h3>REKAPITULASI LAPORAN BEASISWA</h3>
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-cell">
                    <div class="summary-label">Total Laporan</div>
                    <div class="summary-value">{{ $laporans->count() }}</div>
                </div>
                <div class="summary-cell">
                    <div class="summary-label">Approved</div>
                    <div class="summary-value" style="color: #166534;">{{ $laporans->where('status', 'approved')->count() }}</div>
                </div>
                <div class="summary-cell">
                    <div class="summary-label">Submitted</div>
                    <div class="summary-value" style="color: #92400e;">{{ $laporans->where('status', 'submitted')->count() }}</div>
                </div>
                <div class="summary-cell">
                    <div class="summary-label">Dicetak</div>
                    <div class="summary-value">{{ now()->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Mahasiswa</th>
                <th width="15%">Beasiswa</th>
                <th width="12%">Tahun Ajar</th>
                <th width="8%">Sem</th>
                <th width="10%">SKS</th>
                <th width="10%">IP</th>
                <th width="10%">Status</th>
                <th width="10%">Submit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporans as $index => $laporan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $laporan->mahasiswa->name }}</strong><br>
                        <small>{{ $laporan->mahasiswa->nim }}</small>
                    </td>
                    <td>{{ $laporan->beasiswaTipe->nama }}</td>
                    <td>{{ $laporan->tahunAjar->nama ?? $laporan->tahunAjar->tahun_mulai . '/' . $laporan->tahunAjar->tahun_akhir }}</td>
                    <td>{{ $laporan->semester }}</td>
                    <td>{{ $laporan->laporanAkademik?->sks ?? '-' }}</td>
                    <td>{{ $laporan->laporanAkademik?->indeks_prestasi ? number_format($laporan->laporanAkademik->indeks_prestasi, 2) : '-' }}</td>
                    <td>
                        @if($laporan->status === 'approved')
                            <span class="status-badge status-approved">Approved</span>
                        @elseif($laporan->status === 'rejected')
                            <span class="status-badge status-rejected">Rejected</span>
                        @elseif($laporan->status === 'submitted')
                            <span class="status-badge status-submitted">Submitted</span>
                        @else
                            <span class="status-badge status-draft">Draft</span>
                        @endif
                    </td>
                    <td>{{ $laporan->submitted_at?->format('d/m/Y') ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dicetak pada {{ now()->format('d F Y, H:i') }} WIB - Sistem Kemahasiswaan</p>
    </div>

    @if($laporans->count() > 0)
        <div class="page-break"></div>
    @endif

    <!-- Detail per Laporan -->
    @foreach($laporans as $lapIndex => $laporan)
        <!-- Header per Laporan -->
        <div class="header">
            <h1>LAPORAN BEASISWA MAHASISWA</h1>
            <h2>{{ $laporan->mahasiswa->name }} - {{ $laporan->mahasiswa->nim }}</h2>
        </div>

        <!-- Informasi Umum -->
        <div class="section">
            <div class="section-title">INFORMASI UMUM</div>
            <table class="info-table">
                <tr>
                    <td class="info-label">Nama Mahasiswa</td>
                    <td>: {{ $laporan->mahasiswa->name }}</td>
                    <td class="info-label">NIM</td>
                    <td>: {{ $laporan->mahasiswa->nim }}</td>
                </tr>
                <tr>
                    <td class="info-label">Program Studi</td>
                    <td>: {{ $laporan->mahasiswa->programStudi->nama ?? '-' }}</td>
                    <td class="info-label">Jenis Beasiswa</td>
                    <td>: {{ $laporan->beasiswaTipe->nama }}</td>
                </tr>
                <tr>
                    <td class="info-label">Tahun Ajar</td>
                    <td>: {{ $laporan->tahunAjar->nama ?? $laporan->tahunAjar->tahun_mulai . '/' . $laporan->tahunAjar->tahun_akhir }}</td>
                    <td class="info-label">Semester</td>
                    <td>: Semester {{ $laporan->semester }}</td>
                </tr>
                <tr>
                    <td class="info-label">Status</td>
                    <td>: 
                        @if($laporan->status === 'approved')
                            <span class="status-badge status-approved">APPROVED</span>
                        @elseif($laporan->status === 'rejected')
                            <span class="status-badge status-rejected">REJECTED</span>
                        @elseif($laporan->status === 'submitted')
                            <span class="status-badge status-submitted">SUBMITTED</span>
                        @else
                            <span class="status-badge status-draft">DRAFT</span>
                        @endif
                    </td>
                    <td class="info-label">Tanggal Submit</td>
                    <td>: {{ $laporan->submitted_at ? $laporan->submitted_at->format('d F Y, H:i') : '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- 1. Akademik -->
        <div class="section">
            <div class="section-title">1. AKADEMIK</div>
            @if($laporan->laporanAkademik)
                <table class="info-table">
                    <tr>
                        <td class="info-label">SKS</td>
                        <td>: {{ $laporan->laporanAkademik->sks }} SKS</td>
                        <td class="info-label">Indeks Prestasi</td>
                        <td>: {{ number_format($laporan->laporanAkademik->indeks_prestasi, 2) }}</td>
                    </tr>
                </table>
            @else
                <p style="text-align: center; color: #9ca3af; font-style: italic;">Data akademik belum diisi.</p>
            @endif
        </div>

        <!-- 2. Referal -->
        @if($laporan->laporanReferals && $laporan->laporanReferals->count() > 0)
            <div class="section">
                <div class="section-title">2. REFERAL ({{ $laporan->laporanReferals->count() }})</div>
                <table>
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Nama</th>
                            <th width="25%">No. Telp</th>
                            <th width="35%">Program Studi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporan->laporanReferals as $index => $referal)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $referal->nama }}</td>
                                <td>{{ $referal->no_telp }}</td>
                                <td>{{ $referal->program_studi }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- 3. Pendanaan -->
        @if($laporan->laporanPendanaans && $laporan->laporanPendanaans->count() > 0)
            <div class="section">
                <div class="section-title">3. PENDANAAN ({{ $laporan->laporanPendanaans->count() }})</div>
                @foreach($laporan->laporanPendanaans as $index => $pendanaan)
                    <div class="item-card">
                        <div class="item-title">{{ $index + 1 }}. {{ $pendanaan->nama_pendanaan }}</div>
                        <table class="info-table">
                            <tr>
                                <td class="info-label" style="width: 100px;">Judul</td>
                                <td>: {{ $pendanaan->judul }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Keterangan</td>
                                <td>: {{ ucfirst($pendanaan->keterangan) }}</td>
                                <td class="info-label" style="width: 100px;">Posisi</td>
                                <td>: {{ ucfirst($pendanaan->posisi) }}</td>
                            </tr>
                        </table>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- 4. Kompetisi -->
        @if($laporan->laporanKompetisis && $laporan->laporanKompetisis->count() > 0)
            <div class="section">
                <div class="section-title">4. KOMPETISI ({{ $laporan->laporanKompetisis->count() }})</div>
                @foreach($laporan->laporanKompetisis as $index => $kompetisi)
                    <div class="item-card">
                        <div class="item-title">{{ $index + 1 }}. {{ $kompetisi->nama_kompetisi }}</div>
                        <table class="info-table">
                            <tr>
                                <td class="info-label" style="width: 100px;">Judul</td>
                                <td>: {{ $kompetisi->judul }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Juara</td>
                                <td>: {{ $kompetisi->juara ?? 'Tidak Juara' }}</td>
                                <td class="info-label" style="width: 100px;">Posisi</td>
                                <td>: {{ ucfirst($kompetisi->posisi) }}</td>
                            </tr>
                        </table>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- 5. Publikasi -->
        @if($laporan->laporanPublikasis && $laporan->laporanPublikasis->count() > 0)
            <div class="section">
                <div class="section-title">5. PUBLIKASI ({{ $laporan->laporanPublikasis->count() }})</div>
                <table>
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Judul</th>
                            <th width="25%">Tempat Publikasi</th>
                            <th width="20%">Kategori</th>
                            <th width="15%">Link</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporan->laporanPublikasis as $index => $publikasi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $publikasi->judul }}</td>
                                <td>{{ $publikasi->nama_tempat }}</td>
                                <td>{{ $publikasi->kategori }}</td>
                                <td>{{ $publikasi->link_jurnal ? '✓' : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Catatan Admin -->
        @if($laporan->catatan_admin)
            <div class="section">
                <div class="section-title">CATATAN ADMIN</div>
                <div style="background-color: #fef3c7; border: 1px solid #fcd34d; border-radius: 3px; padding: 10px;">
                    <strong>Catatan:</strong><br>
                    {{ $laporan->catatan_admin }}
                </div>
            </div>
        @endif

        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

    <!-- Footer -->
    <div class="footer">
        <p>Sistem Kemahasiswaan - Laporan Beasiswa</p>
        <p>Dicetak pada {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>
</body>
</html>
