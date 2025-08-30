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
            Actions\Action::make('add_simpanan_wajib_400rb')
                ->label('Add Simpanan Wajib Otomatis')
                ->color('warning')  // Warna kuning
                ->icon('heroicon-o-plus-circle')
                ->action(function () {
                    $this->addSimpanan400rb(); // Aksi menambah simpanan
                }),
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

    public function addSimpanan400rb()
    {
        $members = \App\Models\Member::all();

        foreach ($members as $member) {
            \App\Models\Saving::create([
                'member_id' => $member->id,
                'jenis_simpanan' => 'wajib',  // Tetapkan jenis_simpanan ke 'wajib'
                'jumlah_simpanan' => 400000,  // Tetapkan jumlah_simpanan ke 400.000
                'tanggal_transaksi' => now(),
                'keterangan' => 'Simpanan Wajib 400rb',
            ]);
        }

        // Return success notification
        \Filament\Notifications\Notification::make()
            ->title('Simpanan Wajib 400rb berhasil ditambahkan ke semua anggota.')
            ->success()
            ->send();
    }
}
