<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Member;
use App\Models\Saving;
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
        $totalSimpanan = Saving::sum('jumlah_simpanan');

        $totalPinjaman = Loan::where('status_pengajuan', 'diterima')
            ->sum('jumlah_pinjaman');

        $pengajuanPinjaman = Loan::with('member')
            ->where('status_pengajuan', 'pending')
            ->get();

        return view('sc.dashboard-steering', compact('pengajuanPinjaman', 'totalSimpanan', 'totalPinjaman'));
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

    public function riwayatPinjamanAnggota($memberId)
    {
        $member = Member::findOrFail($memberId);

        $riwayatPinjaman = Loan::where('member_id', $memberId)
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();

        return view('sc.riwayat-pinjaman-anggota', compact('member', 'riwayatPinjaman'));
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

    public function edit($id)
    {
        // Ambil data pinjaman berdasarkan ID
        $pinjaman = Loan::findOrFail($id);

        // Tampilkan halaman edit dengan data pinjaman
        return view('sc.edit-pinjaman', compact('pinjaman'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang dikirim dari form
        $request->validate([
            'jumlah_pinjaman' => 'required|numeric',
            'jangka_waktu' => 'required|numeric',
        ]);

        // Cari data pinjaman
        $pinjaman = Loan::findOrFail($id);

        // Update data pinjaman
        $pinjaman->update([
            'jumlah_pinjaman' => $request->jumlah_pinjaman,
            'jangka_waktu' => $request->jangka_waktu,
        ]);

        // Redirect kembali ke halaman pengajuan pinjaman
        return redirect()->route('sc.dashboard')->with('success', 'Pinjaman berhasil diperbarui.');
    }
}
