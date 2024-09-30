<?php

namespace App\Filament\Resources\DataEntryResource\Pages;

use App\Filament\Resources\DataEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDataEntry extends CreateRecord
{
    protected static string $resource = DataEntryResource::class;
}
