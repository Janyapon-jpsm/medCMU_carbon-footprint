<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarbonFootprintResource\Pages;
use App\Filament\Resources\CarbonFootprintResource\RelationManagers;
use App\Models\CarbonFootprint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarbonFootprintResource extends Resource
{
    protected static ?string $model = CarbonFootprint::class;

    protected static ?string $navigationIcon = 'heroicon-o-finger-print';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarbonFootprints::route('/'),
            'create' => Pages\CreateCarbonFootprint::route('/create'),
            'edit' => Pages\EditCarbonFootprint::route('/{record}/edit'),
        ];
    }
}
