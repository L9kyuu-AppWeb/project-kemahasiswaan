<?php

namespace App\Http\Controllers;

use App\Models\KategoriKegiatanUmum;
use Illuminate\Http\Request;

class KategoriKegiatanUmumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = KategoriKegiatanUmum::orderBy('nama_kategori');

        if ($request->filled('search')) {
            $query->where('nama_kategori', 'LIKE', "%{$request->search}%");
        }

        $kategoriList = $query->paginate(15);

        return view('admin.kategori-kegiatan-umum.index', compact('kategoriList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kategori-kegiatan-umum.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_kegiatan_umums,nama_kategori',
        ]);

        KategoriKegiatanUmum::create($validated);

        return redirect()->route('admin.kategori-kegiatan-umum.index')
            ->with('success', 'Kategori kegiatan umum berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriKegiatanUmum $kategoriKegiatanUmum)
    {
        return view('admin.kategori-kegiatan-umum.show', compact('kategoriKegiatanUmum'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriKegiatanUmum $kategoriKegiatanUmum)
    {
        return view('admin.kategori-kegiatan-umum.edit', compact('kategoriKegiatanUmum'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriKegiatanUmum $kategoriKegiatanUmum)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_kegiatan_umums,nama_kategori,' . $kategoriKegiatanUmum->id,
        ]);

        $kategoriKegiatanUmum->update($validated);

        return redirect()->route('admin.kategori-kegiatan-umum.index')
            ->with('success', 'Kategori kegiatan umum berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriKegiatanUmum $kategoriKegiatanUmum)
    {
        $kategoriKegiatanUmum->delete();

        return redirect()->route('admin.kategori-kegiatan-umum.index')
            ->with('success', 'Kategori kegiatan umum berhasil dihapus.');
    }
}
