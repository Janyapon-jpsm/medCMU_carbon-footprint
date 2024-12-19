<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmissionCalculationResource\Pages;
use App\Filament\Resources\EmissionCalculationResource\RelationManagers;
use App\Models\EmissionCalculation;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use App\Models\EmissionType;
use App\Models\EmissionSubType;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

use function Laravel\Prompts\text;

class EmissionCalculationResource extends Resource
{

    protected static ?string $model = EmissionCalculation::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $navigationGroup = 'Emissions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                Select::make('em_id')
                    ->label('Emission Type')
                    ->relationship('emissionType', 'type')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('em_sub_id')
                    ->label('Emission Sub Type')
                    ->relationship('emissionSubType', 'sub_type')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('amount')
                    ->numeric()
                    ->required(),
                TextInput::make('month')
                    ->placeholder('Enter month as number (1-12)')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->maxValue(12),
                TextInput::make('year')
                    ->placeholder('e.g., 2024')
                    ->numeric()
                    ->required()
                    ->minValue(1900)
                    ->maxValue(2100)
                    ->default(now()->year),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('emissionType.type')
                    ->label('Emission Type')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('emissionSubType.sub_type')
                    ->label('Emission Sub Type')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('amount')
                    ->numeric()
                    ->formatStateUsing(fn($state) => number_format($state, 4))
                    ->sortable(),
                TextColumn::make('month')
                    ->formatStateUsing(fn($state) => [
                        1 => 'Jan',
                        2 => 'Feb',
                        3 => 'Mar',
                        4 => 'Apr',
                        5 => 'May',
                        6 => 'Jun',
                        7 => 'Jul',
                        8 => 'Aug',
                        9 => 'Sep',
                        10 => 'Oct',
                        11 => 'Nov',
                        12 => 'Dec',
                    ][$state] ?? 'Unknown'),
                TextColumn::make('year')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('emission_type_id')
                    ->label('Emission Type')
                    ->relationship('emissionType', 'type')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('emission_sub_type_id')
                    ->label('Emission Sub Type')
                    ->relationship('emissionSubType', 'sub_type')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
