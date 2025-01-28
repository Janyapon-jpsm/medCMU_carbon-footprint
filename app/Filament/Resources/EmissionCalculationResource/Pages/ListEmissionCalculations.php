<?php

namespace App\Filament\Resources\EmissionCalculationResource\Pages;

use App\Filament\Resources\EmissionCalculationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Exports\EmissionCalculationExporter;

class ListEmissionCalculations extends ListRecords
{
    protected static string $resource = EmissionCalculationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ExportAction::make()
                ->exporter(EmissionCalculationExporter::class)
                ->label('ส่งออก'),
            Actions\CreateAction::make()
                ->label('สร้าง'),
        ];
    }
}
