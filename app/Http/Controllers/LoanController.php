<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController
{
    public function diterima($id)
    {
        $pinjaman = Loan::findOrFail($id);
        $pinjaman->status_pengajuan = 'diterima';
        $pinjaman->save();

        return redirect()->back()->with('success', 'Pengajuan telah disetujui.');
    }

    public function ditolak($id)
    {
        $pinjaman = Loan::findOrFail($id);
        $pinjaman->status_pengajuan = 'ditolak';
        $pinjaman->save();

        return redirect()->back()->with('success', 'Pengajuan telah ditolak.');
    }
}
