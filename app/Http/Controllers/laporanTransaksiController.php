<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mpdf\Mpdf;

class laporanTransaksiController extends Controller
{
    public function laporan_transaksi_pinjaman(Request $request)
    {
        // Ambil bulan dan tahun dari URL
        $bulan = $request->input('bulan', now()->format('m'));
        $tahun = $request->input('tahun', now()->format('Y'));

        // Jika bulan adalah 'all', maka ambil data untuk seluruh tahun
        if ($bulan == 'all') {
            $pinjaman = Loan::with('member')
                ->whereYear('tanggal_pengajuan', $tahun)  // Filter berdasarkan tahun
                ->get();
        } else {
            // Jika bulan diberikan, ambil data untuk bulan dan tahun tertentu
            $pinjaman = Loan::with('member')
                ->whereMonth('tanggal_pengajuan', $bulan)  // Filter berdasarkan bulan
                ->whereYear('tanggal_pengajuan', $tahun)   // Filter berdasarkan tahun
                ->get();
        }

        // Render Blade view menjadi HTML string
        $html = view('generate-pdf.laporan-transaksi-pinjaman', compact('pinjaman', 'bulan', 'tahun'))->render();

        // Buat instance mPDF
        $mpdf = new Mpdf();

        // Tulis HTML ke PDF
        $mpdf->WriteHTML($html);

        // Output PDF langsung ke browser
        return response($mpdf->Output('laporan-transaksi-pinjaman.pdf', 'I'), 200)
            ->header('Content-Type', 'application/pdf');
    }

    public function laporan_transaksi_simpanan(Request $request)
    {
        // Ambil bulan dan tahun dari URL
        $bulan = $request->input('bulan', now()->format('m'));
        $tahun = $request->input('tahun', now()->format('Y'));

        // Jika bulan 'all', ambil laporan untuk seluruh tahun
        if ($bulan == 'all') {
            $simpanan = \App\Models\Saving::with('member')
                ->whereYear('tanggal_transaksi', $tahun)  // Filter berdasarkan tahun
                ->get();
        } else {
            $simpanan = \App\Models\Saving::with('member')
                ->whereMonth('tanggal_transaksi', $bulan)  // Filter berdasarkan bulan
                ->whereYear('tanggal_transaksi', $tahun)   // Filter berdasarkan tahun
                ->get();
        }

        // Render Blade view menjadi HTML string
        $html = view('generate-pdf.laporan-transaksi-simpanan', compact('simpanan', 'bulan', 'tahun'))->render();

        // Buat instance mPDF
        $mpdf = new Mpdf();

        // Tulis HTML ke PDF
        $mpdf->WriteHTML($html);

        // Output PDF langsung ke browser
        return response($mpdf->Output('laporan-transaksi-simpanan.pdf', 'I'), 200)
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
