<?php

namespace App\Filament\Resources\ReductionCalculationResource\Pages;

use App\Filament\Resources\ReductionCalculationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Exports\ReductionCalculationExporter;

class ListReductionCalculations extends ListRecords
{
    protected static string $resource = ReductionCalculationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ExportAction::make()
                ->exporter(ReductionCalculationExporter::class)
                ->label('ส่งออก'),
            Actions\CreateAction::make()
                ->label('สร้าง'),
        ];
    }
}
