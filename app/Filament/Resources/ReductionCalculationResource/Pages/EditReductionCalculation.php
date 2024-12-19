<?php

namespace App\Filament\Resources\ReductionCalculationResource\Pages;

use App\Filament\Resources\ReductionCalculationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReductionCalculation extends EditRecord
{
    protected static string $resource = ReductionCalculationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
