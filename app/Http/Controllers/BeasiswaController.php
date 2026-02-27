<?php

namespace App\Http\Controllers;

use App\Models\BeasiswaTipe;
use App\Models\MahasiswaBeasiswa;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeasiswaController extends Controller
{
    /**
     * Display beasiswa tipe listing.
     */
    public function indexTipe(Request $request)
    {
        $query = BeasiswaTipe::query();
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $beasiswaTipes = $query->latest()->paginate(10);
        return view('admin.beasiswa.tipe-index', compact('beasiswaTipes'));
    }

    /**
     * Show form for creating beasiswa tipe.
     */
    public function createTipe()
    {
        return view('admin.beasiswa.tipe-create');
    }

    /**
     * Store beasiswa tipe.
     */
    public function storeTipe(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:20|unique:beasiswa_tipes,kode',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        BeasiswaTipe::create($validated);

        return redirect()->route('admin.beasiswa.tipe.index')
            ->with('success', 'Jenis Beasiswa berhasil ditambahkan.');
    }

    /**
     * Show form for editing beasiswa tipe.
     */
    public function editTipe(BeasiswaTipe $beasiswaTipe)
    {
        return view('admin.beasiswa.tipe-edit', compact('beasiswaTipe'));
    }

    /**
     * Update beasiswa tipe.
     */
    public function updateTipe(Request $request, BeasiswaTipe $beasiswaTipe)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:20|unique:beasiswa_tipes,kode,' . $beasiswaTipe->id,
            'keterangan' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $beasiswaTipe->update($validated);

        return redirect()->route('admin.beasiswa.tipe.index')
            ->with('success', 'Jenis Beasiswa berhasil diperbarui.');
    }

    /**
     * Delete beasiswa tipe.
     */
    public function destroyTipe(BeasiswaTipe $beasiswaTipe)
    {
        $beasiswaTipe->delete();

        return redirect()->route('admin.beasiswa.tipe.index')
            ->with('success', 'Jenis Beasiswa berhasil dihapus.');
    }

    /**
     * Display mahasiswa beasiswa listing.
     */
    public function index(Request $request)
    {
        $query = MahasiswaBeasiswa::with(['mahasiswa.programStudi', 'beasiswaTipe']);
        
        if ($request->filled('beasiswa_tipe_id')) {
            $query->where('beasiswa_tipe_id', $request->beasiswa_tipe_id);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('mahasiswa', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }
        
        $mahasiswaBeasiswas = $query->latest()->paginate(10);
        $beasiswaTipeList = BeasiswaTipe::where('status', 'aktif')->orderBy('nama')->get();
        
        return view('admin.beasiswa.index', compact('mahasiswaBeasiswas', 'beasiswaTipeList'));
    }

    /**
     * Show form for creating mahasiswa beasiswa.
     */
    public function create()
    {
        $mahasiswaList = Mahasiswa::with('programStudi')->orderBy('name')->get();
        $beasiswaTipeList = BeasiswaTipe::where('status', 'aktif')->orderBy('nama')->get();
        return view('admin.beasiswa.create', compact('mahasiswaList', 'beasiswaTipeList'));
    }

    /**
     * Store mahasiswa beasiswa.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'beasiswa_tipe_id' => 'required|exists:beasiswa_tipes,id',
            'nomor_sk' => 'required|string|max:100',
            'file_sk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,tidak_aktif',
            'alasan_tidak_aktif' => 'nullable|string|required_if:status,tidak_aktif',
        ]);

        // Handle file upload
        if ($request->hasFile('file_sk')) {
            $validated['file_sk'] = $request->file('file_sk')->store('beasiswa/sk', 'public');
        }

        // Set inactive_at if status is tidak_aktif
        if ($validated['status'] === 'tidak_aktif') {
            $validated['inactive_at'] = now();
        }

        MahasiswaBeasiswa::create($validated);

        return redirect()->route('admin.beasiswa.index')
            ->with('success', 'Mahasiswa penerima beasiswa berhasil ditambahkan.');
    }

    /**
     * Display mahasiswa beasiswa detail.
     */
    public function show(MahasiswaBeasiswa $mahasiswaBeasiswa)
    {
        return view('admin.beasiswa.show', compact('mahasiswaBeasiswa'));
    }

    /**
     * Show form for editing mahasiswa beasiswa.
     */
    public function edit(MahasiswaBeasiswa $mahasiswaBeasiswa)
    {
        $mahasiswaList = Mahasiswa::with('programStudi')->orderBy('name')->get();
        $beasiswaTipeList = BeasiswaTipe::where('status', 'aktif')->orderBy('nama')->get();
        return view('admin.beasiswa.edit', compact('mahasiswaBeasiswa', 'mahasiswaList', 'beasiswaTipeList'));
    }

    /**
     * Update mahasiswa beasiswa.
     */
    public function update(Request $request, MahasiswaBeasiswa $mahasiswaBeasiswa)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'beasiswa_tipe_id' => 'required|exists:beasiswa_tipes,id',
            'nomor_sk' => 'required|string|max:100',
            'file_sk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,tidak_aktif',
            'alasan_tidak_aktif' => 'nullable|string|required_if:status,tidak_aktif',
        ]);

        // Handle file upload
        if ($request->hasFile('file_sk')) {
            // Delete old file
            if ($mahasiswaBeasiswa->file_sk) {
                Storage::disk('public')->delete($mahasiswaBeasiswa->file_sk);
            }
            $validated['file_sk'] = $request->file('file_sk')->store('beasiswa/sk', 'public');
        }

        // Set inactive_at if status changed to tidak_aktif
        if ($validated['status'] === 'tidak_aktif' && $mahasiswaBeasiswa->status === 'aktif') {
            $validated['inactive_at'] = now();
        } elseif ($validated['status'] === 'aktif') {
            $validated['inactive_at'] = null;
        }

        $mahasiswaBeasiswa->update($validated);

        return redirect()->route('admin.beasiswa.index')
            ->with('success', 'Data beasiswa mahasiswa berhasil diperbarui.');
    }

    /**
     * Delete mahasiswa beasiswa.
     */
    public function destroy(MahasiswaBeasiswa $mahasiswaBeasiswa)
    {
        // Delete file if exists
        if ($mahasiswaBeasiswa->file_sk) {
            Storage::disk('public')->delete($mahasiswaBeasiswa->file_sk);
        }

        $mahasiswaBeasiswa->delete();

        return redirect()->route('admin.beasiswa.index')
            ->with('success', 'Data beasiswa mahasiswa berhasil dihapus.');
    }
}
