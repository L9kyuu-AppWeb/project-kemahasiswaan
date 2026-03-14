<?php

namespace App\Http\Controllers;

use App\Models\Sertifikasi;
use App\Models\JenisKegiatan;
use App\Models\DetailKegiatan;
use App\Models\RuangLingkup;
use App\Models\NilaiKegiatan;
use App\Rules\ValidCertificateDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SertifikasiController extends Controller
{
    // ==================== ADMIN METHODS ====================

    public function adminIndex(Request $request)
    {
        $query = Sertifikasi::with('mahasiswa')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sertifikasis = $query->paginate(15);

        return view('admin.sertifikasi.index', compact('sertifikasis'));
    }

    public function adminShow(Sertifikasi $sertifikasi)
    {
        return view('admin.sertifikasi.show', compact('sertifikasi'));
    }

    public function adminEdit(Sertifikasi $sertifikasi)
    {
        return view('admin.sertifikasi.edit', compact('sertifikasi'));
    }

    public function adminUpdate(Request $request, Sertifikasi $sertifikasi)
    {
        $validated = $request->validate([
            'nama_sertifikasi' => 'required|string|max:255',
            'nama_penyelenggara' => 'required|string|max:255',
            'url_sertifikasi' => 'nullable|url|max:500',
            'dokumen_sertifikat' => 'nullable|file|mimes:pdf|max:5120',
            'foto_kegiatan' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'dokumen_bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'url_surat_tugas' => 'nullable|url|max:500',
            'tanggal_sertifikat' => ['nullable', 'date', new ValidCertificateDate()],
            'dosen_id' => 'nullable|exists:dosens,id',
        ]);

        if ($request->hasFile('dokumen_sertifikat')) {
            if ($sertifikasi->dokumen_sertifikat) {
                Storage::disk('public')->delete($sertifikasi->dokumen_sertifikat);
            }
            $validated['dokumen_sertifikat'] = $request->file('dokumen_sertifikat')->store('sertifikasi/sertifikat', 'public');
        }

        if ($request->hasFile('foto_kegiatan')) {
            if ($sertifikasi->foto_kegiatan) {
                Storage::disk('public')->delete($sertifikasi->foto_kegiatan);
            }
            $validated['foto_kegiatan'] = $request->file('foto_kegiatan')->store('sertifikasi/foto_kegiatan', 'public');
        }

        if ($request->hasFile('dokumen_bukti')) {
            if ($sertifikasi->dokumen_bukti) {
                Storage::disk('public')->delete($sertifikasi->dokumen_bukti);
            }
            $validated['dokumen_bukti'] = $request->file('dokumen_bukti')->store('sertifikasi/dokumen_bukti', 'public');
        }

        $sertifikasi->update($validated);

        return redirect()->route('admin.sertifikasi.index')->with('success', 'Data sertifikasi berhasil diperbarui.');
    }

    public function adminDestroy(Sertifikasi $sertifikasi)
    {
        if ($sertifikasi->dokumen_sertifikat) Storage::disk('public')->delete($sertifikasi->dokumen_sertifikat);
        if ($sertifikasi->foto_kegiatan) Storage::disk('public')->delete($sertifikasi->foto_kegiatan);
        if ($sertifikasi->dokumen_bukti) Storage::disk('public')->delete($sertifikasi->dokumen_bukti);

        $sertifikasi->delete();

        return redirect()->route('admin.sertifikasi.index')->with('success', 'Data sertifikasi berhasil dihapus.');
    }

    public function adminApprove(Request $request, Sertifikasi $sertifikasi)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'keterangan_verifikasi' => 'nullable|string|max:500',
        ]);

        $sertifikasi->update($validated);

        $message = $validated['status'] === 'approved' ? 'Sertifikasi berhasil disetujui.' : 'Sertifikasi ditolak.';

        return redirect()->route('admin.sertifikasi.index')->with('success', $message);
    }

    // ==================== MAHASISWA METHODS ====================

    public function index()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $sertifikasis = Sertifikasi::where('mahasiswa_id', $mahasiswa->id)
            ->with('mahasiswa')
            ->latest()
            ->paginate(15);

        return view('mahasiswa.sertifikasi.index', compact('sertifikasis'));
    }

    public function create()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $dosens = \App\Models\Dosen::orderBy('nama')->get();
        $jenisKegiatans = \App\Models\JenisKegiatan::orderBy('id')->get();

        return view('mahasiswa.sertifikasi.create', compact('mahasiswa', 'dosens', 'jenisKegiatans'));
    }

    public function store(Request $request)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'nama_sertifikasi' => 'required|string|max:255',
            'nama_penyelenggara' => 'required|string|max:255',
            'url_sertifikasi' => 'nullable|url|max:500',
            'dokumen_sertifikat' => 'required|file|mimes:pdf|max:5120',
            'foto_kegiatan' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'dokumen_bukti' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'url_surat_tugas' => 'nullable|url|max:500',
            'tanggal_sertifikat' => ['nullable', 'date', new ValidCertificateDate()],
            'dosen_id' => 'nullable|exists:dosens,id',
        ]);

        $dokumenSertifikatPath = $request->file('dokumen_sertifikat')->store('sertifikasi/sertifikat', 'public');

        $fotoKegiatanPath = null;
        if ($request->hasFile('foto_kegiatan')) {
            $fotoKegiatanPath = $request->file('foto_kegiatan')->store('sertifikasi/foto_kegiatan', 'public');
        }

        $dokumenBuktiPath = $request->file('dokumen_bukti')->store('sertifikasi/dokumen_bukti', 'public');

        Sertifikasi::create([
            'nama_sertifikasi' => $validated['nama_sertifikasi'],
            'nama_penyelenggara' => $validated['nama_penyelenggara'],
            'url_sertifikasi' => $validated['url_sertifikasi'],
            'dokumen_sertifikat' => $dokumenSertifikatPath,
            'foto_kegiatan' => $fotoKegiatanPath,
            'dokumen_bukti' => $dokumenBuktiPath,
            'tanggal_sertifikat' => $validated['tanggal_sertifikat'],
            'mahasiswa_id' => $mahasiswa->id,
            'dosen_id' => $validated['dosen_id'],
            'url_surat_tugas' => $validated['url_surat_tugas'],
            'status' => 'pending',
        ]);

        return redirect()->route('mahasiswa.sertifikasi.index')->with('success', 'Data sertifikasi berhasil ditambahkan. Menunggu verifikasi admin.');
    }

    public function show(Sertifikasi $sertifikasi)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if ($sertifikasi->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        return view('mahasiswa.sertifikasi.show', compact('sertifikasi'));
    }

    public function edit(Sertifikasi $sertifikasi)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if ($sertifikasi->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($sertifikasi->status !== 'pending') {
            return redirect()->route('mahasiswa.sertifikasi.index')->with('error', 'Data yang sudah diverifikasi tidak dapat diedit.');
        }

        $dosens = \App\Models\Dosen::orderBy('nama')->get();

        return view('mahasiswa.sertifikasi.edit', compact('sertifikasi', 'dosens'));
    }

    public function update(Request $request, Sertifikasi $sertifikasi)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if ($sertifikasi->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($sertifikasi->status !== 'pending') {
            return redirect()->route('mahasiswa.sertifikasi.index')->with('error', 'Data yang sudah diverifikasi tidak dapat diedit.');
        }

        $validated = $request->validate([
            'nama_sertifikasi' => 'required|string|max:255',
            'nama_penyelenggara' => 'required|string|max:255',
            'url_sertifikasi' => 'nullable|url|max:500',
            'dokumen_sertifikat' => 'nullable|file|mimes:pdf|max:5120',
            'foto_kegiatan' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'dokumen_bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'url_surat_tugas' => 'nullable|url|max:500',
            'tanggal_sertifikat' => ['nullable', 'date', new ValidCertificateDate()],
            'dosen_id' => 'nullable|exists:dosens,id',
        ]);

        if ($request->hasFile('dokumen_sertifikat')) {
            if ($sertifikasi->dokumen_sertifikat) {
                Storage::disk('public')->delete($sertifikasi->dokumen_sertifikat);
            }
            $validated['dokumen_sertifikat'] = $request->file('dokumen_sertifikat')->store('sertifikasi/sertifikat', 'public');
        } else {
            unset($validated['dokumen_sertifikat']);
        }

        if ($request->hasFile('foto_kegiatan')) {
            if ($sertifikasi->foto_kegiatan) {
                Storage::disk('public')->delete($sertifikasi->foto_kegiatan);
            }
            $validated['foto_kegiatan'] = $request->file('foto_kegiatan')->store('sertifikasi/foto_kegiatan', 'public');
        } else {
            unset($validated['foto_kegiatan']);
        }

        if ($request->hasFile('dokumen_bukti')) {
            if ($sertifikasi->dokumen_bukti) {
                Storage::disk('public')->delete($sertifikasi->dokumen_bukti);
            }
            $validated['dokumen_bukti'] = $request->file('dokumen_bukti')->store('sertifikasi/dokumen_bukti', 'public');
        } else {
            unset($validated['dokumen_bukti']);
        }

        $sertifikasi->update($validated);

        return redirect()->route('mahasiswa.sertifikasi.index')->with('success', 'Data sertifikasi berhasil diperbarui.');
    }

    public function destroy(Sertifikasi $sertifikasi)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if ($sertifikasi->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($sertifikasi->status !== 'pending') {
            return redirect()->route('mahasiswa.sertifikasi.index')->with('error', 'Data yang sudah diverifikasi tidak dapat dihapus.');
        }

        if ($sertifikasi->dokumen_sertifikat) Storage::disk('public')->delete($sertifikasi->dokumen_sertifikat);
        if ($sertifikasi->foto_kegiatan) Storage::disk('public')->delete($sertifikasi->foto_kegiatan);
        if ($sertifikasi->dokumen_bukti) Storage::disk('public')->delete($sertifikasi->dokumen_bukti);

        $sertifikasi->delete();

        return redirect()->route('mahasiswa.sertifikasi.index')->with('success', 'Data sertifikasi berhasil dihapus.');
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
}
