<?php

namespace App\Filament\Resources\SteeringCommitteeResource\Pages;

use App\Filament\Resources\SteeringCommitteeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSteeringCommittees extends ListRecords
{
    protected static string $resource = SteeringCommitteeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
