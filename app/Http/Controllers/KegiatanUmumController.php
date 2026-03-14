<?php

namespace App\Http\Controllers;

use App\Models\KegiatanUmum;
use App\Models\KategoriKegiatanUmum;
use App\Models\JenisKegiatan;
use App\Models\DetailKegiatan;
use App\Models\RuangLingkup;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Rules\ValidCertificateDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KegiatanUmumController extends Controller
{
    // ==================== ADMIN METHODS ====================

    /**
     * Display list of kegiatan umum for admin.
     */
    public function adminIndex(Request $request)
    {
        $query = KegiatanUmum::with(['mahasiswa', 'jenisKegiatan', 'detailKegiatan', 'ruangLingkup', 'dosen'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $kegiatans = $query->paginate(15);
        $kategoriList = KategoriKegiatanUmum::orderBy('nama_kategori')->get();

        return view('admin.kegiatan-umum.index', compact('kegiatans', 'kategoriList'));
    }

    /**
     * Show detail kegiatan umum for admin.
     */
    public function adminShow(KegiatanUmum $kegiatanUmum)
    {
        return view('admin.kegiatan-umum.show', compact('kegiatanUmum'));
    }

    /**
     * Approve/Reject kegiatan umum for admin.
     */
    public function adminApprove(Request $request, KegiatanUmum $kegiatanUmum)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'keterangan_verifikasi' => 'nullable|string|max:1000',
        ]);

        $kegiatanUmum->update($validated);

        $message = $validated['status'] === 'approved' 
            ? 'Kegiatan umum berhasil disetujui.' 
            : 'Kegiatan umum ditolak.';

        return redirect()->route('admin.kegiatan-umum.index')
            ->with('success', $message);
    }

    /**
     * Delete kegiatan umum for admin.
     */
    public function adminDestroy(KegiatanUmum $kegiatanUmum)
    {
        if ($kegiatanUmum->dokumen_sertifikat) {
            Storage::disk('public')->delete($kegiatanUmum->dokumen_sertifikat);
        }

        $kegiatanUmum->delete();

        return redirect()->route('admin.kegiatan-umum.index')
            ->with('success', 'Kegiatan umum berhasil dihapus.');
    }

    // ==================== MAHASISWA METHODS ====================

    /**
     * Display list of kegiatan umum for mahasiswa.
     */
    public function index()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $kegiatans = KegiatanUmum::where('mahasiswa_id', $mahasiswa->id)
            ->with(['jenisKegiatan', 'detailKegiatan', 'ruangLingkup'])
            ->latest()
            ->paginate(15);

        return view('mahasiswa.kegiatan-umum.index', compact('kegiatans'));
    }

    /**
     * Show form to create new kegiatan umum.
     */
    public function create()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $kategoriList = KategoriKegiatanUmum::orderBy('nama_kategori')->get();
        $jenisKegiatans = JenisKegiatan::orderBy('nama')->get();
        $dosens = Dosen::orderBy('nama')->get();

        return view('mahasiswa.kegiatan-umum.create', compact('mahasiswa', 'kategoriList', 'jenisKegiatans', 'dosens'));
    }

    /**
     * Store new kegiatan umum.
     */
    public function store(Request $request)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'kategori' => 'required|string|max:100',
            'jenis_kegiatan_id' => 'nullable|exists:jenis_kegiatan,id',
            'detail_kegiatan_id' => 'nullable|exists:detail_kegiatan,id',
            'ruang_lingkup_id' => 'nullable|exists:ruang_lingkup,id',
            'nilai' => 'nullable|integer|min:0',
            'nama_kompetisi' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'url_kegiatan' => 'nullable|url|max:500',
            'dokumen_sertifikat' => 'required|file|mimes:pdf|max:5120',
            'tanggal_sertifikat' => ['nullable', 'date', new ValidCertificateDate()],
            'dosen_id' => 'nullable|exists:dosens,id',
            'url_surat_tugas' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $dokumenSertifikatPath = $request->file('dokumen_sertifikat')->store('kegiatan_umum/sertifikat', 'public');

        $urlSuratTugasPath = null;
        if ($request->hasFile('url_surat_tugas')) {
            $urlSuratTugasPath = $request->file('url_surat_tugas')->store('kegiatan_umum/surat_tugas', 'public');
        }

        KegiatanUmum::create([
            'kategori' => $validated['kategori'],
            'jenis_kegiatan_id' => $validated['jenis_kegiatan_id'],
            'detail_kegiatan_id' => $validated['detail_kegiatan_id'],
            'ruang_lingkup_id' => $validated['ruang_lingkup_id'],
            'nilai' => $validated['nilai'] ?? 0,
            'nama_kompetisi' => $validated['nama_kompetisi'],
            'penyelenggara' => $validated['penyelenggara'],
            'url_kegiatan' => $validated['url_kegiatan'],
            'dokumen_sertifikat' => $dokumenSertifikatPath,
            'tanggal_sertifikat' => $validated['tanggal_sertifikat'],
            'mahasiswa_id' => $mahasiswa->id,
            'dosen_id' => $validated['dosen_id'],
            'url_surat_tugas' => $urlSuratTugasPath,
            'status' => 'pending',
        ]);

        return redirect()->route('mahasiswa.kegiatan-umum.index')
            ->with('success', 'Kegiatan umum berhasil ditambahkan. Menunggu verifikasi admin.');
    }

    /**
     * Show detail kegiatan umum for mahasiswa.
     */
    public function show(KegiatanUmum $kegiatanUmum)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if ($kegiatanUmum->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        return view('mahasiswa.kegiatan-umum.show', compact('kegiatanUmum'));
    }

    /**
     * Show form to edit kegiatan umum.
     */
    public function edit(KegiatanUmum $kegiatanUmum)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if ($kegiatanUmum->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($kegiatanUmum->status !== 'pending') {
            return redirect()->route('mahasiswa.kegiatan-umum.index')
                ->with('error', 'Data yang sudah diverifikasi tidak dapat diedit.');
        }

        $kategoriList = KategoriKegiatanUmum::orderBy('nama_kategori')->get();
        $jenisKegiatans = JenisKegiatan::orderBy('nama')->get();
        $dosens = Dosen::orderBy('nama')->get();

        return view('mahasiswa.kegiatan-umum.edit', compact('kegiatanUmum', 'kategoriList', 'jenisKegiatans', 'dosens'));
    }

    /**
     * Update kegiatan umum.
     */
    public function update(Request $request, KegiatanUmum $kegiatanUmum)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if ($kegiatanUmum->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($kegiatanUmum->status !== 'pending') {
            return redirect()->route('mahasiswa.kegiatan-umum.index')
                ->with('error', 'Data yang sudah diverifikasi tidak dapat diedit.');
        }

        $validated = $request->validate([
            'kategori' => 'required|string|max:100',
            'jenis_kegiatan_id' => 'nullable|exists:jenis_kegiatan,id',
            'detail_kegiatan_id' => 'nullable|exists:detail_kegiatan,id',
            'ruang_lingkup_id' => 'nullable|exists:ruang_lingkup,id',
            'nilai' => 'nullable|integer|min:0',
            'nama_kompetisi' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'url_kegiatan' => 'nullable|url|max:500',
            'dokumen_sertifikat' => 'nullable|file|mimes:pdf|max:5120',
            'tanggal_sertifikat' => ['nullable', 'date', new ValidCertificateDate()],
            'dosen_id' => 'nullable|exists:dosens,id',
            'url_surat_tugas' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('dokumen_sertifikat')) {
            if ($kegiatanUmum->dokumen_sertifikat) {
                Storage::disk('public')->delete($kegiatanUmum->dokumen_sertifikat);
            }
            $validated['dokumen_sertifikat'] = $request->file('dokumen_sertifikat')->store('kegiatan_umum/sertifikat', 'public');
        } else {
            unset($validated['dokumen_sertifikat']);
        }

        if ($request->hasFile('url_surat_tugas')) {
            if ($kegiatanUmum->url_surat_tugas) {
                Storage::disk('public')->delete($kegiatanUmum->url_surat_tugas);
            }
            $validated['url_surat_tugas'] = $request->file('url_surat_tugas')->store('kegiatan_umum/surat_tugas', 'public');
        } else {
            unset($validated['url_surat_tugas']);
        }

        $kegiatanUmum->update($validated);

        return redirect()->route('mahasiswa.kegiatan-umum.index')
            ->with('success', 'Kegiatan umum berhasil diperbarui.');
    }

    /**
     * Delete kegiatan umum for mahasiswa.
     */
    public function destroy(KegiatanUmum $kegiatanUmum)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if ($kegiatanUmum->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($kegiatanUmum->status !== 'pending') {
            return redirect()->route('mahasiswa.kegiatan-umum.index')
                ->with('error', 'Data yang sudah diverifikasi tidak dapat dihapus.');
        }

        if ($kegiatanUmum->dokumen_sertifikat) {
            Storage::disk('public')->delete($kegiatanUmum->dokumen_sertifikat);
        }
        if ($kegiatanUmum->url_surat_tugas) {
            Storage::disk('public')->delete($kegiatanUmum->url_surat_tugas);
        }

        $kegiatanUmum->delete();

        return redirect()->route('mahasiswa.kegiatan-umum.index')
            ->with('success', 'Kegiatan umum berhasil dihapus.');
    }

    /**
     * Get details based on jenis_id (AJAX).
     */
    public function getDetails(Request $request)
    {
        $details = DetailKegiatan::where('jenis_id', $request->jenis_id)
            ->orderBy('nama')
            ->get();

        return response()->json($details);
    }

    /**
     * Get nilai based on jenis, detail, and ruang lingkup (AJAX).
     */
    public function getNilai(Request $request)
    {
        $nilai = \App\Models\NilaiKegiatan::where('jenis_id', $request->jenis_id)
            ->where('detail_id', $request->detail_id)
            ->where('ruang_id', $request->ruang_id)
            ->first();

        return response()->json([
            'nilai' => $nilai ? $nilai->nilai : 0,
        ]);
    }
}
