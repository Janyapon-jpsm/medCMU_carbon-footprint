<?php

namespace App\Filament\Resources\DataEntryResource\Pages;

use App\Filament\Resources\DataEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataEntry extends EditRecord
{
    protected static string $resource = DataEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
