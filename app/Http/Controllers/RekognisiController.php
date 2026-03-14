<?php

namespace App\Http\Controllers;

use App\Models\Rekognisi;
use App\Models\JenisRekognisi;
use App\Models\JenisKegiatan;
use App\Models\DetailKegiatan;
use App\Models\RuangLingkup;
use App\Models\NilaiKegiatan;
use App\Rules\ValidCertificateDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RekognisiController extends Controller
{
    // ==================== ADMIN METHODS ====================

    /**
     * Display list of rekognisi for admin.
     */
    public function adminIndex(Request $request)
    {
        $query = Rekognisi::with(['jenisRekognisi', 'jenisKegiatan', 'detailKegiatan', 'ruangLingkup', 'mahasiswa'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $rekognisis = $query->paginate(15);

        return view('admin.rekognisi.index', compact('rekognisis'));
    }

    /**
     * Show detail rekognisi for admin.
     */
    public function adminShow(Rekognisi $rekognisi)
    {
        return view('admin.rekognisi.show', compact('rekognisi'));
    }

    /**
     * Show form to edit rekognisi for admin.
     */
    public function adminEdit(Rekognisi $rekognisi)
    {
        $jenisRekognisiList = JenisRekognisi::orderBy('nama')->get();
        $jenisKegiatans = JenisKegiatan::orderBy('nama')->get();
        $ruangLingkups = RuangLingkup::orderBy('nama')->get();
        return view('admin.rekognisi.edit', compact('rekognisi', 'jenisRekognisiList', 'jenisKegiatans', 'ruangLingkups'));
    }

    /**
     * Update rekognisi for admin.
     */
    public function adminUpdate(Request $request, Rekognisi $rekognisi)
    {
        $validated = $request->validate([
            'nama_rekognisi' => 'required|string|max:255',
            'jenis_rekognisi_id' => 'required|exists:jenis_rekognisi,id',
            'nama_penyelenggara' => 'required|string|max:255',
            'url_rekognisi' => 'nullable|url|max:500',
            'dokumen_sertifikat' => 'nullable|file|mimes:pdf|max:5120',
            'foto_kegiatan' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'dokumen_bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'surat_tugas' => 'nullable|file|mimes:pdf|max:5120',
            'tanggal_sertifikat' => ['nullable', 'date', new ValidCertificateDate()],
            'dosen_id' => 'nullable|exists:dosens,id',
            'jenis_kegiatan_id' => 'nullable|exists:jenis_kegiatan,id',
            'detail_kegiatan_id' => 'nullable|exists:detail_kegiatan,id',
            'ruang_lingkup_id' => 'nullable|exists:ruang_lingkup,id',
            'nilai' => 'nullable|integer|min:0',
        ]);

        // Handle file uploads
        if ($request->hasFile('dokumen_sertifikat')) {
            if ($rekognisi->dokumen_sertifikat) {
                Storage::disk('public')->delete($rekognisi->dokumen_sertifikat);
            }
            $validated['dokumen_sertifikat'] = $request->file('dokumen_sertifikat')->store('rekognisi/sertifikat', 'public');
        }

        if ($request->hasFile('foto_kegiatan')) {
            if ($rekognisi->foto_kegiatan) {
                Storage::disk('public')->delete($rekognisi->foto_kegiatan);
            }
            $validated['foto_kegiatan'] = $request->file('foto_kegiatan')->store('rekognisi/foto_kegiatan', 'public');
        }

        if ($request->hasFile('dokumen_bukti')) {
            if ($rekognisi->dokumen_bukti) {
                Storage::disk('public')->delete($rekognisi->dokumen_bukti);
            }
            $validated['dokumen_bukti'] = $request->file('dokumen_bukti')->store('rekognisi/dokumen_bukti', 'public');
        }

        if ($request->hasFile('surat_tugas')) {
            if ($rekognisi->surat_tugas) {
                Storage::disk('public')->delete($rekognisi->surat_tugas);
            }
            $validated['surat_tugas'] = $request->file('surat_tugas')->store('rekognisi/surat_tugas', 'public');
        }

        // Add kegiatan fields
        $rekognisi->jenis_kegiatan_id = $validated['jenis_kegiatan_id'];
        $rekognisi->detail_kegiatan_id = $validated['detail_kegiatan_id'];
        $rekognisi->ruang_lingkup_id = $validated['ruang_lingkup_id'];
        $rekognisi->nilai = $validated['nilai'] ?? 0;

        $rekognisi->update($validated);

        return redirect()->route('admin.rekognisi.index')
            ->with('success', 'Data rekognisi berhasil diperbarui.');
    }

    /**
     * Delete rekognisi for admin.
     */
    public function adminDestroy(Rekognisi $rekognisi)
    {
        // Delete associated files
        if ($rekognisi->dokumen_sertifikat) {
            Storage::disk('public')->delete($rekognisi->dokumen_sertifikat);
        }
        if ($rekognisi->foto_kegiatan) {
            Storage::disk('public')->delete($rekognisi->foto_kegiatan);
        }
        if ($rekognisi->dokumen_bukti) {
            Storage::disk('public')->delete($rekognisi->dokumen_bukti);
        }
        if ($rekognisi->surat_tugas) {
            Storage::disk('public')->delete($rekognisi->surat_tugas);
        }

        $rekognisi->delete();

        return redirect()->route('admin.rekognisi.index')
            ->with('success', 'Data rekognisi berhasil dihapus.');
    }

    /**
     * Approve/Verify rekognisi.
     */
    public function adminApprove(Request $request, Rekognisi $rekognisi)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'keterangan_verifikasi' => 'nullable|string|max:500',
        ]);

        $rekognisi->update($validated);

        $message = $validated['status'] === 'approved'
            ? 'Rekognisi berhasil disetujui.'
            : 'Rekognisi ditolak.';

        return redirect()->route('admin.rekognisi.index')
            ->with('success', $message);
    }

    // ==================== MAHASISWA METHODS ====================

    /**
     * Display list of rekognisi for mahasiswa.
     */
    public function index()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $rekognisis = Rekognisi::where('mahasiswa_id', $mahasiswa->id)
            ->with(['jenisRekognisi', 'jenisKegiatan', 'detailKegiatan', 'ruangLingkup', 'mahasiswa'])
            ->latest()
            ->paginate(15);

        return view('mahasiswa.rekognisi.index', compact('rekognisis'));
    }

    /**
     * Show panduan/referensi jenis rekognisi untuk mahasiswa.
     */
    public function panduan()
    {
        $jenisRekognisiList = JenisRekognisi::orderBy('nama')->get();
        return view('mahasiswa.rekognisi.panduan', compact('jenisRekognisiList'));
    }

    /**
     * Show form to create new rekognisi.
     */
    public function create()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $jenisRekognisiList = JenisRekognisi::orderBy('nama')->get();
        $jenisKegiatans = JenisKegiatan::orderBy('id')->get();
        $dosens = \App\Models\Dosen::orderBy('nama')->get();

        return view('mahasiswa.rekognisi.create', compact('mahasiswa', 'jenisRekognisiList', 'jenisKegiatans', 'dosens'));
    }

    /**
     * Store new rekognisi.
     */
    public function store(Request $request)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'nama_rekognisi' => 'required|string|max:255',
            'jenis_rekognisi_id' => 'required|exists:jenis_rekognisi,id',
            'nama_penyelenggara' => 'required|string|max:255',
            'url_rekognisi' => 'nullable|url|max:500',
            'dokumen_sertifikat' => 'required|file|mimes:pdf|max:5120',
            'foto_kegiatan' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'dokumen_bukti' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'surat_tugas' => 'nullable|file|mimes:pdf|max:5120',
            'tanggal_sertifikat' => ['nullable', 'date', new ValidCertificateDate()],
            'dosen_id' => 'nullable|exists:dosens,id',
            'jenis_kegiatan_id' => 'nullable|exists:jenis_kegiatan,id',
            'detail_kegiatan_id' => 'nullable|exists:detail_kegiatan,id',
            'ruang_lingkup_id' => 'nullable|exists:ruang_lingkup,id',
            'nilai' => 'nullable|integer|min:0',
        ]);

        // Upload files
        $dokumenSertifikatPath = $request->file('dokumen_sertifikat')->store('rekognisi/sertifikat', 'public');

        $fotoKegiatanPath = null;
        if ($request->hasFile('foto_kegiatan')) {
            $fotoKegiatanPath = $request->file('foto_kegiatan')->store('rekognisi/foto_kegiatan', 'public');
        }

        $dokumenBuktiPath = $request->file('dokumen_bukti')->store('rekognisi/dokumen_bukti', 'public');

        $suratTugasPath = null;
        if ($request->hasFile('surat_tugas')) {
            $suratTugasPath = $request->file('surat_tugas')->store('rekognisi/surat_tugas', 'public');
        }

        Rekognisi::create([
            'nama_rekognisi' => $validated['nama_rekognisi'],
            'jenis_rekognisi_id' => $validated['jenis_rekognisi_id'],
            'jenis_kegiatan_id' => $validated['jenis_kegiatan_id'],
            'detail_kegiatan_id' => $validated['detail_kegiatan_id'],
            'ruang_lingkup_id' => $validated['ruang_lingkup_id'],
            'nilai' => $validated['nilai'] ?? 0,
            'nama_penyelenggara' => $validated['nama_penyelenggara'],
            'url_rekognisi' => $validated['url_rekognisi'],
            'dokumen_sertifikat' => $dokumenSertifikatPath,
            'foto_kegiatan' => $fotoKegiatanPath,
            'dokumen_bukti' => $dokumenBuktiPath,
            'surat_tugas' => $suratTugasPath,
            'tanggal_sertifikat' => $validated['tanggal_sertifikat'],
            'mahasiswa_id' => $mahasiswa->id,
            'dosen_id' => $validated['dosen_id'],
            'status' => 'pending',
        ]);

        return redirect()->route('mahasiswa.rekognisi.index')
            ->with('success', 'Data rekognisi berhasil ditambahkan. Menunggu verifikasi admin.');
    }

    /**
     * Show detail rekognisi for mahasiswa.
     */
    public function show(Rekognisi $rekognisi)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Only allow viewing own data
        if ($rekognisi->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        return view('mahasiswa.rekognisi.show', compact('rekognisi'));
    }

    /**
     * Show form to edit rekognisi (only if pending).
     */
    public function edit(Rekognisi $rekognisi)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Only allow editing own data and only if pending
        if ($rekognisi->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($rekognisi->status !== 'pending') {
            return redirect()->route('mahasiswa.rekognisi.index')
                ->with('error', 'Data yang sudah diverifikasi tidak dapat diedit.');
        }

        $jenisRekognisiList = JenisRekognisi::orderBy('nama')->get();
        $jenisKegiatans = JenisKegiatan::orderBy('id')->get();
        $dosens = \App\Models\Dosen::orderBy('nama')->get();

        return view('mahasiswa.rekognisi.edit', compact('rekognisi', 'jenisRekognisiList', 'jenisKegiatans', 'dosens'));
    }

    /**
     * Update rekognisi (only if pending).
     */
    public function update(Request $request, Rekognisi $rekognisi)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Only allow editing own data and only if pending
        if ($rekognisi->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($rekognisi->status !== 'pending') {
            return redirect()->route('mahasiswa.rekognisi.index')
                ->with('error', 'Data yang sudah diverifikasi tidak dapat diedit.');
        }

        $validated = $request->validate([
            'nama_rekognisi' => 'required|string|max:255',
            'jenis_rekognisi_id' => 'required|exists:jenis_rekognisi,id',
            'nama_penyelenggara' => 'required|string|max:255',
            'url_rekognisi' => 'nullable|url|max:500',
            'dokumen_sertifikat' => 'nullable|file|mimes:pdf|max:5120',
            'foto_kegiatan' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'dokumen_bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'surat_tugas' => 'nullable|file|mimes:pdf|max:5120',
            'tanggal_sertifikat' => ['nullable', 'date', new ValidCertificateDate()],
            'dosen_id' => 'nullable|exists:dosens,id',
            'jenis_kegiatan_id' => 'nullable|exists:jenis_kegiatan,id',
            'detail_kegiatan_id' => 'nullable|exists:detail_kegiatan,id',
            'ruang_lingkup_id' => 'nullable|exists:ruang_lingkup,id',
            'nilai' => 'nullable|integer|min:0',
        ]);

        // Handle file uploads
        if ($request->hasFile('dokumen_sertifikat')) {
            if ($rekognisi->dokumen_sertifikat) {
                Storage::disk('public')->delete($rekognisi->dokumen_sertifikat);
            }
            $validated['dokumen_sertifikat'] = $request->file('dokumen_sertifikat')->store('rekognisi/sertifikat', 'public');
        } else {
            unset($validated['dokumen_sertifikat']);
        }

        if ($request->hasFile('foto_kegiatan')) {
            if ($rekognisi->foto_kegiatan) {
                Storage::disk('public')->delete($rekognisi->foto_kegiatan);
            }
            $validated['foto_kegiatan'] = $request->file('foto_kegiatan')->store('rekognisi/foto_kegiatan', 'public');
        } else {
            unset($validated['foto_kegiatan']);
        }

        if ($request->hasFile('dokumen_bukti')) {
            if ($rekognisi->dokumen_bukti) {
                Storage::disk('public')->delete($rekognisi->dokumen_bukti);
            }
            $validated['dokumen_bukti'] = $request->file('dokumen_bukti')->store('rekognisi/dokumen_bukti', 'public');
        } else {
            unset($validated['dokumen_bukti']);
        }

        if ($request->hasFile('surat_tugas')) {
            if ($rekognisi->surat_tugas) {
                Storage::disk('public')->delete($rekognisi->surat_tugas);
            }
            $validated['surat_tugas'] = $request->file('surat_tugas')->store('rekognisi/surat_tugas', 'public');
        } else {
            unset($validated['surat_tugas']);
        }

        // Add kegiatan fields
        $rekognisi->jenis_kegiatan_id = $validated['jenis_kegiatan_id'];
        $rekognisi->detail_kegiatan_id = $validated['detail_kegiatan_id'];
        $rekognisi->ruang_lingkup_id = $validated['ruang_lingkup_id'];
        $rekognisi->nilai = $validated['nilai'] ?? 0;

        $rekognisi->update($validated);

        return redirect()->route('mahasiswa.rekognisi.index')
            ->with('success', 'Data rekognisi berhasil diperbarui.');
    }

    /**
     * Delete rekognisi (only if pending).
     */
    public function destroy(Rekognisi $rekognisi)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Only allow deleting own data and only if pending
        if ($rekognisi->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($rekognisi->status !== 'pending') {
            return redirect()->route('mahasiswa.rekognisi.index')
                ->with('error', 'Data yang sudah diverifikasi tidak dapat dihapus.');
        }

        // Delete associated files
        if ($rekognisi->dokumen_sertifikat) {
            Storage::disk('public')->delete($rekognisi->dokumen_sertifikat);
        }
        if ($rekognisi->foto_kegiatan) {
            Storage::disk('public')->delete($rekognisi->foto_kegiatan);
        }
        if ($rekognisi->dokumen_bukti) {
            Storage::disk('public')->delete($rekognisi->dokumen_bukti);
        }
        if ($rekognisi->surat_tugas) {
            Storage::disk('public')->delete($rekognisi->surat_tugas);
        }

        $rekognisi->delete();

        return redirect()->route('mahasiswa.rekognisi.index')
            ->with('success', 'Data rekognisi berhasil dihapus.');
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
