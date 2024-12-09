<?php

namespace App\Filament\Resources\ReductionTypeResource\Pages;

use App\Filament\Resources\ReductionTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReductionTypes extends ListRecords
{
    protected static string $resource = ReductionTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('สร้างใหม่'),
        ];
    }
}
