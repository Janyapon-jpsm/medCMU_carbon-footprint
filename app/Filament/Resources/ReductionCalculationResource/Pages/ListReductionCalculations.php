<?php

namespace App\Filament\Resources\ReductionCalculationResource\Pages;

use App\Filament\Resources\ReductionCalculationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReductionCalculations extends ListRecords
{
    protected static string $resource = ReductionCalculationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
