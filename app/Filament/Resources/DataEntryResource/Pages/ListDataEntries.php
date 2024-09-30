<?php

namespace App\Filament\Resources\DataEntryResource\Pages;

use App\Filament\Resources\DataEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDataEntries extends ListRecords
{
    protected static string $resource = DataEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
