<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class laporanTransaksiController extends Controller
{
    public function laporan_transaksi()
    {
        $simpanan = \App\Models\Saving::with('member')->get();
        $pinjaman = \App\Models\Loan::with('member')->get();
        return view('generate-pdf.laporan-transakaksi', compact('simpanan', 'pinjaman'));
    }

    public function laporan_anggota($id)
    {
        $anggota = \App\Models\Member::findOrFail($id);
        $simpanan = \App\Models\Saving::where('member_id', $id)->get();
        $pinjaman = \App\Models\Loan::where('member_id', $id)->get();
        $cicilan = \App\Models\Loan::where('member_id', $id)->value('cicilan');

        return view('generate-pdf.laporan-anggota', compact('anggota', 'simpanan', 'pinjaman', 'cicilan'));
    }
}
