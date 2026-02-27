<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Laporan Magang</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #333;
            padding-left: 25px;
            padding-right: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #ea580c;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 16px;
            color: #ea580c;
            margin-bottom: 5px;
        }
        .header h2 {
            font-size: 13px;
            color: #666;
            font-weight: normal;
        }
        .summary {
            margin-bottom: 20px;
            background: #fef9f3;
            padding: 10px;
            border-radius: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background: #ea580c;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background: #fef9f3;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
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
            font-size: 9px;
            color: #888;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>REKAPITULASI LAPORAN MAGANG</h1>
        <h2>Sistem Kemahasiswaan</h2>
    </div>

    <!-- Summary -->
    <div class="summary">
        <strong>Total Laporan:</strong> {{ $laporans->count() }} | 
        <strong>Dicetak:</strong> {{ now()->format('d F Y H:i') }}
    </div>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 18%;">Mahasiswa</th>
                <th style="width: 12%;">Tahun Ajar</th>
                <th style="width: 22%;">Judul Laporan</th>
                <th style="width: 18%;">Perusahaan</th>
                <th style="width: 10%;">Tanggal</th>
                <th style="width: 8%;">Status</th>
                <th style="width: 7%;">Log</th>
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
                    <td><small>{{ $laporan->tahunAjar->nama }}</small></td>
                    <td>{{ Str::limit($laporan->judul_laporan, 40) }}</td>
                    <td>{{ Str::limit($laporan->mahasiswaMagang->nama_perusahaan, 25) }}</td>
                    <td>{{ $laporan->tanggal_kegiatan->format('d/m/Y') }}</td>
                    <td>
                        @if($laporan->status === 'draft')
                            <span class="status-badge status-draft">Draft</span>
                        @elseif($laporan->status === 'submitted')
                            <span class="status-badge status-submitted">Submitted</span>
                        @elseif($laporan->status === 'approved')
                            <span class="status-badge status-approved">Approved</span>
                        @else
                            <span class="status-badge status-rejected">Rejected</span>
                        @endif
                    </td>
                    <td>{{ $laporan->logKegiatans->count() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Detailed Reports -->
    @foreach($laporans as $laporanIndex => $laporan)
        @if($laporanIndex > 0)
            <div class="page-break"></div>
        @endif

        <div style="margin-top: 30px; margin-bottom: 20px;">
            <h3 style="color: #ea580c; border-bottom: 2px solid #ea580c; padding-bottom: 5px; margin-bottom: 15px;">
                LAPORAN #{{ $laporanIndex + 1 }}: {{ $laporan->judul_laporan }}
            </h3>
        </div>

        <!-- Info -->
        <div style="margin-bottom: 15px;">
            <table style="margin-bottom: 0;">
                <tr>
                    <td style="width: 25%; border: none;"><strong>Mahasiswa</strong></td>
                    <td style="border: none;">: {{ $laporan->mahasiswa->name }} ({{ $laporan->mahasiswa->nim }})</td>
                    <td style="width: 25%; border: none;"><strong>Perusahaan</strong></td>
                    <td style="border: none;">: {{ Str::limit($laporan->mahasiswaMagang->nama_perusahaan, 30) }}</td>
                </tr>
                <tr>
                    <td style="border: none;"><strong>Tanggal</strong></td>
                    <td style="border: none;">: {{ $laporan->tanggal_kegiatan->format('d F Y') }}</td>
                    <td style="border: none;"><strong>Status</strong></td>
                    <td style="border: none;">
                        @if($laporan->status === 'draft')
                            <span class="status-badge status-draft">Draft</span>
                        @elseif($laporan->status === 'submitted')
                            <span class="status-badge status-submitted">Submitted</span>
                        @elseif($laporan->status === 'approved')
                            <span class="status-badge status-approved">Approved</span>
                        @else
                            <span class="status-badge status-rejected">Rejected</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <!-- Logs -->
        <div style="margin-bottom: 15px;">
            <strong style="color: #ea580c;">Log Kegiatan:</strong>
            @forelse($laporan->logKegiatans as $logIndex => $log)
                <div style="border: 1px solid #ddd; border-radius: 5px; padding: 8px; margin-top: 8px; background: #fef9f3;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <strong>{{ $log->tanggal->format('d/m/Y') }}</strong>
                        <small>{{ $log->jam_mulai }} - {{ $log->jam_selesai }}</small>
                    </div>
                    <div style="font-size: 10px;">
                        <strong>Uraian:</strong> {{ Str::limit($log->uraian_kegiatan, 150) }}
                        @if($log->buktiKegiatans->count() > 0)
                            | <strong>Bukti:</strong> {{ $log->buktiKegiatans->count() }} file
                        @endif
                    </div>
                </div>
            @empty
                <p style="color: #888; font-style: italic;">Tidak ada log kegiatan.</p>
            @endforelse
        </div>
    @endforeach

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis dari Sistem Kemahasiswaan</p>
        <p>Total {{ $laporans->count() }} laporan | Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
    </div>
</body>
</html>
