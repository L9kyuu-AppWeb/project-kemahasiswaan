<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Imports\MahasiswaImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Mahasiswa::with('programStudi');

        // Filter by tahun_masuk
        if ($request->filled('tahun_masuk')) {
            $query->where('tahun_masuk', $request->tahun_masuk);
        }

        // Filter by program_studi_id
        if ($request->filled('program_studi_id')) {
            $query->where('program_studi_id', $request->program_studi_id);
        }

        // Search by name or nim
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $mahasiswas = $query->latest()->paginate(10)->withQueryString();

        // Get distinct tahun_masuk for filter dropdown
        $tahunList = Mahasiswa::select('tahun_masuk')
            ->distinct()
            ->orderBy('tahun_masuk', 'desc')
            ->pluck('tahun_masuk');

        // Get all program studi for filter dropdown
        $programStudiList = \App\Models\ProgramStudi::orderBy('nama')->get();

        return view('admin.mahasiswa.index', compact('mahasiswas', 'tahunList', 'programStudiList'));
    }

    /**
     * Show form for importing mahasiswa from Excel.
     */
    public function showImportForm()
    {
        $programStudiList = ProgramStudi::orderBy('nama')->get();
        return view('admin.mahasiswa.import', compact('programStudiList'));
    }

    /**
     * Import mahasiswa from Excel file.
     */
    public function importExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $file = $request->file('file');
            
            // Import Excel
            $import = new MahasiswaImport;
            Excel::import($import, $file);

            // Check for failures
            $failures = $import->failures();
            
            if ($failures->isNotEmpty()) {
                // There were some failures, show them
                $failureMessages = [];
                foreach ($failures as $failure) {
                    $failureMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
                }
                
                return redirect()->back()
                    ->with('warning', 'Sebagian data gagal diimport.')
                    ->with('failures', $failureMessages);
            }

            return redirect()->route('admin.mahasiswa.index')
                ->with('success', 'Mahasiswa berhasil diimport dari Excel. Data dengan NIM atau email yang sudah ada akan dilewati.');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $failureMessages = [];
            
            foreach ($failures as $failure) {
                $failureMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            
            return redirect()->back()
                ->with('error', 'Validasi gagal. Silakan perbaiki data Anda.')
                ->with('failures', $failureMessages);
        } catch (\RuntimeException $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengimport file: ' . $e->getMessage());
        }
    }

    /**
     * Download Excel template.
     */
    public function downloadTemplate()
    {
        return Excel::download(new \App\Exports\MahasiswaTemplateExport, 'template_mahasiswa.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programStudiList = \App\Models\ProgramStudi::orderBy('nama')->get();
        return view('admin.mahasiswa.create', compact('programStudiList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswas,nim',
            'tahun_masuk' => 'required|string|max:4',
            'program_studi_id' => 'nullable|exists:program_studis,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:mahasiswas,email',
            'password' => 'required|min:6',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Mahasiswa::create($validated);

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        $programStudiList = \App\Models\ProgramStudi::orderBy('nama')->get();
        return view('admin.mahasiswa.edit', compact('mahasiswa', 'programStudiList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validated = $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswas,nim,' . $mahasiswa->id,
            'tahun_masuk' => 'required|string|max:4',
            'program_studi_id' => 'nullable|exists:program_studis,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:mahasiswas,email,' . $mahasiswa->id,
            'password' => 'nullable|min:6',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $mahasiswa->update($validated);

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil dihapus.');
    }
}
