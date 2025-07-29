<?php

namespace App\Filament\Resources\SteeringCommitteeResource\Pages;

use App\Filament\Resources\SteeringCommitteeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSteeringCommittee extends ViewRecord
{
    protected static string $resource = SteeringCommitteeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
