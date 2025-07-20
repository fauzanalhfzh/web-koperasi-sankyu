<?php

namespace App\Filament\Resources\LoanResource\Pages;

use App\Filament\Resources\LoanResource;
use App\Filament\Resources\LoanResource\Widgets\StatsLoanWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLoans extends ListRecords
{
    protected static string $resource = LoanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Pinjaman')
                ->icon('heroicon-o-plus'),
            Actions\Action::make('generate_laporan')
                ->label('Cetak Laporan')
                ->color('success')
                ->icon('heroicon-o-document-text')
                ->url(fn() => route('laporan-transaksi-pinjaman'))
                ->openUrlInNewTab(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsLoanWidget::class
        ];
    }
}
