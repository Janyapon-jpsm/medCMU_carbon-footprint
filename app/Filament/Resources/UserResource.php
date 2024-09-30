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
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Forms\Components\Select::make('role')
                    ->required()
                    ->label('หน้าที่')
                    ->options([
                        'operator' => 'Operator',
                        'admin' => 'Admin',
                    ]),
                Forms\Components\TextInput::make('password')
                    ->password()
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
                Tables\Columns\TextColumn::make('role')
                    ->sortable()
                    ->searchable()
                    ->label('หน้าที่'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('หน้าที่')
                    ->options([
                        'admin' => 'Admin',
                        'operator' => 'Operator',
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
