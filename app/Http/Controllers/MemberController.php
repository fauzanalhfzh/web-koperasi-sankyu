<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Member;
use App\Models\Saving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class MemberController  extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function dashboardAnggota()
    {
        // Ambil member yang sedang login lewat guard 'members'
        $member = Auth::guard('member')->user();

        if (!$member) {
            return redirect()->route('login')->withErrors(['Anda harus login terlebih dahulu.']);
        }

        // Hitung total simpanan, pinjaman, dan cicilan
        $totalSimpanan = $member->simpanan()->sum('jumlah_simpanan');

        $totalPinjaman = $member->pinjaman()
            ->where('status_pinjaman', 'belum_lunas')
            ->sum('jumlah_pinjaman');

        $cicilanPerbulan = $member->pinjaman()
            ->where('status_pinjaman', 'belum_lunas')
            ->sum('cicilan');

        // Ambil riwayat simpanan & pinjaman
        $riwayatSimpanan = $member->simpanan()->latest()->get();
        $riwayatPinjaman = $member->pinjaman()->latest()->get();

        return view('dashboard-anggota', [
            'member'          => $member,
            'totalSimpanan'   => $totalSimpanan,
            'totalPinjaman'   => $totalPinjaman,
            'cicilanPerbulan' => $cicilanPerbulan,
            'riwayatSimpanan' => $riwayatSimpanan,
            'riwayatPinjaman' => $riwayatPinjaman,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // 🔹 Debug credentials
        logger('Login credentials:', $credentials);

        if (Auth::guard('member')->attempt($credentials)) {
            $request->session()->regenerate();
            logger('Login successful for member: ' . $request->email);
            return redirect()->route('dashboard-anggota');
        }

        logger('Login failed for member: ' . $request->email);

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }


    public function logout(Request $request)
    {
        Auth::guard('member')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
