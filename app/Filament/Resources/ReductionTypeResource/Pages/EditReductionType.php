<?php

namespace App\Filament\Resources\ReductionTypeResource\Pages;

use App\Filament\Resources\ReductionTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReductionType extends EditRecord
{
    protected static string $resource = ReductionTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('ลบ'),
        ];
    }
}
