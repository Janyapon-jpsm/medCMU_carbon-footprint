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
            ExportColumn::make('month')
                ->formatStateUsing(fn($state) => [
                    1 => 'Jan',
                    2 => 'Feb',
                    3 => 'Mar',
                    4 => 'Apr',
                    5 => 'May',
                    6 => 'Jun',
                    7 => 'Jul',
                    8 => 'Aug',
                    9 => 'Sep',
                    10 => 'Oct',
                    11 => 'Nov',
                    12 => 'Dec',
                ][$state] ?? 'Unknown'),
            ExportColumn::make('year'),
            ExportColumn::make('reductionType.type')
                ->label('Reduction Type'),
            ExportColumn::make('reductionSubType.sub_type')
                ->label('Reduction Sub Type'),
            ExportColumn::make('total_cf')
                ->label('Total Carbon Footprint'),
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
