<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class MahasiswaPengumumanController extends Controller
{
    /**
     * Display all announcements for mahasiswa.
     */
    public function index(Request $request)
    {
        $query = Pengumuman::where('is_published', true);
        
        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('konten', 'like', "%{$search}%");
            });
        }
        
        $pengumumen = $query->latest()->paginate(10)->withQueryString();
        
        return view('mahasiswa.pengumuman-index', compact('pengumumen'));
    }

    /**
     * Display single announcement.
     */
    public function show(Pengumuman $pengumuman)
    {
        if (!$pengumuman->is_published) {
            abort(404);
        }
        
        return view('mahasiswa.pengumuman-show', compact('pengumuman'));
    }
}
