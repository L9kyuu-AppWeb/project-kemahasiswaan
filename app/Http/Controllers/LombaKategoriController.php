<?php

namespace App\Http\Controllers;

use App\Models\LombaKategori;
use Illuminate\Http\Request;

class LombaKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoriList = LombaKategori::latest()->paginate(10);
        return view('admin.lomba-kategori.index', compact('kategoriList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.lomba-kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        LombaKategori::create($validated);

        return redirect()->route('admin.lomba-kategori.index')
            ->with('success', 'Kategori lomba berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LombaKategori $lombaKategori)
    {
        return view('admin.lomba-kategori.show', compact('lombaKategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LombaKategori $lombaKategori)
    {
        return view('admin.lomba-kategori.edit', compact('lombaKategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LombaKategori $lombaKategori)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $lombaKategori->update($validated);

        return redirect()->route('admin.lomba-kategori.index')
            ->with('success', 'Kategori lomba berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LombaKategori $lombaKategori)
    {
        $lombaKategori->delete();

        return redirect()->route('admin.lomba-kategori.index')
            ->with('success', 'Kategori lomba berhasil dihapus.');
    }
}
