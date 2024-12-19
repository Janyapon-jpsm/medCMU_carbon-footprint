<?php

namespace App\Filament\Resources\EmissionCalculationResource\Pages;

use App\Filament\Resources\EmissionCalculationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmissionCalculation extends EditRecord
{
    protected static string $resource = EmissionCalculationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('ลบ'),
        ];
    }
}
