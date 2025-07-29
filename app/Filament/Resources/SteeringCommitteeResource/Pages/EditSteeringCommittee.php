<?php

namespace App\Filament\Resources\SteeringCommitteeResource\Pages;

use App\Filament\Resources\SteeringCommitteeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSteeringCommittee extends EditRecord
{
    protected static string $resource = SteeringCommitteeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
