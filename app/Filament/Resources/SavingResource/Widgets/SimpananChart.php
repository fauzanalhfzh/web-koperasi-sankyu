<?php

namespace App\Filament\Resources\SavingResource\Widgets;

use App\Models\Saving;
use Filament\Widgets\ChartWidget;

class SimpananChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Pinjaman';

    protected function getData(): array
    {
        // Ambil data simpanan per bulan (jumlah total per bulan)
        $data = Saving::selectRaw('MONTH(tanggal_transaksi) as bulan, SUM(jumlah_simpanan) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        // Inisialisasi data semua bulan agar lengkap (Jan - Dec)
        $monthlyTotals = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyTotals[] = $data[$i] ?? 0; // Gunakan 0 jika tidak ada data
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Simpanan Tahun ' .  now()->year,
                    'data' => $monthlyTotals,
                    'backgroundColor' => '#3b82f6',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
