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
            ExportColumn::make('month'),
            ExportColumn::make('year'),
            ExportColumn::make('em_id'),
            ExportColumn::make('em_sub_id'),
            ExportColumn::make('total_cf'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your emission calculation export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
