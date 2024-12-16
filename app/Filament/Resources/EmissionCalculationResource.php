<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmissionCalculationResource\Pages;
use App\Filament\Resources\EmissionCalculationResource\RelationManagers;
use App\Models\EmissionCalculation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmissionCalculationResource extends Resource
{
    protected static ?string $model = EmissionCalculation::class;

    protected static ?string $navigationIcon = 'heroicon-o-stack';

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
            'index' => Pages\ListEmissionCalculations::route('/'),
            'create' => Pages\CreateEmissionCalculation::route('/create'),
            'edit' => Pages\EditEmissionCalculation::route('/{record}/edit'),
        ];
    }
}
