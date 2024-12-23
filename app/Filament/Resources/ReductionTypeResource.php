<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReductionTypeResource\Pages;
use App\Filament\Resources\ReductionTypeResource\RelationManagers;
use App\Filament\Resources\ReductionTypeResource\RelationManagers\ReductionSubTypesRelationManager;
use App\Models\ReductionType;
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

class ReductionTypeResource extends Resource
{
    protected static ?string $model = ReductionType::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-asia-australia';

    protected static ?string $navigationGroup = 'Reductions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('type')
                    ->required()
                    ->label('ประเภท'),
                TextArea::make('detail')
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
            ReductionSubTypesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReductionTypes::route('/'),
            'create' => Pages\CreateReductionType::route('/create'),
            'edit' => Pages\EditReductionType::route('/{record}/edit'),
        ];
    }
}
