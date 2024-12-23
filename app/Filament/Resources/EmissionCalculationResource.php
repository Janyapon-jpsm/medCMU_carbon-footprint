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
                        $emissionSubType = EmissionSubType::find($get('em_sub_id'));

                        if ($emissionSubType) {
                            // Set the emission type ID
                            $set('em_id', $emissionSubType->em_id);

                            // Set the emission type name
                            if ($emissionSubType->emissionType) {
                                $set('em_type_name', $emissionSubType->emissionType->type);
                            } else {
                                $set('em_type_name', 'Unknown');
                            }

                            // Set the emission factor
                            $set('em_factor', $emissionSubType->emission_factor ?? 0);
                        } else {
                            // Reset fields if no subtype is selected
                            $set('em_id', null);
                            $set('em_type_name', 'Unknown');
                            $set('em_factor', 0);
                        }
                    }),
                Hidden::make('em_id')
                    ->required(),
                TextInput::make('em_type_name')
                    ->label('Emission Type')
                    ->required()
                    ->readOnly()
                    ->formatStateUsing(fn($state, $record) => $record?->emissionType?->type ?? null),
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
                    ->placeholder('เช่น 2024')
                    ->numeric()
                    ->required()
                    ->minValue(1900)
                    ->maxValue(2100)
                    ->default(now()->year),
                TextInput::make('amount')
                    ->numeric()
                    ->required()
                    ->reactive() // Ensures the field triggers updates when its value changes
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $amount = $get('amount') ?? 0;
                        $emFactor = $get('em_factor') ?? 0;
                        $set('total_cf', $amount * $emFactor); // Dynamically calculate total
                    }),
                TextInput::make('em_factor')
                    ->label('Emission Factor')
                    ->required()
                    ->readOnly()
                    ->formatStateUsing(fn($state, $record) => $record?->emissionSubType?->emission_factor ?? null)
                    ->reactive() // Ensures updates trigger recalculation
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $amount = $get('amount') ?? 0;
                        $emFactor = $get('em_factor') ?? 0;
                        $set('total_cf', $amount * $emFactor); // Dynamically calculate total
                    }),
                TextInput::make('total_cf')
                    ->label('Carbon Footprint')
                    ->suffix('kg CO2e')
                    ->readOnly(),
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
                TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_cf')
                    ->label('Carbon Footprint (kg CO2e)')
                    ->formatStateUsing(fn($state) => number_format($state, 4))
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
