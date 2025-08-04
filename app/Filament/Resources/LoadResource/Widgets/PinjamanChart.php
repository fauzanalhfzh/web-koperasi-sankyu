<?php

namespace App\Filament\Resources\LoadResource\Widgets;

use App\Models\Loan;
use Filament\Widgets\ChartWidget;

class PinjamanChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Pinjaman per Bulan';



    protected function getData(): array
    {
        // Ambil total pinjaman per bulan
        $data = Loan::selectRaw('MONTH(tanggal_pengajuan) as bulan, SUM(jumlah_pinjaman) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        // Siapkan array total per bulan (Jan - Dec)
        $monthlyTotals = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyTotals[] = $data[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Pinjaman tahun ' .  now()->year,
                    'data' => $monthlyTotals,
                    'backgroundColor' => '#10b981',
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
