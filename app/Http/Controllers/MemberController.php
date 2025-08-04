<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Member;
use App\Models\Saving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController
{
    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function dashboardAnggota()
    {
        $memberId = session('member_id');
        $member = Member::find($memberId);

        $totalSimpanan = 0;
        $totalPinjaman = 0;
        $cicilanPerbulan = 0;
        $riwayatSimpanan = [];
        $riwayatPinjaman = [];

        if ($member) {
            $totalSimpanan = Saving::where('member_id', $member->id)->sum('jumlah_simpanan');

            $totalPinjaman = Loan::where('member_id', $member->id)
                ->where('status_pinjaman', 'belum_lunas')
                ->sum('jumlah_pinjaman');

            $cicilanPerbulan = Loan::where('member_id', $member->id)
                ->where('status_pinjaman', 'belum_lunas')
                ->sum('cicilan');

            // Ambil riwayat
            $riwayatSimpanan = Saving::where('member_id', $member->id)->latest()->get();
            $riwayatPinjaman = Loan::where('member_id', $member->id)->latest()->get();
        }

        return view('dashboard-anggota', [
            'member' => $member,
            'totalSimpanan' => $totalSimpanan,
            'totalPinjaman' => $totalPinjaman,
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
