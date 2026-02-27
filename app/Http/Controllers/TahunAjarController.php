<?php

namespace App\Http\Controllers;

use App\Models\TahunAjar;
use Illuminate\Http\Request;

class TahunAjarController extends Controller
{
    /**
     * Display tahun ajar listing.
     */
    public function index(Request $request)
    {
        $query = TahunAjar::query();

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $tahunAjars = $query->orderBy('tahun_mulai', 'desc')->paginate(10);
        return view('admin.tahun-ajar.index', compact('tahunAjars'));
    }

    /**
     * Show form for creating tahun ajar.
     */
    public function create()
    {
        return view('admin.tahun-ajar.create');
    }

    /**
     * Store tahun ajar.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:20',
            'tahun_mulai' => 'required|string|max:4',
            'tahun_selesai' => 'required|string|max:4',
            'semester' => 'required|in:ganjil,genap',
            'is_active' => 'boolean',
        ]);

        // If setting as active, deactivate all others
        if ($validated['is_active'] ?? false) {
            TahunAjar::where('is_active', true)->update(['is_active' => false]);
        }

        TahunAjar::create($validated);

        return redirect()->route('admin.tahun-ajar.index')
            ->with('success', 'Tahun Ajar berhasil ditambahkan.');
    }

    /**
     * Display specified tahun ajar.
     */
    public function show(TahunAjar $tahunAjar)
    {
        return redirect()->route('admin.tahun-ajar.index');
    }

    /**
     * Show form for editing tahun ajar.
     */
    public function edit(TahunAjar $tahunAjar)
    {
        return view('admin.tahun-ajar.edit', compact('tahunAjar'));
    }

    /**
     * Update tahun ajar.
     */
    public function update(Request $request, TahunAjar $tahunAjar)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:20',
            'tahun_mulai' => 'required|string|max:4',
            'tahun_selesai' => 'required|string|max:4',
            'semester' => 'required|in:ganjil,genap',
            'is_active' => 'boolean',
        ]);

        // If setting as active, deactivate all others (except current record)
        if (($validated['is_active'] ?? false) && !$tahunAjar->is_active) {
            TahunAjar::where('is_active', true)
                ->where('id', '!=', $tahunAjar->id)
                ->update(['is_active' => false]);
        }

        $tahunAjar->update($validated);

        return redirect()->route('admin.tahun-ajar.index')
            ->with('success', 'Tahun Ajar berhasil diperbarui.');
    }

    /**
     * Set tahun ajar as active.
     */
    public function setActive(TahunAjar $tahunAjar)
    {
        // Deactivate all tahun ajar
        TahunAjar::where('is_active', true)->update(['is_active' => false]);

        // Activate selected tahun ajar
        $tahunAjar->update(['is_active' => true]);

        return redirect()->route('admin.tahun-ajar.index')
            ->with('success', 'Tahun Ajar aktif berhasil diubah.');
    }

    /**
     * Delete tahun ajar.
     */
    public function destroy(TahunAjar $tahunAjar)
    {
        // Cannot delete active tahun ajar
        if ($tahunAjar->is_active) {
            return redirect()->route('admin.tahun-ajar.index')
                ->with('error', 'Tidak dapat menghapus tahun ajar yang sedang aktif.');
        }

        $tahunAjar->delete();

        return redirect()->route('admin.tahun-ajar.index')
            ->with('success', 'Tahun Ajar berhasil dihapus.');
    }
}
