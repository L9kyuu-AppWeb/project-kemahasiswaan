<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show unified login page.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle unified login for admin and mahasiswa.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Try admin guard first
        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        // Try mahasiswa guard
        if (Auth::guard('mahasiswa')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('mahasiswa.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Generic logout - redirects based on current guard.
     */
    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('mahasiswa')->check()) {
            Auth::guard('mahasiswa')->logout();
        }
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    /**
     * Logout for admin.
     */
    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    /**
     * Logout for mahasiswa.
     */
    public function mahasiswaLogout(Request $request)
    {
        Auth::guard('mahasiswa')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    /**
     * Admin dashboard.
     */
    public function adminDashboard()
    {
        $totalMahasiswa = \App\Models\Mahasiswa::count();
        $totalProgramStudi = \App\Models\ProgramStudi::count();
        $mahasiswaPerProdi = \App\Models\Mahasiswa::selectRaw('program_studi_id, count(*) as total')
            ->groupBy('program_studi_id')
            ->with('programStudi')
            ->get();
        $mahasiswaPerTahun = \App\Models\Mahasiswa::selectRaw('tahun_masuk, count(*) as total')
            ->groupBy('tahun_masuk')
            ->orderBy('tahun_masuk', 'desc')
            ->get();

        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalProgramStudi',
            'mahasiswaPerProdi',
            'mahasiswaPerTahun'
        ));
    }

    /**
     * Mahasiswa dashboard.
     */
    public function mahasiswaDashboard()
    {
        $mahasiswa = auth()->guard('mahasiswa')->user();
        
        // Get beasiswa status
        $beasiswaAktif = \App\Models\MahasiswaBeasiswa::with('beasiswaTipe')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'aktif')
            ->first();
        
        // Get kegiatan count
        $totalKegiatan = \App\Models\Kegiatan::where('is_published', true)->count();
        
        // Get pengumuman terbaru
        $pengumumanTerbaru = \App\Models\Pengumuman::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        return view('mahasiswa.dashboard', compact(
            'mahasiswa',
            'beasiswaAktif',
            'totalKegiatan',
            'pengumumanTerbaru'
        ));
    }

    // Admin Profile
    public function adminProfile()
    {
        return view('admin.profile', [
            'admin' => Auth::guard('admin')->user()
        ]);
    }

    public function adminProfileUpdate(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];

        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    // Mahasiswa Profile
    public function mahasiswaProfile()
    {
        return view('mahasiswa.profile', [
            'mahasiswa' => Auth::guard('mahasiswa')->user()
        ]);
    }

    public function mahasiswaProfileUpdate(Request $request)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswas,nim,' . $mahasiswa->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:mahasiswas,email,' . $mahasiswa->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $mahasiswa->nim = $validated['nim'];
        $mahasiswa->name = $validated['name'];
        $mahasiswa->email = $validated['email'];

        if (!empty($validated['password'])) {
            $mahasiswa->password = Hash::make($validated['password']);
        }

        $mahasiswa->save();

        return redirect()->route('mahasiswa.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
