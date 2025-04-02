<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Facades\Filament;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->required(),
                
                TextInput::make('email')
                ->email()
                ->unique(ignoreRecord: true)
                ->required(),
                
                Forms\Components\TextInput::make('password')
                ->label('Password')
                ->password()
                ->maxLength(255)
                ->dehydrateStateUsing(fn ($state, $record) => 
                    filled($state) ? bcrypt($state) : $record->password // Keep old password if empty
                )
                ->required(fn ($record) => $record === null) // Required only for new users
                ->nullable(),

                // Checkbox to set admin role
                Toggle::make('is_admin')
                ->label('Admin')
                ->required()
                ->hidden(fn () => !Filament::auth()->user()?->isAdmin()), // Only show this field if the logged-in user is an admin
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('id')
                ->sortable(),
            Tables\Columns\TextColumn::make('name')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('email')
                ->sortable()
                ->searchable(),

            Tables\Columns\IconColumn::make('is_admin')
                ->label('Admin')
                ->boolean(), // Displays as a true/false icon

            Tables\Columns\TextColumn::make('created_at')
                ->label('Created At')
                ->dateTime()
                ->sortable(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return Filament::auth()->user()?->is_admin ?? false; // Only admins can access
    }
}
