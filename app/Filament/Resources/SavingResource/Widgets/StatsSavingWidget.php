<?php

namespace App\Filament\Resources\SavingResource\Widgets;

use App\Models\Saving;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsSavingWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make("Total Simpanan", Saving::count())
                ->icon('heroicon-o-banknotes')
                ->color('success'),
            Stat::make("Total Jumlah Simpanan", "Rp." . number_format(Saving::sum('jumlah_simpanan')), 0, ',', '.')
                ->icon('heroicon-o-currency-dollar')
                ->color('primary'),
        ];
    }
}
