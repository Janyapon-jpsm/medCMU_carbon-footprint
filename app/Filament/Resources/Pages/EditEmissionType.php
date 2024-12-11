<?php

namespace App\Filament\Resources\Pages;

use App\Filament\Resources\EmissionTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmissionType extends EditRecord
{
    protected static string $resource = EmissionTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('ลบ'),
        ];
    }
}
