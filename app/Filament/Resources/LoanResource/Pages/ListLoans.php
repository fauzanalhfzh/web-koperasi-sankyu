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
                ->label('Cetak Semua Laporan')
                ->color('success')
                ->icon('heroicon-o-document-text')
                ->url(fn() => route('laporan-transaksi-pinjaman'))
                ->openUrlInNewTab(),
            Actions\Action::make('generate_laporan_pinjaman_bulan')
                ->label('Cetak Laporan Pinjaman Per Bulan')
                ->color('success')
                ->icon('heroicon-o-document-text')
                ->url(fn() => route('laporan-transaksi-pinjaman', ['bulan' => now()->format('m'), 'tahun' => now()->format('Y')]))
                ->openUrlInNewTab(),
            Actions\Action::make('generate_laporan_pinjaman_tahun')
                ->label('Cetak Laporan Pinjaman Per Tahun')
                ->color('success')
                ->icon('heroicon-o-document-text')
                ->url(fn() => route('laporan-transaksi-pinjaman', ['bulan' => 'all', 'tahun' => now()->format('Y')]))
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
