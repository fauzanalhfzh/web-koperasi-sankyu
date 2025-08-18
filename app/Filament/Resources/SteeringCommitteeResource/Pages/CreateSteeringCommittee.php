<?php

namespace App\Filament\Resources\SteeringCommitteeResource\Pages;

use App\Filament\Resources\SteeringCommitteeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateSteeringCommittee extends CreateRecord
{
    protected static string $resource = SteeringCommitteeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
