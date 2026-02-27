<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pengumuman::query();
        
        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        
        // Filter by prioritas
        if ($request->filled('prioritas')) {
            $query->where('prioritas', $request->prioritas);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published');
        }
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('konten', 'like', "%{$search}%");
            });
        }
        
        $pengumumen = $query->latest()->paginate(10);
        
        return view('admin.pengumuman.index', compact('pengumumen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pengumuman.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'required|in:umum,akademik,kemahasiswaan,beasiswa',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'is_published' => 'boolean',
            'tanggal_publish' => 'nullable|date',
            'tanggal_expire' => 'nullable|date|after_or_equal:tanggal_publish',
        ]);

        $validated['is_published'] = $request->has('is_published');
        
        if (empty($validated['tanggal_publish'])) {
            $validated['tanggal_publish'] = now();
        }

        Pengumuman::create($validated);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.show', compact('pengumuman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'required|in:umum,akademik,kemahasiswaan,beasiswa',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'is_published' => 'boolean',
            'tanggal_publish' => 'nullable|date',
            'tanggal_expire' => 'nullable|date|after_or_equal:tanggal_publish',
        ]);

        $validated['is_published'] = $request->has('is_published');

        $pengumuman->update($validated);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
