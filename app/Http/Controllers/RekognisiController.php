<?php

namespace App\Http\Controllers;

use App\Models\Rekognisi;
use App\Models\JenisRekognisi;
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
        $query = Rekognisi::with(['jenisRekognisi'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
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
        return view('admin.rekognisi.edit', compact('rekognisi', 'jenisRekognisiList'));
    }

    /**
     * Update rekognisi for admin.
     */
    public function adminUpdate(Request $request, Rekognisi $rekognisi)
    {
        $validated = $request->validate([
            'level' => 'required|in:Provinsi,Nasional,Internasional',
            'nama_rekognisi' => 'required|string|max:255',
            'jenis_rekognisi_id' => 'required|exists:jenis_rekognisi,id',
            'nama_penyelenggara' => 'required|string|max:255',
            'url_rekognisi' => 'nullable|url|max:500',
            'dokumen_sertifikat' => 'nullable|file|mimes:pdf|max:5120',
            'foto_kegiatan' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'dokumen_bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'surat_tugas' => 'nullable|file|mimes:pdf|max:5120',
            'tanggal_sertifikat' => 'nullable|date',
            'nim' => 'required|string|max:20',
            'nama_mahasiswa' => 'required|string|max:150',
            'nidn_nuptk' => 'nullable|string|max:30',
            'nama_dosen' => 'nullable|string|max:150',
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

        $rekognisis = Rekognisi::where('nim', $mahasiswa->nim)
            ->with(['jenisRekognisi'])
            ->latest()
            ->paginate(15);

        return view('mahasiswa.rekognisi.index', compact('rekognisis'));
    }

    /**
     * Show form to create new rekognisi.
     */
    public function create()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $jenisRekognisiList = JenisRekognisi::orderBy('nama')->get();

        return view('mahasiswa.rekognisi.create', compact('mahasiswa', 'jenisRekognisiList'));
    }

    /**
     * Store new rekognisi.
     */
    public function store(Request $request)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'level' => 'required|in:Provinsi,Nasional,Internasional',
            'nama_rekognisi' => 'required|string|max:255',
            'jenis_rekognisi_id' => 'required|exists:jenis_rekognisi,id',
            'nama_penyelenggara' => 'required|string|max:255',
            'url_rekognisi' => 'nullable|url|max:500',
            'dokumen_sertifikat' => 'required|file|mimes:pdf|max:5120',
            'foto_kegiatan' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'dokumen_bukti' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'surat_tugas' => 'nullable|file|mimes:pdf|max:5120',
            'tanggal_sertifikat' => 'nullable|date',
            'nidn_nuptk' => 'nullable|string|max:30',
            'nama_dosen' => 'nullable|string|max:150',
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
            'level' => $validated['level'],
            'nama_rekognisi' => $validated['nama_rekognisi'],
            'jenis_rekognisi_id' => $validated['jenis_rekognisi_id'],
            'nama_penyelenggara' => $validated['nama_penyelenggara'],
            'url_rekognisi' => $validated['url_rekognisi'],
            'dokumen_sertifikat' => $dokumenSertifikatPath,
            'foto_kegiatan' => $fotoKegiatanPath,
            'dokumen_bukti' => $dokumenBuktiPath,
            'surat_tugas' => $suratTugasPath,
            'tanggal_sertifikat' => $validated['tanggal_sertifikat'],
            'nim' => $mahasiswa->nim,
            'nama_mahasiswa' => $mahasiswa->nama,
            'nidn_nuptk' => $validated['nidn_nuptk'],
            'nama_dosen' => $validated['nama_dosen'],
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
        if ($rekognisi->nim !== $mahasiswa->nim) {
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
        if ($rekognisi->nim !== $mahasiswa->nim) {
            abort(403);
        }

        if ($rekognisi->status !== 'pending') {
            return redirect()->route('mahasiswa.rekognisi.index')
                ->with('error', 'Data yang sudah diverifikasi tidak dapat diedit.');
        }

        $jenisRekognisiList = JenisRekognisi::orderBy('nama')->get();

        return view('mahasiswa.rekognisi.edit', compact('rekognisi', 'jenisRekognisiList'));
    }

    /**
     * Update rekognisi (only if pending).
     */
    public function update(Request $request, Rekognisi $rekognisi)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Only allow editing own data and only if pending
        if ($rekognisi->nim !== $mahasiswa->nim) {
            abort(403);
        }

        if ($rekognisi->status !== 'pending') {
            return redirect()->route('mahasiswa.rekognisi.index')
                ->with('error', 'Data yang sudah diverifikasi tidak dapat diedit.');
        }

        $validated = $request->validate([
            'level' => 'required|in:Provinsi,Nasional,Internasional',
            'nama_rekognisi' => 'required|string|max:255',
            'jenis_rekognisi_id' => 'required|exists:jenis_rekognisi,id',
            'nama_penyelenggara' => 'required|string|max:255',
            'url_rekognisi' => 'nullable|url|max:500',
            'dokumen_sertifikat' => 'nullable|file|mimes:pdf|max:5120',
            'foto_kegiatan' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'dokumen_bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'surat_tugas' => 'nullable|file|mimes:pdf|max:5120',
            'tanggal_sertifikat' => 'nullable|date',
            'nidn_nuptk' => 'nullable|string|max:30',
            'nama_dosen' => 'nullable|string|max:150',
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
        if ($rekognisi->nim !== $mahasiswa->nim) {
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
}
