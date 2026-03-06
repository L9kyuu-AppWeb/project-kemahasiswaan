<?php

namespace App\Http\Controllers;

use App\Models\RuangLingkup;
use Illuminate\Http\Request;

class RuangLingkupController extends Controller
{
    public function index()
    {
        $ruangLingkups = RuangLingkup::latest()->paginate(15);
        return view('admin.ruang-lingkup.index', compact('ruangLingkups'));
    }

    public function create()
    {
        return view('admin.ruang-lingkup.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50',
        ]);

        RuangLingkup::create($validated);

        return redirect()->route('admin.ruang-lingkup.index')
            ->with('success', 'Ruang lingkup berhasil ditambahkan.');
    }

    public function edit(RuangLingkup $ruangLingkup)
    {
        return view('admin.ruang-lingkup.edit', compact('ruangLingkup'));
    }

    public function update(Request $request, RuangLingkup $ruangLingkup)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50',
        ]);

        $ruangLingkup->update($validated);

        return redirect()->route('admin.ruang-lingkup.index')
            ->with('success', 'Ruang lingkup berhasil diperbarui.');
    }

    public function destroy(RuangLingkup $ruangLingkup)
    {
        $ruangLingkup->delete();

        return redirect()->route('admin.ruang-lingkup.index')
            ->with('success', 'Ruang lingkup berhasil dihapus.');
    }
}
