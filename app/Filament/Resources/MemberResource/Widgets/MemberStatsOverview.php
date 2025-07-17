<?php

namespace App\Filament\Resources\MemberResource\Widgets;

use App\Models\Loan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Models\Saving;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MemberStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Simpanan', Saving::count()),
            Stat::make('Total Pinjaman', Loan::count()),
        ];
    }
}
