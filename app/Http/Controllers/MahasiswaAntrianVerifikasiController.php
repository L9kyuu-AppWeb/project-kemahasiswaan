<?php

namespace App\Http\Controllers;

use App\Models\AntrianVerifikasi;
use App\Models\AntrianVerifikasiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaAntrianVerifikasiController extends Controller
{
    /**
     * Display a listing of available antrian verifikasi for mahasiswa.
     */
    public function index()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Get all active antrian verifikasi
        $antrianVerifikasis = AntrianVerifikasi::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get mahasiswa's registrations
        $registrations = AntrianVerifikasiDetail::where('mahasiswa_id', $mahasiswa->id)
            ->with('antrianVerifikasi')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mahasiswa.antrian-verifikasi.index', compact('antrianVerifikasis', 'registrations'));
    }

    /**
     * Show available dates for registration.
     */
    public function register(string $id)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $antrianVerifikasi = AntrianVerifikasi::findOrFail($id);

        // Check if registration is open
        if (!$antrianVerifikasi->isPendaftaranOpen()) {
            return redirect()->route('mahasiswa.antrian-verifikasi.index')
                ->with('error', 'Pendaftaran antrian verifikasi belum/telah ditutup.');
        }

        // Check if already registered
        $alreadyRegistered = AntrianVerifikasiDetail::where('antrian_verifikasi_id', $id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('status', '!=', 'dibatalkan')
            ->exists();

        if ($alreadyRegistered) {
            return redirect()->route('mahasiswa.antrian-verifikasi.index')
                ->with('error', 'Anda sudah terdaftar di antrian verifikasi ini.');
        }

        // Get available dates
        $availableDates = $antrianVerifikasi->getAvailableDates();

        return view('mahasiswa.antrian-verifikasi.register', compact('antrianVerifikasi', 'availableDates'));
    }

    /**
     * Store registration.
     */
    public function store(Request $request, string $id)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $antrianVerifikasi = AntrianVerifikasi::findOrFail($id);

        // Check if registration is open
        if (!$antrianVerifikasi->isPendaftaranOpen()) {
            return back()->with('error', 'Pendaftaran antrian verifikasi belum/telah ditutup.');
        }

        $validated = $request->validate([
            'tanggal_verifikasi' => 'required|date',
        ]);

        // Check if already registered
        $alreadyRegistered = AntrianVerifikasiDetail::where('antrian_verifikasi_id', $id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('status', '!=', 'dibatalkan')
            ->exists();

        if ($alreadyRegistered) {
            return back()->with('error', 'Anda sudah terdaftar di antrian verifikasi ini.');
        }

        // Check if date is valid (within verification period and not weekend)
        $tanggalVerifikasi = \Carbon\Carbon::parse($validated['tanggal_verifikasi']);
        if ($tanggalVerifikasi->format('N') >= 6) {
            return back()->with('error', 'Tanggal verifikasi tidak boleh hari Sabtu atau Minggu.');
        }

        if ($tanggalVerifikasi < $antrianVerifikasi->tanggal_mulai_verifikasi ||
            $tanggalVerifikasi > $antrianVerifikasi->tanggal_selesai_verifikasi) {
            return back()->with('error', 'Tanggal verifikasi tidak valid.');
        }

        // Check quota for selected date
        $counted = AntrianVerifikasiDetail::where('antrian_verifikasi_id', $id)
            ->where('tanggal_verifikasi', $validated['tanggal_verifikasi'])
            ->where('status', '!=', 'dibatalkan')
            ->count();

        if ($counted >= $antrianVerifikasi->kuota_per_hari) {
            return back()->with('error', 'Kuota untuk tanggal tersebut sudah penuh.');
        }

        // Create registration
        $detail = AntrianVerifikasiDetail::create([
            'antrian_verifikasi_id' => $id,
            'mahasiswa_id' => $mahasiswa->id,
            'tanggal_verifikasi' => $validated['tanggal_verifikasi'],
            'nomor_antrian' => AntrianVerifikasiDetail::generateNomorAntrian($id, $validated['tanggal_verifikasi']),
            'status' => 'menunggu',
        ]);

        return redirect()->route('mahasiswa.antrian-verifikasi.bukti', $detail->id)
            ->with('success', 'Pendaftaran berhasil. Silakan unduh bukti pertemuan.');
    }

    /**
     * Show bukti (proof) of registration.
     */
    public function bukti(string $id)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $detail = AntrianVerifikasiDetail::with(['antrianVerifikasi', 'mahasiswa.programStudi'])
            ->findOrFail($id);

        // Only allow access to own registration
        if ($detail->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        return view('mahasiswa.antrian-verifikasi.bukti', compact('detail'));
    }

    /**
     * Download bukti as PDF.
     */
    public function downloadBukti(string $id)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $detail = AntrianVerifikasiDetail::with(['antrianVerifikasi', 'mahasiswa.programStudi'])
            ->findOrFail($id);

        // Only allow access to own registration
        if ($detail->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        $pdf = \PDF::loadView('pdf.bukti-antrian-verifikasi', compact('detail'));
        $filename = 'Bukti_Verifikasi_' . preg_replace('/[^A-Za-z0-9_]/', '_', $detail->nomor_antrian) . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Cancel registration.
     */
    public function cancel(string $id)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $detail = AntrianVerifikasiDetail::where('id', $id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->firstOrFail();

        $detail->status = 'dibatalkan';
        $detail->save();

        return redirect()->route('mahasiswa.antrian-verifikasi.index')
            ->with('success', 'Pendaftaran berhasil dibatalkan.');
    }
}
