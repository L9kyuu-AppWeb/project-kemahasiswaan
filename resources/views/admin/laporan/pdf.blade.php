<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Beasiswa - {{ $laporan->mahasiswa->name }}</title>
    <style>
        @page {
            margin: 2cm 1.5cm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #333;
            padding-left: 10px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 18pt;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 5px;
        }
        
        .header h2 {
            font-size: 14pt;
            font-weight: normal;
            color: #666;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 14pt;
            font-weight: bold;
            color: #1e40af;
            border-bottom: 2px solid #93c5fd;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            width: 180px;
            font-weight: bold;
            color: #555;
            padding: 5px 0;
        }
        
        .info-value {
            display: table-cell;
            padding: 5px 0 5px 10px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 15px;
            font-size: 10pt;
            font-weight: bold;
        }
        
        .status-approved {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .status-submitted {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-draft {
            background-color: #f3f4f6;
            color: #374151;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        table th {
            background-color: #eff6ff;
            padding: 8px 10px;
            text-align: left;
            font-weight: bold;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }
        
        table td {
            padding: 8px 10px;
            border: 1px solid #e5e7eb;
        }
        
        .item-card {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
        
        .item-title {
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 8px;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10pt;
            color: #666;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }
        
        .catatan-box {
            background-color: #fef3c7;
            border: 1px solid #fcd34d;
            border-radius: 5px;
            padding: 12px;
            margin-top: 15px;
        }
        
        .catatan-title {
            font-weight: bold;
            color: #92400e;
            margin-bottom: 8px;
        }
        
        .no-data {
            text-align: center;
            color: #9ca3af;
            font-style: italic;
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN BEASISWA MAHASISWA</h1>
        <h2>Sistem Kemahasiswaan</h2>
    </div>

    <!-- Informasi Umum -->
    <div class="section">
        <div class="section-title">INFORMASI UMUM</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nama Mahasiswa</div>
                <div class="info-value">: {{ $laporan->mahasiswa->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">NIM</div>
                <div class="info-value">: {{ $laporan->mahasiswa->nim }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Program Studi</div>
                <div class="info-value">: {{ $laporan->mahasiswa->programStudi->nama ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Jenis Beasiswa</div>
                <div class="info-value">: {{ $laporan->beasiswaTipe->nama }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tahun Ajar</div>
                <div class="info-value">: {{ $laporan->tahunAjar->nama ?? $laporan->tahunAjar->tahun_mulai . '/' . $laporan->tahunAjar->tahun_akhir }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Semester</div>
                <div class="info-value">: Semester {{ $laporan->semester }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Status</div>
                <div class="info-value">: 
                    @if($laporan->status === 'approved')
                        <span class="status-badge status-approved">APPROVED</span>
                    @elseif($laporan->status === 'rejected')
                        <span class="status-badge status-rejected">REJECTED</span>
                    @elseif($laporan->status === 'submitted')
                        <span class="status-badge status-submitted">SUBMITTED</span>
                    @else
                        <span class="status-badge status-draft">DRAFT</span>
                    @endif
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal Submit</div>
                <div class="info-value">: {{ $laporan->submitted_at ? $laporan->submitted_at->format('d F Y, H:i') : '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal Approve</div>
                <div class="info-value">: {{ $laporan->approved_at ? $laporan->approved_at->format('d F Y, H:i') : '-' }}</div>
            </div>
        </div>
    </div>

    <!-- 1. Akademik -->
    <div class="section">
        <div class="section-title">1. AKADEMIK</div>
        @if($laporan->laporanAkademik)
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">SKS</div>
                    <div class="info-value">: {{ $laporan->laporanAkademik->sks }} SKS</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Indeks Prestasi</div>
                    <div class="info-value">: {{ number_format($laporan->laporanAkademik->indeks_prestasi, 2) }}</div>
                </div>
            </div>
        @else
            <p class="no-data">Data akademik belum diisi.</p>
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
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-label" style="width: 120px;">Judul</div>
                            <div class="info-value">: {{ $pendanaan->judul }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label" style="width: 120px;">Keterangan</div>
                            <div class="info-value">: {{ ucfirst($pendanaan->keterangan) }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label" style="width: 120px;">Posisi</div>
                            <div class="info-value">: {{ ucfirst($pendanaan->posisi) }}</div>
                        </div>
                    </div>
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
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-label" style="width: 120px;">Judul</div>
                            <div class="info-value">: {{ $kompetisi->judul }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label" style="width: 120px;">Juara</div>
                            <div class="info-value">: {{ $kompetisi->juara ?? 'Tidak Juara' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label" style="width: 120px;">Posisi</div>
                            <div class="info-value">: {{ ucfirst($kompetisi->posisi) }}</div>
                        </div>
                    </div>
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
                        <th width="15%">Link Jurnal</th>
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
            <div class="catatan-box">
                <div class="catatan-title">Catatan:</div>
                <p>{{ $laporan->catatan_admin }}</p>
            </div>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dicetak pada {{ now()->format('d F Y, H:i') }} WIB</p>
        <p>Sistem Kemahasiswaan - Laporan Beasiswa</p>
    </div>
</body>
</html>
