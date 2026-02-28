<?php

namespace App\Http\Controllers;

use App\Models\AntrianVerifikasi;
use App\Models\AntrianVerifikasiDetail;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AntrianVerifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $antrianVerifikasis = AntrianVerifikasi::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.antrian-verifikasi.index', compact('antrianVerifikasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.antrian-verifikasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai_pendaftaran' => 'required|date',
            'tanggal_selesai_pendaftaran' => 'required|date|after_or_equal:tanggal_mulai_pendaftaran',
            'tanggal_mulai_verifikasi' => 'required|date|after_or_equal:tanggal_selesai_pendaftaran',
            'tanggal_selesai_verifikasi' => 'required|date|after_or_equal:tanggal_mulai_verifikasi',
            'kuota_per_hari' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        AntrianVerifikasi::create($validated);

        return redirect()->route('admin.antrian-verifikasi.index')
            ->with('success', 'Antrian verifikasi berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $antrianVerifikasi = AntrianVerifikasi::with('details.mahasiswa.programStudi')->findOrFail($id);
        $details = $antrianVerifikasi->details()
            ->with('mahasiswa.programStudi')
            ->orderBy('tanggal_verifikasi')
            ->orderBy('nomor_antrian')
            ->paginate(20);

        // Group by date for summary
        $summaryPerTanggal = DB::table('antrian_verifikasi_details')
            ->where('antrian_verifikasi_id', $id)
            ->where('status', '!=', 'dibatalkan')
            ->select('tanggal_verifikasi', DB::raw('count(*) as total'))
            ->groupBy('tanggal_verifikasi')
            ->orderBy('tanggal_verifikasi')
            ->get();

        return view('admin.antrian-verifikasi.show', compact('antrianVerifikasi', 'details', 'summaryPerTanggal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $antrianVerifikasi = AntrianVerifikasi::findOrFail($id);
        return view('admin.antrian-verifikasi.edit', compact('antrianVerifikasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $antrianVerifikasi = AntrianVerifikasi::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai_pendaftaran' => 'required|date',
            'tanggal_selesai_pendaftaran' => 'required|date|after_or_equal:tanggal_mulai_pendaftaran',
            'tanggal_mulai_verifikasi' => 'required|date|after_or_equal:tanggal_selesai_pendaftaran',
            'tanggal_selesai_verifikasi' => 'required|date|after_or_equal:tanggal_mulai_verifikasi',
            'kuota_per_hari' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $antrianVerifikasi->update($validated);

        return redirect()->route('admin.antrian-verifikasi.index')
            ->with('success', 'Antrian verifikasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $antrianVerifikasi = AntrianVerifikasi::findOrFail($id);
        $antrianVerifikasi->delete();

        return redirect()->route('admin.antrian-verifikasi.index')
            ->with('success', 'Antrian verifikasi berhasil dihapus.');
    }

    /**
     * Mark attendance for verification.
     */
    public function markAttendance(Request $request, string $detailId)
    {
        $detail = AntrianVerifikasiDetail::findOrFail($detailId);
        $detail->hadir_verifikasi = $request->boolean('hadir', false);
        $detail->save();

        return back()->with('success', 'Kehadiran berhasil diperbarui.');
    }

    /**
     * Update status of verification detail.
     */
    public function updateStatus(Request $request, string $detailId)
    {
        $detail = AntrianVerifikasiDetail::findOrFail($detailId);
        $detail->status = $request->status;
        $detail->keterangan = $request->keterangan;
        $detail->save();

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    /**
     * Cancel a registration.
     */
    public function cancelRegistration(string $detailId)
    {
        $detail = AntrianVerifikasiDetail::findOrFail($detailId);
        $detail->status = 'dibatalkan';
        $detail->save();

        return back()->with('success', 'Pendaftaran berhasil dibatalkan.');
    }
}
