<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController
{
    public function showLoginForm()
    {
        return view('welcome');
    }

    public function dashboardAnggota()
    {
        $memberId = session('member_id');
        $member = Member::find($memberId);

        // Sum total simpanan dari tabel simpanan (misal: savings)
        $totalSimpanan = 0;
        if ($member) {
            $totalSimpanan = \App\Models\Saving::where('member_id', $member->id)->sum('jumlah_simpanan');
            $totalPinjaman = \App\Models\Loan::where('member_id', $member->id)
                ->where('status_pinjaman', 'belum_lunas')
                ->sum('jumlah_pinjaman');
            $cicilanPerbulan = \App\Models\Loan::where('member_id', $member->id)
                ->where('status_pinjaman', 'belum_lunas')
                ->sum('cicilan');
        } else {
            $totalSimpanan = 0;
            $totalPinjaman = 0;
            $cicilanPerbulan = 0;
        }

        return view('dashboard-anggota', [
            'totalSimpanan' => $totalSimpanan,
            'totalPinjaman' => $totalPinjaman,
            'cicilanPerbulan' => $cicilanPerbulan,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Cek kredensial di tabel member
        $member = Member::where('email', $request->email)->first();
        if ($member && Hash::check($request->password, $member->password)) {
            // Simpan session login manual
            session(['member_id' => $member->id]);
            return redirect()->intended('/dashboard-anggota'); // Ganti sesuai halaman dashboard Anda
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('member_id');
        return redirect('/login');
    }
}
