<?php

namespace App\Filament\Resources\SavingResource\Pages;

use App\Filament\Resources\SavingResource;
use App\Filament\Resources\SavingResource\Widgets\StatsSavingWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSavings extends ListRecords
{
    protected static string $resource = SavingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Simpanan')
                ->icon('heroicon-o-plus'),
            Actions\Action::make('generate_laporan')
                ->label('Cetak Semua Laporan')
                ->color('success')
                ->icon('heroicon-o-document-text')
                ->url(fn() => route('laporan-transaksi-simpanan'))
                ->openUrlInNewTab(),
            Actions\Action::make('generate_laporan_perbulan')
                ->label('Cetak Laporan Per Bulan')
                ->color('success')
                ->icon('heroicon-o-document-text')
                ->url(fn() => route('laporan-transaksi-simpanan', ['bulan' => now()->format('m'), 'tahun' => now()->format('Y')]))
                ->openUrlInNewTab(),
            Actions\Action::make('generate_laporan_pertahun')
                ->label('Cetak Laporan Per Tahun')
                ->color('success')
                ->icon('heroicon-o-document-text')
                ->url(fn() => route('laporan-transaksi-simpanan', ['bulan' => 'all', 'tahun' => now()->format('Y')]))
                ->openUrlInNewTab(),

        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsSavingWidget::class
        ];
    }
}
