<?php

namespace App\Http\Controllers;

use App\Models\DetailKegiatan;
use App\Models\JenisKegiatan;
use Illuminate\Http\Request;

class DetailKegiatanController extends Controller
{
    public function index()
    {
        $detailKegiatans = DetailKegiatan::with('jenisKegiatan')->latest()->paginate(15);
        return view('admin.detail-kegiatan.index', compact('detailKegiatans'));
    }

    public function create()
    {
        $jenisKegiatans = JenisKegiatan::orderBy('nama')->get();
        return view('admin.detail-kegiatan.create', compact('jenisKegiatans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_id' => 'required|exists:jenis_kegiatan,id',
            'nama' => 'required|string|max:100',
        ]);

        DetailKegiatan::create($validated);

        return redirect()->route('admin.master-kegiatan.detail.index')
            ->with('success', 'Detail kegiatan berhasil ditambahkan.');
    }

    public function edit(DetailKegiatan $detailKegiatan)
    {
        $jenisKegiatans = JenisKegiatan::orderBy('nama')->get();
        return view('admin.detail-kegiatan.edit', compact('detailKegiatan', 'jenisKegiatans'));
    }

    public function update(Request $request, DetailKegiatan $detailKegiatan)
    {
        $validated = $request->validate([
            'jenis_id' => 'required|exists:jenis_kegiatan,id',
            'nama' => 'required|string|max:100',
        ]);

        $detailKegiatan->update($validated);

        return redirect()->route('admin.master-kegiatan.detail.index')
            ->with('success', 'Detail kegiatan berhasil diperbarui.');
    }

    public function destroy(DetailKegiatan $detailKegiatan)
    {
        $detailKegiatan->delete();

        return redirect()->route('admin.master-kegiatan.detail.index')
            ->with('success', 'Detail kegiatan berhasil dihapus.');
    }
}
