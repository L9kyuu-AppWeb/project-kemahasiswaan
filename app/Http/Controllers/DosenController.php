<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    /**
     * Display list of dosen for admin.
     */
    public function index(Request $request)
    {
        $query = Dosen::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nuptk', 'like', "%{$search}%");
            });
        }

        $dosens = $query->paginate(15);

        return view('admin.dosen.index', compact('dosens'));
    }

    /**
     * Show form to create new dosen.
     */
    public function create()
    {
        return view('admin.dosen.create');
    }

    /**
     * Store new dosen.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nuptk' => 'required|string|max:30|unique:dosens,nuptk',
            'nama' => 'required|string|max:150',
        ]);

        Dosen::create($validated);

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil ditambahkan.');
    }

    /**
     * Show detail dosen for admin.
     */
    public function show(Dosen $dosen)
    {
        return view('admin.dosen.show', compact('dosen'));
    }

    /**
     * Show form to edit dosen.
     */
    public function edit(Dosen $dosen)
    {
        return view('admin.dosen.edit', compact('dosen'));
    }

    /**
     * Update dosen.
     */
    public function update(Request $request, Dosen $dosen)
    {
        $validated = $request->validate([
            'nuptk' => 'required|string|max:30|unique:dosens,nuptk,' . $dosen->id,
            'nama' => 'required|string|max:150',
        ]);

        $dosen->update($validated);

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil diperbarui.');
    }

    /**
     * Delete dosen.
     */
    public function destroy(Dosen $dosen)
    {
        $dosen->delete();

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil dihapus.');
    }
}
