<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmissionTypeResource\Pages;
use App\Filament\Resources\EmissionTypeResource\RelationManagers;
use App\Filament\Resources\EmissionTypeResource\RelationManagers\EmissionSubTypesRelationManager;
use App\Models\EmissionType;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmissionTypeResource extends Resource
{
    protected static ?string $model = EmissionType::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';


    protected static ?string $navigationGroup = 'Emissions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('type')
                    ->required()
                    ->label('ประเภท'),
                Textarea::make('detail')
                    ->label('คำอธิบาย'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label('ประเภท'),
                TextColumn::make('detail')
                    ->label('คำอธิบาย'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('แก้ไข'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('ลบทั้งหมด'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            EmissionSubTypesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmissionTypes::route('/'),
            'create' => Pages\CreateEmissionType::route('/create'),
            'edit' => Pages\EditEmissionType::route('/{record}/edit'),
        ];
    }
}
