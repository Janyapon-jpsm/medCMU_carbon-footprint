<?php

namespace App\Filament\Clusters\CarbonFootprint\Resources\EmissionTypeResource\Pages;

use App\Filament\Clusters\CarbonFootprint\Resources\EmissionTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmissionType extends CreateRecord
{
    protected static string $resource = EmissionTypeResource::class;
}
