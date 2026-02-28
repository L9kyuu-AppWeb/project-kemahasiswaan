<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pendaftaran Verifikasi - {{ $detail->nomor_antrian }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        .container {
            max-width: 700px;
            margin: 0 auto;
            border: 2px solid #10b981;
            border-radius: 12px;
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 14px;
            opacity: 0.9;
        }
        .content {
            padding: 25px;
            background: #fff;
        }
        .antrian-box {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin-bottom: 25px;
        }
        .antrian-label {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }
        .antrian-number {
            font-size: 36px;
            font-weight: bold;
            color: #10b981;
            font-family: 'Courier New', monospace;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table tr {
            border-bottom: 1px solid #e5e7eb;
        }
        .info-table tr:last-child {
            border-bottom: none;
        }
        .info-table td {
            padding: 12px 0;
        }
        .info-table td:first-child {
            font-weight: 600;
            color: #6b7280;
            width: 180px;
            font-size: 13px;
        }
        .info-table td:last-child {
            color: #1f2937;
            font-size: 14px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-menunggu {
            background: #fef3c7;
            color: #92400e;
        }
        .status-terverifikasi {
            background: #d1fae5;
            color: #065f46;
        }
        .status-dibatalkan {
            background: #fee2e2;
            color: #991b1b;
        }
        .footer {
            background: #f9fafb;
            padding: 20px 25px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
        }
        .footer-note {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 15px;
        }
        .qr-placeholder {
            display: inline-block;
            width: 100px;
            height: 100px;
            background: #f3f4f6;
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            line-height: 100px;
            color: #9ca3af;
            font-size: 40px;
        }
        .info-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }
        .info-box-title {
            font-weight: 600;
            color: #1e40af;
            font-size: 13px;
            margin-bottom: 8px;
        }
        .info-box ul {
            font-size: 12px;
            color: #1e3a8a;
            padding-left: 20px;
        }
        .info-box li {
            margin-bottom: 4px;
        }
        .print-date {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>BUKTI PENDAFTARAN VERIFIKASI</h1>
            <p>Sistem Kemahasiswaan</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Nomor Antrian -->
            <div class="antrian-box">
                <div class="antrian-label">Nomor Antrian Anda</div>
                <div class="antrian-number">{{ $detail->nomor_antrian }}</div>
            </div>

            <!-- Info Table -->
            <table class="info-table">
                <tr>
                    <td>Nama Kegiatan</td>
                    <td>: <strong>{{ $detail->antrianVerifikasi->nama }}</strong></td>
                </tr>
                <tr>
                    <td>Tanggal Verifikasi</td>
                    <td>: <strong>{{ $detail->tanggal_verifikasi->format('d M Y') }}</strong></td>
                </tr>
                <tr>
                    <td>Hari</td>
                    <td>: {{ $detail->tanggal_verifikasi->format('l') }}</td>
                </tr>
                <tr>
                    <td>Nama Mahasiswa</td>
                    <td>: {{ $detail->mahasiswa->name }}</td>
                </tr>
                <tr>
                    <td>NIM</td>
                    <td>: {{ $detail->mahasiswa->nim }}</td>
                </tr>
                <tr>
                    <td>Program Studi</td>
                    <td>: {{ $detail->mahasiswa->programStudi->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>: 
                        @if($detail->status === 'menunggu')
                            <span class="status-badge status-menunggu">Menunggu Verifikasi</span>
                        @elseif($detail->status === 'terverifikasi')
                            <span class="status-badge status-terverifikasi">Terverifikasi</span>
                        @else
                            <span class="status-badge status-dibatalkan">Dibatalkan</span>
                        @endif
                    </td>
                </tr>
                @if($detail->keterangan)
                <tr>
                    <td>Keterangan</td>
                    <td>: {{ $detail->keterangan }}</td>
                </tr>
                @endif
            </table>

            <!-- Info Box -->
            <div class="info-box">
                <div class="info-box-title">📌 Catatan Penting:</div>
                <ul>
                    <li>Harap hadir 15 menit sebelum jadwal verifikasi</li>
                    <li>Tunjukkan bukti ini kepada petugas verifikasi</li>
                    <li>Bawa dokumen pendukung yang diperlukan</li>
                    <li>Jika berhalangan hadir, segera batalkan melalui sistem</li>
                </ul>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="qr-placeholder">QR</div>
            <p class="footer-note">Tunjukkan bukti ini kepada petugas verifikasi</p>
            <p class="print-date">Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
