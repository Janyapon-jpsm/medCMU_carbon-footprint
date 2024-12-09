<?php

namespace App\Filament\Clusters\CarbonFootprint\Resources\EmissionTypeResource\Pages;

use App\Filament\Clusters\CarbonFootprint\Resources\EmissionTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmissionTypes extends ListRecords
{
    protected static string $resource = EmissionTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('สร้าง'),
        ];
    }
}
