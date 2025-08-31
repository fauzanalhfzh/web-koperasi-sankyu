<?php

namespace App\Filament\Resources\LoanResource\Pages;

use App\Filament\Resources\LoanResource;
use App\Filament\Resources\LoanResource\Widgets\StatsLoanWidget;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Select;
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

            // Cetak semua laporan (tanpa filter)
            Actions\Action::make('generate_laporan')
                ->label('Cetak Semua Laporan')
                ->color('success')
                ->icon('heroicon-o-document-text')
                ->url(fn() => route('laporan-transaksi-pinjaman'))
                ->openUrlInNewTab(),

            // === BARU: Pilih bulan (persis seperti di Simpanan) ===
            ActionGroup::make([
                Action::make('pilih_bulan_pinjaman')
                    ->label('Pilih Bulan')
                    ->color('primary')
                    ->icon('heroicon-o-calendar')
                    ->form([
                        Select::make('bulan')
                            ->label('Bulan')
                            ->options([
                                '01' => 'Januari',
                                '02' => 'Februari',
                                '03' => 'Maret',
                                '04' => 'April',
                                '05' => 'Mei',
                                '06' => 'Juni',
                                '07' => 'Juli',
                                '08' => 'Agustus',
                                '09' => 'September',
                                '10' => 'Oktober',
                                '11' => 'November',
                                '12' => 'Desember',
                            ])
                            ->default(now()->format('m'))
                            ->required(),
                    ])
                    ->action(function ($form) {
                        $bulan = $form->getState()['bulan'];
                        $tahun = now()->format('Y');

                        return redirect(route('laporan-transaksi-pinjaman', [
                            'bulan' => $bulan,
                            'tahun' => $tahun,
                        ]));
                    })
                    ->openUrlInNewTab(),
            ])
                ->label('Cetak Laporan Pinjaman per Bulan')
                ->icon('heroicon-m-ellipsis-vertical')
                ->color('success')
                ->button(),

            // Cetak per tahun (semua bulan)
            Actions\Action::make('generate_laporan_pinjaman_tahun')
                ->label('Cetak Laporan Pinjaman Per Tahun')
                ->color('success')
                ->icon('heroicon-o-document-text')
                ->url(fn() => route('laporan-transaksi-pinjaman', [
                    'bulan' => 'all',
                    'tahun' => now()->format('Y'),
                ]))
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
