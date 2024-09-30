<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('ชื่อ'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->label('อีเมล'),
                Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->label('หน้าที่'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->afterStateHydrated(function (TextInput $component, $state) {
                        $component->state('');
                    })
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->dehydrated(fn($state) => filled($state))
                    ->maxLength(255)
                    ->label('รหัส'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('ชื่อ'),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->label('อีเมล'),
                Tables\Columns\TextColumn::make('roles')
                    ->sortable()
                    ->searchable()
                    ->label('หน้าที่')
                    ->getStateUsing(function ($record) {
                        if (is_string($record->roles)) {
                            return $record->roles;
                        }
                        return $record->roles->pluck('name')->implode(', ');
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('หน้าที่')
                    ->options([
                        'admin' => 'admin',
                        'operator' => 'operator',
                    ])
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
