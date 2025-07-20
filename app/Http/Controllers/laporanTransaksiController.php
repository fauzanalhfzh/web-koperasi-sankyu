<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mpdf\Mpdf;

class laporanTransaksiController extends Controller
{
    public function laporan_transaksi()
    {
        $simpanan = \App\Models\Saving::with('member')->get();
        $pinjaman = \App\Models\Loan::with('member')->get();

        // Render Blade view menjadi HTML string
        $html = view('generate-pdf.laporan-transaksi', compact('simpanan', 'pinjaman'))->render();

        // Buat instance mPDF
        $mpdf = new Mpdf();

        // Tulis HTML ke PDF
        $mpdf->WriteHTML($html);

        // Output PDF langsung ke browser
        return response($mpdf->Output('laporan-transaksi.pdf', 'I'), 200)
            ->header('Content-Type', 'application/pdf');
    }

    public function laporan_anggota($id)
    {
        $anggota = \App\Models\Member::findOrFail($id);
        $simpanan = \App\Models\Saving::where('member_id', $id)->get();
        $pinjaman = \App\Models\Loan::where('member_id', $id)->get();
        $cicilan = \App\Models\Loan::where('member_id', $id)->value('cicilan');
        $jangka_waktu = \App\Models\Loan::where('member_id', $id)->value('jangka_waktu');

        // Render Blade view menjadi HTML string
        $html = view('generate-pdf.laporan-anggota', compact('anggota', 'simpanan', 'pinjaman', 'cicilan', 'jangka_waktu'))->render();

        // Buat instance mPDF
        $mpdf = new \Mpdf\Mpdf();

        // Tulis HTML ke PDF
        $mpdf->WriteHTML($html);

        // Output PDF langsung ke browser
        return response($mpdf->Output('laporan-anggota.pdf', 'I'), 200)
            ->header('Content-Type', 'application/pdf');
    }
}
