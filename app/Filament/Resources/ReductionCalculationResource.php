<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReductionCalculationResource\Pages;
use App\Models\ReductionCalculation;
use App\Models\ReductionSubType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;


class ReductionCalculationResource extends Resource
{
    protected static ?string $model = ReductionCalculation::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $navigationGroup = 'Reductions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')->default(Auth::id()),
                Select::make('re_sub_id')
                    ->label('Reduction Sub Type')
                    ->relationship('reductionSubType', 'sub_type')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $reductionSubType = ReductionSubType::find($get('re_sub_id'));

                        if ($reductionSubType) {
                            // Set the reduction type ID
                            $set('re_id', $reductionSubType->re_id);

                            // Set the reduction type name
                            if ($reductionSubType->reductionType) {
                                $set('re_type_name', $reductionSubType->reductionType->type);
                            } else {
                                $set('re_type_name', 'Unknown');
                            }

                            // Set the emission factor
                            $set('em_factor', $reductionSubType->emission_factor ?? 0);
                        } else {
                            // Reset fields if no subtype is selected
                            $set('re_id', null);
                            $set('re_type_name', 'Unknown');
                            $set('em_factor', 0);
                        }
                    }),
                Hidden::make('re_id')
                    ->required(),
                TextInput::make('re_type_name')
                    ->label('Reduction Type')
                    ->required()
                    ->readOnly()
                    ->formatStateUsing(fn($state, $record) => $record?->reductionType?->type ?? null),
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
                    ->formatStateUsing(fn($state, $record) => $record?->reductionSubType?->emission_factor ?? null)
                    ->reactive() // Ensures updates trigger recalculation
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $amount = $get('amount') ?? 0;
                        $emFactor = $get('em_factor') ?? 0;
                        $set('total_cf', $amount * $emFactor); // Dynamically calculate total
                    }),
                TextInput::make('total_cf')
                    ->label('Carbon Footprint')
                    ->suffix('kg CO2e')
                    ->required()
                    ->readOnly()
                    ->formatStateUsing(fn($state, $record) => ($record?->amount ?? 0) * ($record?->reductionSubType?->emission_factor ?? 0))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year')
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
                TextColumn::make('reductionType.type')
                    ->label('Reduction Type')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('reductionSubType.sub_type')
                    ->label('Reduction Sub Type')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total_cf')
                    ->label('Carbon Footprint')
                    ->formatStateUsing(fn($state) => number_format($state, 2))
                    ->sortable()
                    ->suffix(' kg CO2e'),
                TextColumn::make('user.user_id')
                    ->label('User ID')
                    ->sortable()
                    ->searchable(),
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
                SelectFilter::make('reduction_type_id')
                    ->label('Reduction Type')
                    ->relationship('reductionType', 'type')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('reduction_sub_type_id')
                    ->label('Reduction Sub Type')
                    ->relationship('reductionSubType', 'sub_type')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('แก้ไข'),
                Tables\Actions\DeleteAction::make()
                    ->label('ลบ'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReductionCalculations::route('/'),
            'create' => Pages\CreateReductionCalculation::route('/create'),
            'edit' => Pages\EditReductionCalculation::route('/{record}/edit'),
        ];
    }
}
