<?php

namespace App\Filament\Resources\MasterResource\Pages;

use App\Filament\Resources\MasterResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMaster extends CreateRecord
{
    protected static string $resource = MasterResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
