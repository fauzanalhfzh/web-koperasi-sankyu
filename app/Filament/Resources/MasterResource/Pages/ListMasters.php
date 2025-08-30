<?php

namespace App\Filament\Resources\MasterResource\Pages;

use App\Filament\Resources\MasterResource;
use App\Models\Loan;
use App\Models\Master;
use App\Models\Saving;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListMasters extends ListRecords
{
    protected static string $resource = MasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('fetch_saving_loan')
                ->label('Fetch Data Simpanan')
                ->icon('heroicon-s-arrow-path') // Bisa ganti dengan icon lain
                ->action(function () {
                    $this->fetchAndInsertToMaster();
                }),
        ];
    }

    protected function fetchAndInsertToMaster()
    {
        $savingData = Saving::where('jenis_simpanan', 'wajib')->get();

        if ($savingData->isEmpty()) {
            Notification::make()
                ->title('Data Saving tidak ditemukan!')
                ->warning()
                ->send();
            return;
        }

        foreach ($savingData as $saving) {
            // Insert data ke tabel Master
            Master::create([
                'saving_id' => $saving->id,
                'jenis_simpanan' => $saving->jenis_simpanan,
                'jumlah_simpanan' => $saving->jumlah_simpanan,
            ]);
        }

        Notification::make()
            ->title('Data Saving berhasil dimasukkan ke Master!')
            ->success()
            ->send();
    }
}
