<?php

namespace App\Filament\Resources\Pages;

use App\Filament\Resources\EmissionTypeResource;
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
