<?php

namespace App\Filament\Resources\SteeringCommitteeResource\Pages;

use App\Filament\Resources\SteeringCommitteeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSteeringCommittee extends CreateRecord
{
    protected static string $resource = SteeringCommitteeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
