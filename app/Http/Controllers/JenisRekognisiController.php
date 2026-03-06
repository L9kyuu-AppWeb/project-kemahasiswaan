<?php

namespace App\Http\Controllers;

use App\Models\JenisRekognisi;
use Illuminate\Http\Request;

class JenisRekognisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisRekognisiList = JenisRekognisi::latest()->paginate(10);
        return view('admin.jenis-rekognisi.index', compact('jenisRekognisiList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.jenis-rekognisi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        JenisRekognisi::create($validated);

        return redirect()->route('admin.jenis-rekognisi.index')
            ->with('success', 'Jenis rekognisi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisRekognisi $jenisRekognisi)
    {
        return view('admin.jenis-rekognisi.edit', compact('jenisRekognisi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisRekognisi $jenisRekognisi)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $jenisRekognisi->update($validated);

        return redirect()->route('admin.jenis-rekognisi.index')
            ->with('success', 'Jenis rekognisi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisRekognisi $jenisRekognisi)
    {
        $jenisRekognisi->delete();

        return redirect()->route('admin.jenis-rekognisi.index')
            ->with('success', 'Jenis rekognisi berhasil dihapus.');
    }
}
