<?php

namespace App\Filament\Exports;

use App\Models\ReductionCalculation;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ReductionCalculationExporter extends Exporter
{
    protected static ?string $model = ReductionCalculation::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('month'),
            ExportColumn::make('year'),
            ExportColumn::make('re_id'),
            ExportColumn::make('re_sub_id'),
            ExportColumn::make('total_cf'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your reduction calculation export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
