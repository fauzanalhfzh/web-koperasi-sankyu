<?php

namespace App\Filament\Resources\MemberResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsMemberWidget extends BaseWidget
{


    public ?\App\Models\Member $record = null;

    protected function getStats(): array
    {
        $memberId = $this->record?->id;
        return [
            Stat::make(
                "Total Simpanan Pokok",
                'Rp ' . number_format(
                    \App\Models\Saving::where('jenis_simpanan', 'pokok')
                        ->where('member_id', $memberId)
                        ->sum('jumlah_simpanan'),
                    0,
                    ',',
                    '.'
                )
            )
                ->icon('heroicon-o-currency-dollar')
                ->color('primary'),
            Stat::make(
                "Total Simpanan Wajib",
                'Rp ' . number_format(
                    \App\Models\Saving::where('jenis_simpanan', 'wajib')
                        ->where('member_id', $memberId)
                        ->sum('jumlah_simpanan'),
                    0,
                    ',',
                    '.'
                )
            )
                ->icon('heroicon-o-currency-dollar')
                ->color('secondary'),
            Stat::make(
                "Total Pinjaman Disetujui",
                'Rp ' . number_format(
                    \App\Models\Loan::where('member_id', $memberId)
                        ->where('status_pengajuan', 'diterima')
                        ->sum('jumlah_pinjaman'),
                    0,
                    ',',
                    '.'
                )
            )
                ->icon('heroicon-o-banknotes')
                ->color('success'),
        ];
    }
}
