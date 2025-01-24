<?php

namespace App\Filament\Exports;

use App\Models\EmissionCalculation;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class EmissionCalculationExporter extends Exporter
{
    protected static ?string $model = EmissionCalculation::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('create_at'),
            ExportColumn::make('month')
                ->label('Month'),
            ExportColumn::make('year')
                ->label('Year'),
            ExportColumn::make('emissionType.type')
                ->label('Emission Type'),
            ExportColumn::make('emissionSubType.sub_type')
                ->label('Emission Sub Type'),
            ExportColumn::make('total_cf')
                ->label('Total Carbon Footprint')
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your emission calculations export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
