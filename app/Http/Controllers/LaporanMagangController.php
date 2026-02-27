<?php

namespace App\Http\Controllers;

use App\Models\LaporanMagang;
use App\Models\LogKegiatan;
use App\Models\BuktiKegiatan;
use App\Models\MahasiswaMagang;
use App\Models\Mahasiswa;
use App\Models\TahunAjar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanMagangController extends Controller
{
    /**
     * Display list of laporan magang for mahasiswa.
     */
    public function index()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        
        // Check if mahasiswa has active magang
        $magangAktif = MahasiswaMagang::where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'aktif')
            ->first();

        if (!$magangAktif) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('error', 'Anda tidak terdaftar dalam program magang aktif.');
        }

        $laporans = LaporanMagang::with(['logKegiatans'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('mahasiswa_magang_id', $magangAktif->id)
            ->latest()
            ->paginate(10);

        return view('mahasiswa.laporan-magang.index', compact('laporans', 'magangAktif'));
    }

    /**
     * Show form for creating new laporan magang.
     */
    public function create()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $magangAktif = MahasiswaMagang::where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'aktif')
            ->first();

        if (!$magangAktif) {
            return redirect()->route('mahasiswa.laporan-magang.index')
                ->with('error', 'Anda tidak terdaftar dalam program magang aktif.');
        }

        // Get active tahun ajar
        $tahunAjarAktif = TahunAjar::where('is_active', true)->first();
        if (!$tahunAjarAktif) {
            return redirect()->route('mahasiswa.laporan-magang.index')
                ->with('error', 'Tidak ada tahun ajar aktif.');
        }

        return view('mahasiswa.laporan-magang.create', compact('magangAktif', 'tahunAjarAktif'));
    }

    /**
     * Store new laporan magang.
     */
    public function store(Request $request)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $magangAktif = MahasiswaMagang::where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'aktif')
            ->first();

        if (!$magangAktif) {
            return redirect()->route('mahasiswa.laporan-magang.index')
                ->with('error', 'Anda tidak terdaftar dalam program magang aktif.');
        }

        // Get active tahun ajar
        $tahunAjarAktif = TahunAjar::where('is_active', true)->first();
        if (!$tahunAjarAktif) {
            return redirect()->route('mahasiswa.laporan-magang.index')
                ->with('error', 'Tidak ada tahun ajar aktif.');
        }

        $validated = $request->validate([
            'judul_laporan' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:2000',
            'tanggal_kegiatan' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
            'lokasi_kegiatan' => 'required|string|max:255',

            // Log kegiatan (required, at least 1) - no tanggal anymore
            'log_uraian' => 'required|array|min:1',
            'log_uraian.*' => 'required|string|max:1000',
            'log_hasil' => 'nullable|array',
            'log_hasil.*' => 'nullable|string|max:1000',
            'log_kendala' => 'nullable|array',
            'log_kendala.*' => 'nullable|string|max:1000',
            'log_jam_mulai' => 'required|array|min:1',
            'log_jam_mulai.*' => 'required',
            'log_jam_selesai' => 'required|array|min:1',
            'log_jam_selesai.*' => 'required|after:log_jam_mulai.*',

            // Bukti kegiatan (PDF, multiple per log)
            'bukti_kegiatan' => 'nullable|array',
            'bukti_kegiatan.*' => 'nullable|array',
            'bukti_kegiatan.*.*' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        // Create laporan magang
        $laporan = LaporanMagang::create([
            'mahasiswa_magang_id' => $magangAktif->id,
            'mahasiswa_id' => $mahasiswa->id,
            'tahun_ajar_id' => $tahunAjarAktif->id,
            'judul_laporan' => $validated['judul_laporan'],
            'deskripsi' => $validated['deskripsi'],
            'tanggal_kegiatan' => $validated['tanggal_kegiatan'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'lokasi_kegiatan' => $validated['lokasi_kegiatan'],
            'status' => 'draft',
        ]);

        // Create log kegiatan (no tanggal, use tanggal_kegiatan from laporan)
        foreach ($validated['log_uraian'] as $index => $uraian) {
            if (!empty($uraian)) {
                $logKegiatan = LogKegiatan::create([
                    'laporan_magang_id' => $laporan->id,
                    'tanggal' => $validated['tanggal_kegiatan'],
                    'uraian_kegiatan' => $uraian,
                    'hasil_kegiatan' => $validated['log_hasil'][$index] ?? null,
                    'kendala' => $validated['log_kendala'][$index] ?? null,
                    'jam_mulai' => $validated['log_jam_mulai'][$index] ?? '',
                    'jam_selesai' => $validated['log_jam_selesai'][$index] ?? '',
                ]);

                // Upload bukti kegiatan (multiple PDFs per log)
                if (isset($validated['bukti_kegiatan'][$index])) {
                    foreach ($validated['bukti_kegiatan'][$index] as $file) {
                        if ($file && $file->isValid()) {
                            $filePath = $file->store('laporan-magang/bukti', 'public');
                            
                            BuktiKegiatan::create([
                                'log_kegiatan_id' => $logKegiatan->id,
                                'file_bukti' => $filePath,
                                'file_name' => $file->getClientOriginalName(),
                                'file_type' => $file->getMimeType(),
                                'file_size' => $file->getSize(),
                            ]);
                        }
                    }
                }
            }
        }

        // Handle submit action
        $action = $request->input('action');
        $status = $action === 'submit' ? 'submitted' : 'draft';

        $laporan->update([
            'status' => $status,
            'submitted_at' => $status === 'submitted' ? now() : null,
        ]);

        $message = $status === 'submitted'
            ? 'Laporan magang berhasil dikirim untuk direview.'
            : 'Laporan magang berhasil disimpan sebagai draft.';

        return redirect()->route('mahasiswa.laporan-magang.index')
            ->with('success', $message);
    }

    /**
     * Display specified laporan magang.
     */
    public function show(LaporanMagang $laporan)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if ($laporan->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        $laporan->load(['logKegiatans.buktiKegiatans', 'mahasiswaMagang']);

        return view('mahasiswa.laporan-magang.show', compact('laporan'));
    }

    /**
     * Show form for editing laporan magang.
     */
    public function edit(LaporanMagang $laporan)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if ($laporan->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($laporan->status !== 'draft') {
            return redirect()->route('mahasiswa.laporan-magang.show', $laporan)
                ->with('error', 'Laporan yang sudah dikirim tidak dapat diedit.');
        }

        $laporan->load(['logKegiatans.buktiKegiatans']);

        return view('mahasiswa.laporan-magang.edit', compact('laporan'));
    }

    /**
     * Update laporan magang.
     */
    public function update(Request $request, LaporanMagang $laporan)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if ($laporan->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        $validated = $request->validate([
            'judul_laporan' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:2000',
            'tanggal_kegiatan' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
            'lokasi_kegiatan' => 'required|string|max:255',
        ]);

        $laporan->update($validated);

        return redirect()->route('mahasiswa.laporan-magang.show', $laporan)
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    /**
     * Submit laporan magang for review.
     */
    public function submit(LaporanMagang $laporan)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if ($laporan->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($laporan->status !== 'draft') {
            return redirect()->route('mahasiswa.laporan-magang.show', $laporan)
                ->with('error', 'Laporan sudah dikirim.');
        }

        $laporan->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        return redirect()->route('mahasiswa.laporan-magang.index')
            ->with('success', 'Laporan magang berhasil dikirim untuk direview.');
    }

    /**
     * Delete laporan magang.
     */
    public function destroy(LaporanMagang $laporan)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if ($laporan->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($laporan->status !== 'draft') {
            return redirect()->route('mahasiswa.laporan-magang.show', $laporan)
                ->with('error', 'Laporan yang sudah dikirim tidak dapat dihapus.');
        }

        // Delete files
        foreach ($laporan->logKegiatans as $log) {
            foreach ($log->buktiKegiatans as $bukti) {
                if ($bukti->file_bukti) {
                    Storage::disk('public')->delete($bukti->file_bukti);
                }
            }
        }

        $laporan->delete();

        return redirect()->route('mahasiswa.laporan-magang.index')
            ->with('success', 'Laporan magang berhasil dihapus.');
    }

    /**
     * Add log kegiatan to existing laporan.
     */
    public function addLog(Request $request, LaporanMagang $laporan)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if ($laporan->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($laporan->status !== 'draft') {
            return response()->json(['error' => 'Laporan sudah dikirim'], 403);
        }

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'uraian_kegiatan' => 'required|string|max:1000',
            'hasil_kegiatan' => 'nullable|string|max:1000',
            'kendala' => 'nullable|string|max:1000',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'bukti_files' => 'nullable|array',
            'bukti_files.*' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $logKegiatan = LogKegiatan::create([
            'laporan_magang_id' => $laporan->id,
            'tanggal' => $validated['tanggal'],
            'uraian_kegiatan' => $validated['uraian_kegiatan'],
            'hasil_kegiatan' => $validated['hasil_kegiatan'] ?? null,
            'kendala' => $validated['kendala'] ?? null,
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
        ]);

        // Upload bukti kegiatan
        if ($request->hasFile('bukti_files')) {
            foreach ($request->file('bukti_files') as $file) {
                if ($file && $file->isValid()) {
                    $filePath = $file->store('laporan-magang/bukti', 'public');
                    
                    BuktiKegiatan::create([
                        'log_kegiatan_id' => $logKegiatan->id,
                        'file_bukti' => $filePath,
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }
        }

        return response()->json(['success' => true, 'log' => $logKegiatan->load('buktiKegiatans')]);
    }

    /**
     * Delete log kegiatan.
     */
    public function deleteLog(LaporanMagang $laporan, LogKegiatan $log)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if ($laporan->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($laporan->status !== 'draft') {
            return response()->json(['error' => 'Laporan sudah dikirim'], 403);
        }

        // Delete files
        foreach ($log->buktiKegiatans as $bukti) {
            if ($bukti->file_bukti) {
                Storage::disk('public')->delete($bukti->file_bukti);
            }
        }

        $log->delete();

        return response()->json(['success' => true]);
    }

    // ==========================================
    // ADMIN METHODS
    // ==========================================

    /**
     * Display list of all laporan magang for admin (grouped by mahasiswa).
     */
    public function adminIndex(Request $request)
    {
        $query = LaporanMagang::with(['mahasiswa.programStudi', 'mahasiswaMagang', 'tahunAjar']);

        if ($request->filled('tahun_ajar_id')) {
            $query->where('tahun_ajar_id', $request->tahun_ajar_id);
        }

        if ($request->filled('perusahaan')) {
            $query->whereHas('mahasiswaMagang', function($q) use ($request) {
                $q->where('nama_perusahaan', 'like', "%{$request->perusahaan}%");
            });
        }

        // Group by mahasiswa and count reports
        $laporans = $query->get();
        
        // Group by mahasiswa_id
        $groupedLaporans = $laporans->groupBy('mahasiswa_id');
        
        // Create summary for each mahasiswa
        $mahasiswaList = $groupedLaporans->map(function($laporans, $mahasiswaId) {
            $firstLaporan = $laporans->first();
            return [
                'mahasiswa_id' => $mahasiswaId,
                'mahasiswa' => $firstLaporan->mahasiswa,
                'program_studi' => $firstLaporan->mahasiswa->programStudi,
                'total_laporan' => $laporans->count(),
                'laporans' => $laporans,
                'latest_report' => $laporans->sortByDesc('created_at')->first(),
                'status_summary' => [
                    'draft' => $laporans->where('status', 'draft')->count(),
                    'submitted' => $laporans->where('status', 'submitted')->count(),
                    'approved' => $laporans->where('status', 'approved')->count(),
                    'rejected' => $laporans->where('status', 'rejected')->count(),
                ]
            ];
        })->sortBy('mahasiswa.name');

        $tahunAjarList = TahunAjar::orderBy('tahun_mulai', 'desc')->get();

        return view('admin.laporan-magang.index', compact('mahasiswaList', 'tahunAjarList'));
    }

    /**
     * Display specified laporan magang for admin.
     */
    public function adminShow(LaporanMagang $laporanMagang)
    {
        $laporanMagang->load(['logKegiatans.buktiKegiatans', 'mahasiswa.programStudi', 'mahasiswaMagang', 'tahunAjar']);
        return view('admin.laporan-magang.show', compact('laporanMagang'));
    }

    /**
     * Display all laporan magang for a specific mahasiswa.
     */
    public function adminShowMahasiswa($mahasiswaId)
    {
        $mahasiswa = Mahasiswa::with('programStudi')->findOrFail($mahasiswaId);
        $laporans = LaporanMagang::with(['tahunAjar', 'mahasiswaMagang'])
            ->where('mahasiswa_id', $mahasiswaId)
            ->latest()
            ->get();
        
        $totalLaporan = $laporans->count();
        $statusSummary = [
            'draft' => $laporans->where('status', 'draft')->count(),
            'submitted' => $laporans->where('status', 'submitted')->count(),
            'approved' => $laporans->where('status', 'approved')->count(),
            'rejected' => $laporans->where('status', 'rejected')->count(),
        ];

        return view('admin.laporan-magang.mahasiswa-detail', compact('mahasiswa', 'laporans', 'totalLaporan', 'statusSummary'));
    }

    /**
     * Approve laporan magang.
     */
    public function adminApprove(Request $request, LaporanMagang $laporanMagang)
    {
        $validated = $request->validate([
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        $laporanMagang->update([
            'status' => 'approved',
            'catatan_admin' => $validated['catatan_admin'] ?? null,
            'approved_at' => now(),
        ]);

        return redirect()->route('admin.laporan-magang.index')
            ->with('success', 'Laporan magang berhasil disetujui.');
    }

    /**
     * Reject laporan magang.
     */
    public function adminReject(Request $request, LaporanMagang $laporanMagang)
    {
        $validated = $request->validate([
            'catatan_admin' => 'required|string|max:1000',
        ]);

        $laporanMagang->update([
            'status' => 'rejected',
            'catatan_admin' => $validated['catatan_admin'],
            'approved_at' => null,
        ]);

        return redirect()->route('admin.laporan-magang.index')
            ->with('success', 'Laporan magang ditolak.');
    }

    /**
     * Download laporan magang as PDF.
     */
    public function downloadPdf(LaporanMagang $laporanMagang)
    {
        $laporanMagang->load(['logKegiatans.buktiKegiatans', 'mahasiswa.programStudi', 'mahasiswaMagang']);

        $pdf = Pdf::loadView('admin.laporan-magang.pdf', compact('laporanMagang'));

        $filename = 'Laporan_Magang_' . $laporanMagang->mahasiswa->nim . '_' . $laporanMagang->judul_laporan . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Download multiple laporan magang as PDF.
     */
    public function downloadMultiplePdf(Request $request)
    {
        $validated = $request->validate([
            'laporan_ids' => 'required|array',
            'laporan_ids.*' => 'exists:laporan_magangs,id',
        ]);

        $laporans = LaporanMagang::with(['logKegiatans.buktiKegiatans', 'mahasiswa.programStudi', 'mahasiswaMagang'])
            ->whereIn('id', $validated['laporan_ids'])
            ->get();

        $pdf = Pdf::loadView('admin.laporan-magang.pdf-multiple', compact('laporans'));

        $filename = 'Laporan_Magang_' . now()->format('Y-m-d_His') . '.pdf';

        return $pdf->download($filename);
    }
}
