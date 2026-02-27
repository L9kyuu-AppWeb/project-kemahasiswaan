<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaMagang;
use App\Models\Mahasiswa;
use App\Models\TahunAjar;
use Illuminate\Http\Request;

class MahasiswaMagangController extends Controller
{
    /**
     * Display a listing of mahasiswa magang.
     */
    public function index(Request $request)
    {
        $query = MahasiswaMagang::with(['mahasiswa.programStudi', 'tahunAjar']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tahun_ajar_id')) {
            $query->where('tahun_ajar_id', $request->tahun_ajar_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('mahasiswa', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        $magangs = $query->latest()->paginate(10);
        $tahunAjarList = TahunAjar::orderBy('tahun_mulai', 'desc')->get();

        return view('admin.magang.index', compact('magangs', 'tahunAjarList'));
    }

    /**
     * Show form for creating new mahasiswa magang.
     */
    public function create()
    {
        // Get active tahun ajar
        $tahunAjarAktif = TahunAjar::where('is_active', true)->first();

        if (!$tahunAjarAktif) {
            return redirect()->route('admin.magang.index')
                ->with('error', 'Tidak ada tahun ajar aktif. Silakan aktifkan tahun ajar terlebih dahulu.');
        }

        // Get all mahasiswas for dropdown
        $mahasiswas = Mahasiswa::with('programStudi')->orderBy('name')->get();
        $tahunAjarList = TahunAjar::orderBy('tahun_mulai', 'desc')->get();

        return view('admin.magang.create', compact('mahasiswas', 'tahunAjarAktif', 'tahunAjarList'));
    }

    /**
     * Store new mahasiswa magang.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'tahun_ajar_id' => 'required|exists:tahun_ajars,id',
            'semester' => 'required|integer|min:1|max:10',
            'nama_perusahaan' => 'required|string|max:255',
            'lokasi_perusahaan' => 'required|string|max:255',
            'pembimbing_lapangan' => 'nullable|string|max:255',
            'no_telp_pembimbing' => 'nullable|string|max:20',
            'dosen_pembimbing_nama' => 'nullable|string|max:255',
            'dosen_pembimbing_nik' => 'nullable|string|max:20',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,selesai,tidak_aktif',
            'catatan' => 'nullable|string|max:1000',
        ]);

        // Check if mahasiswa already has active magang for this tahun ajar
        $existingMagang = MahasiswaMagang::where('mahasiswa_id', $validated['mahasiswa_id'])
            ->where('tahun_ajar_id', $validated['tahun_ajar_id'])
            ->whereIn('status', ['aktif'])
            ->first();

        if ($existingMagang) {
            return redirect()->route('admin.magang.create')
                ->with('error', 'Mahasiswa ini sudah memiliki magang aktif untuk tahun ajar ini.');
        }

        MahasiswaMagang::create($validated);

        return redirect()->route('admin.magang.index')
            ->with('success', 'Data mahasiswa magang berhasil ditambahkan.');
    }

    /**
     * Display specified mahasiswa magang.
     */
    public function show(MahasiswaMagang $magang)
    {
        $magang->load(['mahasiswa.programStudi', 'tahunAjar']);
        return view('admin.magang.show', compact('magang'));
    }

    /**
     * Show form for editing mahasiswa magang.
     */
    public function edit(MahasiswaMagang $magang)
    {
        $mahasiswas = Mahasiswa::with('programStudi')->orderBy('name')->get();
        $tahunAjarList = TahunAjar::orderBy('tahun_mulai', 'desc')->get();

        return view('admin.magang.edit', compact('magang', 'mahasiswas', 'tahunAjarList'));
    }

    /**
     * Update mahasiswa magang.
     */
    public function update(Request $request, MahasiswaMagang $magang)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'tahun_ajar_id' => 'required|exists:tahun_ajars,id',
            'semester' => 'required|integer|min:1|max:10',
            'nama_perusahaan' => 'required|string|max:255',
            'lokasi_perusahaan' => 'required|string|max:255',
            'pembimbing_lapangan' => 'nullable|string|max:255',
            'no_telp_pembimbing' => 'nullable|string|max:20',
            'dosen_pembimbing_nama' => 'nullable|string|max:255',
            'dosen_pembimbing_nik' => 'nullable|string|max:20',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,selesai,tidak_aktif',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $magang->update($validated);

        return redirect()->route('admin.magang.index')
            ->with('success', 'Data mahasiswa magang berhasil diperbarui.');
    }

    /**
     * Delete mahasiswa magang.
     */
    public function destroy(MahasiswaMagang $magang)
    {
        $magang->delete();

        return redirect()->route('admin.magang.index')
            ->with('success', 'Data mahasiswa magang berhasil dihapus.');
    }
}
