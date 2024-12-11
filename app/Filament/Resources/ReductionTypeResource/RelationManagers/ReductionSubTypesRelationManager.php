<?php

namespace App\Filament\Resources\ReductionTypeResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReductionSubTypesRelationManager extends RelationManager
{
    protected static string $relationship = 'reductionSubTypes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('sub_type')
                    ->label('ชื่อหมวดย่อย'),
                TextInput::make('emission_factor')
                    ->numeric(),
                TextInput::make('unit')
                    ->label('หน่วย'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('sub_type')
                    ->label('ชื่อหมวดย่อย'),
                TextColumn::make('emission_factor'),
                TextColumn::make('unit')
                    ->label('หน่วย'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('สร้าง'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('แก้ไข'),
                Tables\Actions\DeleteAction::make()
                    ->label('ลบ'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
