<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class SteeringCommitteeController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('sc.auth.login');
    }

    // Proses login SC
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('sc')->attempt($credentials)) {
            return redirect()->route('sc.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function index()
    {
        $pengajuanPinjaman = Loan::with('member')
            ->where('status_pengajuan', 'pending')
            ->get();

        return view('sc.dashboard-steering', compact('pengajuanPinjaman'));
    }

    // Logout SC
    public function logout()
    {
        Auth::guard('sc')->logout();
        return redirect()->route('sc.login');
    }

    // Dashboard SC
    public function dashboard()
    {
        $pengajuan = Loan::where('status_pengajuan', 'pending')->get();
        return view('sc.dashboard', compact('pengajuan'));
    }

    // Approve pinjaman
    public function approve(Loan $loan)
    {
        $loan->update(['status_pengajuan' => 'diterima']);
        return back()->with('success', 'Pinjaman berhasil disetujui.');
    }

    // Reject pinjaman
    public function reject(Loan $loan)
    {
        $loan->update(['status_pengajuan' => 'ditolak']);
        return back()->with('success', 'Pinjaman ditolak.');
    }
}
