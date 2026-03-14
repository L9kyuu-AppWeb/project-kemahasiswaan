<?php

namespace App\Http\Controllers;

use App\Models\KompetisiMahasiswaDosen;
use App\Models\LombaKategori;
use App\Models\Mahasiswa;
use App\Models\JenisKegiatan;
use App\Models\DetailKegiatan;
use App\Models\RuangLingkup;
use App\Models\NilaiKegiatan;
use App\Rules\ValidCertificateDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KompetisiMahasiswaDosenController extends Controller
{
    // ==================== ADMIN METHODS ====================

    /**
     * Display list of kompetisi for admin.
     */
    public function adminIndex(Request $request)
    {
        $query = KompetisiMahasiswaDosen::with(['jenisKegiatan', 'detailKegiatan', 'ruangLingkup', 'mahasiswa'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $kompetisis = $query->paginate(15);

        return view('admin.kompetisi.index', compact('kompetisis'));
    }

    /**
     * Show detail kompetisi for admin.
     */
    public function adminShow(KompetisiMahasiswaDosen $kompetisi)
    {
        return view('admin.kompetisi.show', compact('kompetisi'));
    }

    /**
     * Show form to edit kompetisi for admin.
     */
    public function adminEdit(KompetisiMahasiswaDosen $kompetisi)
    {
        $kategoriList = LombaKategori::orderBy('nama')->get();
        $jenisKegiatans = JenisKegiatan::orderBy('nama')->get();
        $ruangLingkups = RuangLingkup::orderBy('nama')->get();
        return view('admin.kompetisi.edit', compact('kompetisi', 'kategoriList', 'jenisKegiatans', 'ruangLingkups'));
    }

    /**
     * Update kompetisi for admin.
     */
    public function adminUpdate(Request $request, KompetisiMahasiswaDosen $kompetisi)
    {
        $validated = $request->validate([
            'kategori' => 'required|string|max:100',
            'nama_kompetisi' => 'required|string|max:255',
            'nama_cabang' => 'nullable|string|max:255',
            'peringkat' => 'required|in:Juara 1,Juara 2,Juara 3,Harapan 1,Harapan 2,Harapan 3,Apresiasi Kejuaraan,Penghargaan Tambahan,Juara Umum,Peserta',
            'penyelenggara' => 'required|string|max:255',
            'jumlah_pt_negara_peserta' => 'nullable|string|max:100',
            'kepesertaan' => 'required|in:Individu,Kelompok',
            'bentuk' => 'required|in:Luring/Hibrida,Daring',
            'url_kompetisi' => 'nullable|url|max:500',
            'dokumen_sertifikat' => 'nullable|file|mimes:pdf|max:5120',
            'tanggal_sertifikat' => ['nullable', 'date', new ValidCertificateDate()],
            'foto_upp' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'dokumen_undangan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'dosen_id' => 'nullable|exists:dosens,id',
            'jenis_kegiatan_id' => 'nullable|exists:jenis_kegiatan,id',
            'detail_kegiatan_id' => 'nullable|exists:detail_kegiatan,id',
            'ruang_lingkup_id' => 'nullable|exists:ruang_lingkup,id',
            'nilai' => 'nullable|integer|min:0',
            'url_surat_tugas' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        // Handle file uploads
        if ($request->hasFile('dokumen_sertifikat')) {
            if ($kompetisi->dokumen_sertifikat) {
                Storage::disk('public')->delete($kompetisi->dokumen_sertifikat);
            }
            $validated['dokumen_sertifikat'] = $request->file('dokumen_sertifikat')->store('kompetisi/sertifikat', 'public');
        }

        if ($request->hasFile('foto_upp')) {
            if ($kompetisi->foto_upp) {
                Storage::disk('public')->delete($kompetisi->foto_upp);
            }
            $validated['foto_upp'] = $request->file('foto_upp')->store('kompetisi/foto_upp', 'public');
        }

        if ($request->hasFile('dokumen_undangan')) {
            if ($kompetisi->dokumen_undangan) {
                Storage::disk('public')->delete($kompetisi->dokumen_undangan);
            }
            $validated['dokumen_undangan'] = $request->file('dokumen_undangan')->store('kompetisi/undangan', 'public');
        }

        if ($request->hasFile('url_surat_tugas')) {
            if ($kompetisi->url_surat_tugas) {
                Storage::disk('public')->delete($kompetisi->url_surat_tugas);
            }
            $validated['url_surat_tugas'] = $request->file('url_surat_tugas')->store('kompetisi/surat_tugas', 'public');
        } else {
            unset($validated['url_surat_tugas']);
        }

        // Add kegiatan fields
        $kompetisi->jenis_kegiatan_id = $validated['jenis_kegiatan_id'];
        $kompetisi->detail_kegiatan_id = $validated['detail_kegiatan_id'];
        $kompetisi->ruang_lingkup_id = $validated['ruang_lingkup_id'];
        $kompetisi->nilai = $validated['nilai'] ?? 0;

        $kompetisi->update();

        return redirect()->route('admin.kompetisi.index')
            ->with('success', 'Data kompetisi berhasil diperbarui.');
    }

    /**
     * Delete kompetisi for admin.
     */
    public function adminDestroy(KompetisiMahasiswaDosen $kompetisi)
    {
        // Delete associated files
        if ($kompetisi->dokumen_sertifikat) {
            Storage::disk('public')->delete($kompetisi->dokumen_sertifikat);
        }
        if ($kompetisi->foto_upp) {
            Storage::disk('public')->delete($kompetisi->foto_upp);
        }
        if ($kompetisi->dokumen_undangan) {
            Storage::disk('public')->delete($kompetisi->dokumen_undangan);
        }
        if ($kompetisi->url_surat_tugas) {
            Storage::disk('public')->delete($kompetisi->url_surat_tugas);
        }

        $kompetisi->delete();

        return redirect()->route('admin.kompetisi.index')
            ->with('success', 'Data kompetisi berhasil dihapus.');
    }

    /**
     * Approve/Verify kompetisi.
     */
    public function adminApprove(Request $request, KompetisiMahasiswaDosen $kompetisi)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'keterangan_verifikasi' => 'nullable|string|max:500',
        ]);

        $kompetisi->update($validated);

        $message = $validated['status'] === 'approved' 
            ? 'Kompetisi berhasil disetujui.' 
            : 'Kompetisi ditolak.';

        return redirect()->route('admin.kompetisi.index')
            ->with('success', $message);
    }

    // ==================== MAHASISWA METHODS ====================

    /**
     * Display list of kompetisi for mahasiswa.
     */
    public function index()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $kompetisis = KompetisiMahasiswaDosen::where('mahasiswa_id', $mahasiswa->id)
            ->with(['jenisKegiatan', 'detailKegiatan', 'ruangLingkup'])
            ->latest()
            ->paginate(15);

        return view('mahasiswa.kompetisi.index', compact('kompetisis'));
    }

    /**
     * Show form to create new kompetisi.
     */
    public function create()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $kategoriList = LombaKategori::orderBy('nama')->get();
        
        // Filter jenis kegiatan hanya untuk kompetisi
        $jenisKegiatans = JenisKegiatan::where('nama', 'LIKE', '%Kompetisi%')
            ->orderBy('nama')
            ->get();
        
        $dosens = \App\Models\Dosen::orderBy('nama')->get();

        return view('mahasiswa.kompetisi.create', compact('mahasiswa', 'kategoriList', 'jenisKegiatans', 'dosens'));
    }

    /**
     * Store new kompetisi.
     */
    public function store(Request $request)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'kategori' => 'required|string|max:100',
            'nama_kompetisi' => 'required|string|max:255',
            'nama_cabang' => 'nullable|string|max:255',
            'peringkat' => 'required|in:Juara 1,Juara 2,Juara 3,Harapan 1,Harapan 2,Harapan 3,Apresiasi Kejuaraan,Penghargaan Tambahan,Juara Umum,Peserta',
            'penyelenggara' => 'required|string|max:255',
            'jumlah_pt_negara_peserta' => 'nullable|string|max:100',
            'kepesertaan' => 'required|in:Individu,Kelompok',
            'bentuk' => 'required|in:Luring/Hibrida,Daring',
            'url_kompetisi' => 'nullable|url|max:500',
            'dokumen_sertifikat' => 'required|file|mimes:pdf|max:5120',
            'tanggal_sertifikat' => ['nullable', 'date', new ValidCertificateDate()],
            'foto_upp' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'dokumen_undangan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'dosen_id' => 'nullable|exists:dosens,id',
            'url_surat_tugas' => 'nullable|file|mimes:pdf|max:5120',
            'jenis_kegiatan_id' => 'nullable|exists:jenis_kegiatan,id',
            'detail_kegiatan_id' => 'nullable|exists:detail_kegiatan,id',
            'ruang_lingkup_id' => 'nullable|exists:ruang_lingkup,id',
            'nilai' => 'nullable|integer|min:0',
        ]);

        // Upload files
        $dokumenSertifikatPath = $request->file('dokumen_sertifikat')->store('kompetisi/sertifikat', 'public');

        $fotoUppPath = null;
        if ($request->hasFile('foto_upp')) {
            $fotoUppPath = $request->file('foto_upp')->store('kompetisi/foto_upp', 'public');
        }

        $dokumenUndanganPath = null;
        if ($request->hasFile('dokumen_undangan')) {
            $dokumenUndanganPath = $request->file('dokumen_undangan')->store('kompetisi/undangan', 'public');
        }

        $urlSuratTugasPath = null;
        if ($request->hasFile('url_surat_tugas')) {
            $urlSuratTugasPath = $request->file('url_surat_tugas')->store('kompetisi/surat_tugas', 'public');
        }

        KompetisiMahasiswaDosen::create([
            'kategori' => $validated['kategori'],
            'jenis_kegiatan_id' => $validated['jenis_kegiatan_id'],
            'detail_kegiatan_id' => $validated['detail_kegiatan_id'],
            'ruang_lingkup_id' => $validated['ruang_lingkup_id'],
            'nilai' => $validated['nilai'] ?? 0,
            'nama_kompetisi' => $validated['nama_kompetisi'],
            'nama_cabang' => $validated['nama_cabang'],
            'peringkat' => $validated['peringkat'],
            'penyelenggara' => $validated['penyelenggara'],
            'jumlah_pt_negara_peserta' => $validated['jumlah_pt_negara_peserta'],
            'kepesertaan' => $validated['kepesertaan'],
            'bentuk' => $validated['bentuk'],
            'url_kompetisi' => $validated['url_kompetisi'],
            'dokumen_sertifikat' => $dokumenSertifikatPath,
            'tanggal_sertifikat' => $validated['tanggal_sertifikat'],
            'foto_upp' => $fotoUppPath,
            'dokumen_undangan' => $dokumenUndanganPath,
            'mahasiswa_id' => $mahasiswa->id,
            'dosen_id' => $validated['dosen_id'],
            'url_surat_tugas' => $urlSuratTugasPath,
            'status' => 'pending',
        ]);

        return redirect()->route('mahasiswa.kompetisi.index')
            ->with('success', 'Data kompetisi berhasil ditambahkan. Menunggu verifikasi admin.');
    }

    /**
     * Show detail kompetisi for mahasiswa.
     */
    public function show(KompetisiMahasiswaDosen $kompetisi)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Only allow viewing own data
        if ($kompetisi->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        return view('mahasiswa.kompetisi.show', compact('kompetisi'));
    }

    /**
     * Show form to edit kompetisi (only if pending).
     */
    public function edit(KompetisiMahasiswaDosen $kompetisi)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Only allow editing own data and only if pending
        if ($kompetisi->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($kompetisi->status !== 'pending') {
            return redirect()->route('mahasiswa.kompetisi.index')
                ->with('error', 'Data yang sudah diverifikasi tidak dapat diedit.');
        }

        $kategoriList = LombaKategori::orderBy('nama')->get();
        $jenisKegiatans = JenisKegiatan::orderBy('id')->get();
        $dosens = \App\Models\Dosen::orderBy('nama')->get();

        return view('mahasiswa.kompetisi.edit', compact('kompetisi', 'kategoriList', 'jenisKegiatans', 'dosens'));
    }

    /**
     * Update kompetisi (only if pending).
     */
    public function update(Request $request, KompetisiMahasiswaDosen $kompetisi)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Only allow editing own data and only if pending
        if ($kompetisi->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($kompetisi->status !== 'pending') {
            return redirect()->route('mahasiswa.kompetisi.index')
                ->with('error', 'Data yang sudah diverifikasi tidak dapat diedit.');
        }

        $validated = $request->validate([
            'kategori' => 'required|string|max:100',
            'nama_kompetisi' => 'required|string|max:255',
            'nama_cabang' => 'nullable|string|max:255',
            'peringkat' => 'required|in:Juara 1,Juara 2,Juara 3,Harapan 1,Harapan 2,Harapan 3,Apresiasi Kejuaraan,Penghargaan Tambahan,Juara Umum,Peserta',
            'penyelenggara' => 'required|string|max:255',
            'jumlah_pt_negara_peserta' => 'nullable|string|max:100',
            'kepesertaan' => 'required|in:Individu,Kelompok',
            'bentuk' => 'required|in:Luring/Hibrida,Daring',
            'url_kompetisi' => 'nullable|url|max:500',
            'dokumen_sertifikat' => 'nullable|file|mimes:pdf|max:5120',
            'tanggal_sertifikat' => ['nullable', 'date', new ValidCertificateDate()],
            'foto_upp' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'dokumen_undangan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'dosen_id' => 'nullable|exists:dosens,id',
            'url_surat_tugas' => 'nullable|file|mimes:pdf|max:5120',
            'jenis_kegiatan_id' => 'nullable|exists:jenis_kegiatan,id',
            'detail_kegiatan_id' => 'nullable|exists:detail_kegiatan,id',
            'ruang_lingkup_id' => 'nullable|exists:ruang_lingkup,id',
            'nilai' => 'nullable|integer|min:0',
        ]);

        // Handle file uploads
        if ($request->hasFile('dokumen_sertifikat')) {
            if ($kompetisi->dokumen_sertifikat) {
                Storage::disk('public')->delete($kompetisi->dokumen_sertifikat);
            }
            $validated['dokumen_sertifikat'] = $request->file('dokumen_sertifikat')->store('kompetisi/sertifikat', 'public');
        } else {
            unset($validated['dokumen_sertifikat']);
        }

        if ($request->hasFile('foto_upp')) {
            if ($kompetisi->foto_upp) {
                Storage::disk('public')->delete($kompetisi->foto_upp);
            }
            $validated['foto_upp'] = $request->file('foto_upp')->store('kompetisi/foto_upp', 'public');
        } else {
            unset($validated['foto_upp']);
        }

        if ($request->hasFile('dokumen_undangan')) {
            if ($kompetisi->dokumen_undangan) {
                Storage::disk('public')->delete($kompetisi->dokumen_undangan);
            }
            $validated['dokumen_undangan'] = $request->file('dokumen_undangan')->store('kompetisi/undangan', 'public');
        } else {
            unset($validated['dokumen_undangan']);
        }

        if ($request->hasFile('url_surat_tugas')) {
            if ($kompetisi->url_surat_tugas) {
                Storage::disk('public')->delete($kompetisi->url_surat_tugas);
            }
            $validated['url_surat_tugas'] = $request->file('url_surat_tugas')->store('kompetisi/surat_tugas', 'public');
        } else {
            unset($validated['url_surat_tugas']);
        }

        // Add kegiatan fields
        $kompetisi->jenis_kegiatan_id = $validated['jenis_kegiatan_id'];
        $kompetisi->detail_kegiatan_id = $validated['detail_kegiatan_id'];
        $kompetisi->ruang_lingkup_id = $validated['ruang_lingkup_id'];
        $kompetisi->nilai = $validated['nilai'] ?? 0;

        $kompetisi->update();

        return redirect()->route('mahasiswa.kompetisi.index')
            ->with('success', 'Data kompetisi berhasil diperbarui.');
    }

    /**
     * Delete kompetisi (only if pending).
     */
    public function destroy(KompetisiMahasiswaDosen $kompetisi)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Only allow deleting own data and only if pending
        if ($kompetisi->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($kompetisi->status !== 'pending') {
            return redirect()->route('mahasiswa.kompetisi.index')
                ->with('error', 'Data yang sudah diverifikasi tidak dapat dihapus.');
        }

        // Delete associated files
        if ($kompetisi->dokumen_sertifikat) {
            Storage::disk('public')->delete($kompetisi->dokumen_sertifikat);
        }
        if ($kompetisi->foto_upp) {
            Storage::disk('public')->delete($kompetisi->foto_upp);
        }
        if ($kompetisi->dokumen_undangan) {
            Storage::disk('public')->delete($kompetisi->dokumen_undangan);
        }
        if ($kompetisi->url_surat_tugas) {
            Storage::disk('public')->delete($kompetisi->url_surat_tugas);
        }

        $kompetisi->delete();

        return redirect()->route('mahasiswa.kompetisi.index')
            ->with('success', 'Data kompetisi berhasil dihapus.');
    }

    /**
     * Get nilai based on jenis, detail, and ruang lingkup.
     */
    public function getNilai(Request $request)
    {
        $nilai = NilaiKegiatan::where('jenis_id', $request->jenis_id)
            ->where('detail_id', $request->detail_id)
            ->where('ruang_id', $request->ruang_id)
            ->first();

        return response()->json([
            'nilai' => $nilai ? $nilai->nilai : 0,
        ]);
    }

    /**
     * Get details based on jenis_id.
     */
    public function getDetails(Request $request)
    {
        $details = DetailKegiatan::where('jenis_id', $request->jenis_id)
            ->orderBy('nama')
            ->get();

        return response()->json($details);
    }
}
