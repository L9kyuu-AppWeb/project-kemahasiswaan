<?php

namespace App\Http\Controllers;

use App\Models\JenisKegiatan;
use Illuminate\Http\Request;

class JenisKegiatanController extends Controller
{
    public function index()
    {
        $jenisKegiatans = JenisKegiatan::latest()->paginate(15);
        return view('admin.jenis-kegiatan.index', compact('jenisKegiatans'));
    }

    public function create()
    {
        return view('admin.jenis-kegiatan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
        ]);

        JenisKegiatan::create($validated);

        return redirect()->route('admin.master-kegiatan.jenis.index')
            ->with('success', 'Jenis kegiatan berhasil ditambahkan.');
    }

    public function edit(JenisKegiatan $jenisKegiatan)
    {
        return view('admin.jenis-kegiatan.edit', compact('jenisKegiatan'));
    }

    public function update(Request $request, JenisKegiatan $jenisKegiatan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
        ]);

        $jenisKegiatan->update($validated);

        return redirect()->route('admin.master-kegiatan.jenis.index')
            ->with('success', 'Jenis kegiatan berhasil diperbarui.');
    }

    public function destroy(JenisKegiatan $jenisKegiatan)
    {
        $jenisKegiatan->delete();

        return redirect()->route('admin.master-kegiatan.jenis.index')
            ->with('success', 'Jenis kegiatan berhasil dihapus.');
    }
}
