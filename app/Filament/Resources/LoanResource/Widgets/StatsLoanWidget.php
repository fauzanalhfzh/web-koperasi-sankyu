<?php

namespace App\Filament\Resources\LoanResource\Widgets;

use App\Models\Loan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsLoanWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make("Total Pinjaman", Loan::count())
                ->icon('heroicon-o-banknotes')
                ->color('success'),
            Stat::make("Total Jumlah Pinjaman", "Rp." . number_format(Loan::sum('jumlah_pinjaman')), 0, ',', '.')
                ->icon('heroicon-o-currency-dollar')
                ->color('primary'),
        ];
    }
}
