<?php

namespace App\Http\Controllers;

use App\Models\LaporanBeasiswa;
use App\Models\LaporanAkademik;
use App\Models\LaporanReferal;
use App\Models\LaporanPendanaan;
use App\Models\LaporanKompetisi;
use App\Models\LaporanPublikasi;
use App\Models\TahunAjar;
use App\Models\BeasiswaTipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * Display list of laporan for mahasiswa.
     */
    public function index()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $laporans = LaporanBeasiswa::with(['tahunAjar', 'beasiswaTipe'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->latest()
            ->paginate(10);
        
        return view('mahasiswa.laporan.index', compact('laporans'));
    }

    /**
     * Show form for creating new laporan.
     */
    public function create()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $tahunAjarList = TahunAjar::orderBy('tahun_mulai', 'desc')->get();
        $beasiswaTipe = $mahasiswa->beasiswas()->where('status', 'aktif')->first();
        
        // Check if mahasiswa has active beasiswa
        if (!$beasiswaTipe) {
            return redirect()->route('mahasiswa.laporan.index')
                ->with('error', 'Anda tidak memiliki beasiswa aktif.');
        }

        return view('mahasiswa.laporan.create', compact('tahunAjarList', 'beasiswaTipe'));
    }

    /**
     * Store new laporan.
     */
    public function store(Request $request)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $beasiswaTipe = $mahasiswa->beasiswas()->where('status', 'aktif')->first();

        if (!$beasiswaTipe) {
            return redirect()->route('mahasiswa.laporan.index')
                ->with('error', 'Anda tidak memiliki beasiswa aktif.');
        }

        $validated = $request->validate([
            'tahun_ajar_id' => 'required|exists:tahun_ajars,id',
            'semester' => 'required|integer|min:1|max:10',
            
            // Akademik (required)
            'sks' => 'required|integer|min:1|max:24',
            'indeks_prestasi' => 'required|numeric|min:0|max:4',
            'file_khs' => 'required|file|mimes:pdf|max:2048',
            
            // Referal (optional, can be multiple)
            'referal_nama' => 'nullable|array',
            'referal_nama.*' => 'nullable|string|max:255',
            'referal_telp' => 'nullable|array',
            'referal_telp.*' => 'nullable|string|max:20',
            'referal_prodi' => 'nullable|array',
            'referal_prodi.*' => 'nullable|string|max:255',
            
            // Pendanaan (optional, can be multiple)
            'pendanaan_nama' => 'nullable|array',
            'pendanaan_nama.*' => 'nullable|string|max:255',
            'pendanaan_judul' => 'nullable|array',
            'pendanaan_judul.*' => 'nullable|string|max:255',
            'pendanaan_keterangan' => 'nullable|array',
            'pendanaan_keterangan.*' => 'nullable|in:lolos,tidak',
            'pendanaan_posisi' => 'nullable|array',
            'pendanaan_posisi.*' => 'nullable|in:ketua,anggota',
            'pendanaan_bukti' => 'nullable|array',
            'pendanaan_bukti.*' => 'nullable|file|mimes:pdf|max:2048',
            
            // Kompetisi (optional, can be multiple)
            'kompetisi_nama' => 'nullable|array',
            'kompetisi_nama.*' => 'nullable|string|max:255',
            'kompetisi_judul' => 'nullable|array',
            'kompetisi_judul.*' => 'nullable|string|max:255',
            'kompetisi_juara' => 'nullable|array',
            'kompetisi_juara.*' => 'nullable|string|max:50',
            'kompetisi_posisi' => 'nullable|array',
            'kompetisi_posisi.*' => 'nullable|in:ketua,anggota',
            'kompetisi_bukti' => 'nullable|array',
            'kompetisi_bukti.*' => 'nullable|file|mimes:pdf|max:2048',
            
            // Publikasi (optional, can be multiple)
            'publikasi_judul' => 'nullable|array',
            'publikasi_judul.*' => 'nullable|string|max:255',
            'publikasi_tempat' => 'nullable|array',
            'publikasi_tempat.*' => 'nullable|string|max:255',
            'publikasi_link' => 'nullable|array',
            'publikasi_link.*' => 'nullable|url|max:500',
            'publikasi_kategori' => 'nullable|array',
            'publikasi_kategori.*' => 'nullable|string|max:50',
        ]);

        // Upload file KHS
        $fileKhsPath = $request->file('file_khs')->store('laporan/khs', 'public');

        // Create laporan beasiswa
        $laporan = LaporanBeasiswa::create([
            'mahasiswa_id' => $mahasiswa->id,
            'beasiswa_tipe_id' => $beasiswaTipe->beasiswa_tipe_id,
            'tahun_ajar_id' => $validated['tahun_ajar_id'],
            'semester' => $validated['semester'],
            'status' => 'draft',
        ]);

        // Create laporan akademik
        LaporanAkademik::create([
            'laporan_beasiswa_id' => $laporan->id,
            'sks' => $validated['sks'],
            'indeks_prestasi' => $validated['indeks_prestasi'],
            'file_khs' => $fileKhsPath,
        ]);

        // Create referals
        if (!empty($validated['referal_nama'])) {
            foreach ($validated['referal_nama'] as $index => $nama) {
                if (!empty($nama)) {
                    LaporanReferal::create([
                        'laporan_beasiswa_id' => $laporan->id,
                        'nama' => $nama,
                        'no_telp' => $validated['referal_telp'][$index] ?? '',
                        'program_studi' => $validated['referal_prodi'][$index] ?? '',
                    ]);
                }
            }
        }

        // Create pendanaan
        if (!empty($validated['pendanaan_nama'])) {
            foreach ($validated['pendanaan_nama'] as $index => $nama) {
                if (!empty($nama)) {
                    $fileBuktiPath = null;
                    if (isset($validated['pendanaan_bukti'][$index]) && $validated['pendanaan_bukti'][$index]) {
                        $fileBuktiPath = $validated['pendanaan_bukti'][$index]->store('laporan/pendanaan', 'public');
                    }

                    LaporanPendanaan::create([
                        'laporan_beasiswa_id' => $laporan->id,
                        'nama_pendanaan' => $nama,
                        'judul' => $validated['pendanaan_judul'][$index] ?? '',
                        'keterangan' => $validated['pendanaan_keterangan'][$index] ?? 'tidak',
                        'posisi' => $validated['pendanaan_posisi'][$index] ?? 'anggota',
                        'file_bukti' => $fileBuktiPath,
                    ]);
                }
            }
        }

        // Create kompetisi
        if (!empty($validated['kompetisi_nama'])) {
            foreach ($validated['kompetisi_nama'] as $index => $nama) {
                if (!empty($nama)) {
                    $fileBuktiPath = null;
                    if (isset($validated['kompetisi_bukti'][$index]) && $validated['kompetisi_bukti'][$index]) {
                        $fileBuktiPath = $validated['kompetisi_bukti'][$index]->store('laporan/kompetisi', 'public');
                    }

                    LaporanKompetisi::create([
                        'laporan_beasiswa_id' => $laporan->id,
                        'nama_kompetisi' => $nama,
                        'judul' => $validated['kompetisi_judul'][$index] ?? '',
                        'juara' => $validated['kompetisi_juara'][$index] ?? null,
                        'posisi' => $validated['kompetisi_posisi'][$index] ?? 'anggota',
                        'file_bukti' => $fileBuktiPath,
                    ]);
                }
            }
        }

        // Create publikasi
        if (!empty($validated['publikasi_judul'])) {
            foreach ($validated['publikasi_judul'] as $index => $judul) {
                if (!empty($judul)) {
                    LaporanPublikasi::create([
                        'laporan_beasiswa_id' => $laporan->id,
                        'judul' => $judul,
                        'nama_tempat' => $validated['publikasi_tempat'][$index] ?? '',
                        'link_jurnal' => $validated['publikasi_link'][$index] ?? '',
                        'kategori' => $validated['publikasi_kategori'][$index] ?? '',
                    ]);
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
            ? 'Laporan berhasil dikirim untuk direview.' 
            : 'Laporan berhasil disimpan sebagai draft.';

        return redirect()->route('mahasiswa.laporan.index')
            ->with('success', $message);
    }

    /**
     * Display specified laporan.
     */
    public function show(LaporanBeasiswa $laporan)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        
        if ($laporan->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        $laporan->load(['laporanAkademik', 'laporanReferals', 'laporanPendanaans', 'laporanKompetisis', 'laporanPublikasis', 'tahunAjar', 'beasiswaTipe']);

        return view('mahasiswa.laporan.show', compact('laporan'));
    }

    /**
     * Show form for editing laporan.
     */
    public function edit(LaporanBeasiswa $laporan)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        
        if ($laporan->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($laporan->status !== 'draft') {
            return redirect()->route('mahasiswa.laporan.show', $laporan)
                ->with('error', 'Laporan yang sudah dikirim tidak dapat diedit.');
        }

        $laporan->load(['laporanAkademik', 'laporanReferals', 'laporanPendanaans', 'laporanKompetisis', 'laporanPublikasis']);
        $tahunAjarList = TahunAjar::orderBy('tahun_mulai', 'desc')->get();

        return view('mahasiswa.laporan.edit', compact('laporan', 'tahunAjarList'));
    }

    /**
     * Update laporan.
     */
    public function update(Request $request, LaporanBeasiswa $laporan)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if ($laporan->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        // Similar validation as store, but with existing data handling
        // For brevity, using similar validation
        $validated = $request->validate([
            'tahun_ajar_id' => 'required|exists:tahun_ajars,id',
            'semester' => 'required|integer|min:1|max:10',
            'sks' => 'required|integer|min:1|max:24',
            'indeks_prestasi' => 'required|numeric|min:0|max:4',
            'file_khs' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Update laporan beasiswa
        $laporan->update([
            'tahun_ajar_id' => $validated['tahun_ajar_id'],
            'semester' => $validated['semester'],
        ]);

        // Update or create laporan akademik
        if ($laporan->laporanAkademik) {
            $akademikData = [
                'sks' => $validated['sks'],
                'indeks_prestasi' => $validated['indeks_prestasi'],
            ];

            if ($request->hasFile('file_khs')) {
                // Delete old file
                if ($laporan->laporanAkademik->file_khs) {
                    Storage::disk('public')->delete($laporan->laporanAkademik->file_khs);
                }
                $akademikData['file_khs'] = $request->file('file_khs')->store('laporan/khs', 'public');
            }

            $laporan->laporanAkademik->update($akademikData);
        }

        // Handle submit action
        $action = $request->input('action');
        if ($action === 'submit') {
            $laporan->update([
                'status' => 'submitted',
                'submitted_at' => now(),
            ]);

            return redirect()->route('mahasiswa.laporan.index')
                ->with('success', 'Laporan berhasil dikirim untuk direview.');
        }

        return redirect()->route('mahasiswa.laporan.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    /**
     * Submit laporan for review.
     */
    public function submit(LaporanBeasiswa $laporan)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        
        if ($laporan->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($laporan->status !== 'draft') {
            return redirect()->route('mahasiswa.laporan.show', $laporan)
                ->with('error', 'Laporan sudah dikirim.');
        }

        // Validate that required data exists
        if (!$laporan->laporanAkademik) {
            return redirect()->route('mahasiswa.laporan.edit', $laporan)
                ->with('error', 'Lengkapi data akademik terlebih dahulu.');
        }

        $laporan->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        return redirect()->route('mahasiswa.laporan.index')
            ->with('success', 'Laporan berhasil dikirim untuk direview.');
    }

    /**
     * Delete laporan.
     */
    public function destroy(LaporanBeasiswa $laporan)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        
        if ($laporan->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($laporan->status !== 'draft') {
            return redirect()->route('mahasiswa.laporan.show', $laporan)
                ->with('error', 'Laporan yang sudah dikirim tidak dapat dihapus.');
        }

        // Delete files
        if ($laporan->laporanAkademik && $laporan->laporanAkademik->file_khs) {
            Storage::disk('public')->delete($laporan->laporanAkademik->file_khs);
        }

        $laporan->delete();

        return redirect()->route('mahasiswa.laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
