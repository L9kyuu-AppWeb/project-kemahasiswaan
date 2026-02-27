<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Magang - {{ $laporanMagang->mahasiswa->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding-left: 30px;
            padding-right: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #ea580c;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 18px;
            color: #ea580c;
            margin-bottom: 5px;
        }
        .header h2 {
            font-size: 14px;
            color: #666;
            font-weight: normal;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #ea580c;
            border-bottom: 2px solid #ea580c;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .info-grid {
            display: table;
            width: 100%;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            width: 35%;
            font-weight: bold;
            padding: 5px 0;
            color: #555;
        }
        .info-value {
            display: table-cell;
            padding: 5px 0 5px 10px;
            color: #333;
        }
        .log-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 12px;
            background: #fef9f3;
        }
        .log-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
        }
        .log-date {
            font-weight: bold;
            color: #ea580c;
        }
        .log-time {
            background: #fed7aa;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
        }
        .log-content {
            margin-bottom: 8px;
        }
        .log-label {
            font-weight: bold;
            color: #666;
            font-size: 11px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            margin-top: 10px;
        }
        .status-draft { background: #e5e7eb; color: #374151; }
        .status-submitted { background: #fef3c7; color: #92400e; }
        .status-approved { background: #d1fae5; color: #065f46; }
        .status-rejected { background: #fee2e2; color: #991b1b; }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #888;
        }
        .signature-section {
            margin-top: 40px;
            display: table;
            width: 100%;
        }
        .signature-row {
            display: table-row;
        }
        .signature-col {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 10px;
        }
        .signature-box {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            min-height: 100px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN KEGIATAN MAGANG</h1>
        <h2>Sistem Kemahasiswaan</h2>
    </div>

    <!-- Status -->
    <div class="section">
        @if($laporanMagang->status === 'draft')
            <span class="status-badge status-draft">DRAFT</span>
        @elseif($laporanMagang->status === 'submitted')
            <span class="status-badge status-submitted">SUBMITTED</span>
        @elseif($laporanMagang->status === 'approved')
            <span class="status-badge status-approved">APPROVED</span>
        @else
            <span class="status-badge status-rejected">REJECTED</span>
        @endif
    </div>

    <!-- Informasi Laporan -->
    <div class="section">
        <div class="section-title">INFORMASI LAPORAN</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Judul Laporan</div>
                <div class="info-value">: {{ $laporanMagang->judul_laporan }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tahun Ajar</div>
                <div class="info-value">: {{ $laporanMagang->tahunAjar->nama }} ({{ ucfirst($laporanMagang->tahunAjar->semester) }})</div>
            </div>
            <div class="info-row">
                <div class="info-label">Deskripsi</div>
                <div class="info-value">: {{ $laporanMagang->deskripsi }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal Kegiatan</div>
                <div class="info-value">: {{ $laporanMagang->tanggal_kegiatan->format('d F Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Waktu</div>
                <div class="info-value">: {{ $laporanMagang->waktu_mulai }} - {{ $laporanMagang->waktu_selesai }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Lokasi</div>
                <div class="info-value">: {{ $laporanMagang->lokasi_kegiatan }}</div>
            </div>
        </div>
    </div>

    <!-- Informasi Mahasiswa -->
    <div class="section">
        <div class="section-title">INFORMASI MAHASISWA</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nama</div>
                <div class="info-value">: {{ $laporanMagang->mahasiswa->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">NIM</div>
                <div class="info-value">: {{ $laporanMagang->mahasiswa->nim }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Program Studi</div>
                <div class="info-value">: {{ $laporanMagang->mahasiswa->programStudi->nama ?? '-' }}</div>
            </div>
        </div>
    </div>

    <!-- Informasi Perusahaan -->
    <div class="section">
        <div class="section-title">INFORMASI PERUSAHAAN</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nama Perusahaan</div>
                <div class="info-value">: {{ $laporanMagang->mahasiswaMagang->nama_perusahaan }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Lokasi</div>
                <div class="info-value">: {{ $laporanMagang->mahasiswaMagang->lokasi_perusahaan }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Pembimbing Lapangan</div>
                <div class="info-value">: {{ $laporanMagang->mahasiswaMagang->pembimbing_lapangan ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Dosen Pembimbing</div>
                <div class="info-value">: {{ $laporanMagang->mahasiswaMagang->dosen_pembimbing_nama ?? '-' }}</div>
            </div>
        </div>
    </div>

    <!-- Log Kegiatan -->
    <div class="section">
        <div class="section-title">LOG KEGIATAN HARIAN</div>
        @forelse($laporanMagang->logKegiatans as $log)
            <div class="log-item">
                <div class="log-header">
                    <span class="log-date">{{ $log->tanggal->format('d F Y') }}</span>
                    <span class="log-time">{{ $log->jam_mulai }} - {{ $log->jam_selesai }}</span>
                </div>
                <div class="log-content">
                    <div class="log-label">Uraian Kegiatan:</div>
                    <div>{{ $log->uraian_kegiatan }}</div>
                </div>
                @if($log->hasil_kegiatan)
                    <div class="log-content">
                        <div class="log-label">Hasil Kegiatan:</div>
                        <div>{{ $log->hasil_kegiatan }}</div>
                    </div>
                @endif
                @if($log->kendala)
                    <div class="log-content">
                        <div class="log-label">Kendala:</div>
                        <div>{{ $log->kendala }}</div>
                    </div>
                @endif
                @if($log->buktiKegiatans->count() > 0)
                    <div class="log-content">
                        <div class="log-label">Bukti Kegiatan ({{ $log->buktiKegiatans->count() }} file):</div>
                        <div>
                            @foreach($log->buktiKegiatans as $bukti)
                                <div>- {{ $bukti->file_name }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <p>Belum ada log kegiatan.</p>
        @endforelse
    </div>

    <!-- Catatan Admin -->
    @if($laporanMagang->catatan_admin)
        <div class="section">
            <div class="section-title">CATATAN ADMIN</div>
            <p>{{ $laporanMagang->catatan_admin }}</p>
        </div>
    @endif

    <!-- Tanda Tangan -->
    <div class="signature-section">
        <div class="signature-row">
            <div class="signature-col">
                <div class="signature-box">
                    <p><strong>Mahasiswa</strong></p>
                    <br><br><br>
                    <p>{{ $laporanMagang->mahasiswa->name }}</p>
                    <p>NIM: {{ $laporanMagang->mahasiswa->nim }}</p>
                </div>
            </div>
            <div class="signature-col">
                <div class="signature-box">
                    <p><strong>Dosen Pembimbing</strong></p>
                    <br><br><br>
                    <p>{{ $laporanMagang->mahasiswaMagang->dosen_pembimbing_nama ?? '........................' }}</p>
                    @if($laporanMagang->mahasiswaMagang->dosen_pembimbing_nik)
                        <p>NIK: {{ $laporanMagang->mahasiswaMagang->dosen_pembimbing_nik }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }} | Sistem Kemahasiswaan</p>
        @if($laporanMagang->approved_at)
            <p>Disetujui pada: {{ $laporanMagang->approved_at->format('d F Y H:i') }}</p>
        @endif
    </div>
</body>
</html>
