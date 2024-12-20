<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmissionCalculationResource\Pages;
use App\Models\EmissionCalculation;
use App\Models\EmissionSubType;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;

class EmissionCalculationResource extends Resource
{
    protected static ?string $model = EmissionCalculation::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $navigationGroup = 'Emissions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')->default(Auth::id()),
                Select::make('em_sub_id')
                    ->label('Emission Sub Type')
                    ->relationship('emissionSubType', 'sub_type')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $emissionSubType = EmissionSubType::findOrFail($get('em_sub_id'));
                        $set('em_id', $emissionSubType->em_id);
                        if ($emissionSubType->emissionType) {
                            $set('em_type_name', $emissionSubType->emissionType->type); // Using 'type' column 
                        } else {
                            $set('em_type_name', 'Unknown');
                        }
                    }),
                Hidden::make('em_id')
                    ->required(),
                TextInput::make('em_type_name')
                    ->label('Emission Type')
                    ->required()
                    ->disabled(),
                TextInput::make('amount')
                    ->numeric()
                    ->required(),
                Select::make('month')
                    ->label('Month')
                    ->required()
                    ->options([
                        1 => 'Jan',
                        2 => 'Feb',
                        3 => 'Mar',
                        4 => 'Apr',
                        5 => 'May',
                        6 => 'Jun',
                        7 => 'Jul',
                        8 => 'Aug',
                        9 => 'Sept',
                        10 => 'Oct',
                        11 => 'Nov',
                        12 => 'Dec',
                    ])
                    ->preload()
                    ->searchable(),
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
