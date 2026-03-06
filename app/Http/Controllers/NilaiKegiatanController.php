<?php

namespace App\Http\Controllers;

use App\Models\NilaiKegiatan;
use App\Models\JenisKegiatan;
use App\Models\DetailKegiatan;
use App\Models\RuangLingkup;
use Illuminate\Http\Request;

class NilaiKegiatanController extends Controller
{
    public function index(Request $request)
    {
        $query = NilaiKegiatan::with(['jenisKegiatan', 'detailKegiatan', 'ruangLingkup']);

        if ($request->filled('jenis_id')) {
            $query->where('jenis_id', $request->jenis_id);
        }

        $nilaiKegiatans = $query->latest()->paginate(15);
        $jenisKegiatans = JenisKegiatan::orderBy('nama')->get();

        return view('admin.nilai-kegiatan.index', compact('nilaiKegiatans', 'jenisKegiatans'));
    }

    public function create()
    {
        $jenisKegiatans = JenisKegiatan::orderBy('nama')->get();
        $ruangLingkups = RuangLingkup::orderBy('nama')->get();
        return view('admin.nilai-kegiatan.create', compact('jenisKegiatans', 'ruangLingkups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_id' => 'required|exists:jenis_kegiatan,id',
            'detail_id' => 'required|exists:detail_kegiatan,id',
            'ruang_id' => 'required|exists:ruang_lingkup,id',
            'nilai' => 'required|integer|min:0',
        ]);

        // Check if combination already exists
        $exists = NilaiKegiatan::where('jenis_id', $validated['jenis_id'])
            ->where('detail_id', $validated['detail_id'])
            ->where('ruang_id', $validated['ruang_id'])
            ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Kombinasi jenis, detail, dan ruang lingkup sudah ada.');
        }

        NilaiKegiatan::create($validated);

        return redirect()->route('admin.nilai-kegiatan.index')
            ->with('success', 'Nilai kegiatan berhasil ditambahkan.');
    }

    public function edit(NilaiKegiatan $nilaiKegiatan)
    {
        $jenisKegiatans = JenisKegiatan::orderBy('nama')->get();
        $detailKegiatans = DetailKegiatan::where('jenis_id', $nilaiKegiatan->jenis_id)->orderBy('nama')->get();
        $ruangLingkups = RuangLingkup::orderBy('nama')->get();

        return view('admin.nilai-kegiatan.edit', compact('nilaiKegiatan', 'jenisKegiatans', 'detailKegiatans', 'ruangLingkups'));
    }

    public function update(Request $request, NilaiKegiatan $nilaiKegiatan)
    {
        $validated = $request->validate([
            'jenis_id' => 'required|exists:jenis_kegiatan,id',
            'detail_id' => 'required|exists:detail_kegiatan,id',
            'ruang_id' => 'required|exists:ruang_lingkup,id',
            'nilai' => 'required|integer|min:0',
        ]);

        // Check if combination already exists (excluding current record)
        $exists = NilaiKegiatan::where('jenis_id', $validated['jenis_id'])
            ->where('detail_id', $validated['detail_id'])
            ->where('ruang_id', $validated['ruang_id'])
            ->where('id', '!=', $nilaiKegiatan->id)
            ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Kombinasi jenis, detail, dan ruang lingkup sudah ada.');
        }

        $nilaiKegiatan->update($validated);

        return redirect()->route('admin.nilai-kegiatan.index')
            ->with('success', 'Nilai kegiatan berhasil diperbarui.');
    }

    public function destroy(NilaiKegiatan $nilaiKegiatan)
    {
        $nilaiKegiatan->delete();

        return redirect()->route('admin.nilai-kegiatan.index')
            ->with('success', 'Nilai kegiatan berhasil dihapus.');
    }

    public function getDetails(Request $request)
    {
        $details = DetailKegiatan::where('jenis_id', $request->jenis_id)
            ->orderBy('nama')
            ->get();

        return response()->json($details);
    }
}
