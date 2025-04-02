<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmailAccountResource\Pages;
use App\Models\EmailAccount;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Select;

class EmailAccountResource extends Resource
{
    protected static ?string $model = EmailAccount::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name') // This pulls the name from the User model
                    ->searchable() // Make the dropdown searchable
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('imap_server')
                    ->required()
                    ->maxLength(255),
                TextInput::make('imap_port')
                    ->required()
                    ->numeric()
                    ->default(993),
                TextInput::make('smtp_server')
                    ->required()
                    ->maxLength(255),
                TextInput::make('smtp_port')
                    ->required()
                    ->numeric()
                    ->default(587),
                TextInput::make('username')
                    ->required()
                    ->maxLength(255),
                Textarea::make('password')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('use_ssl')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->searchable(),

                TextColumn::make('imap_server')
                    ->searchable(),
                TextColumn::make('imap_port')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('smtp_server')
                    ->searchable(),
                TextColumn::make('smtp_port')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('username')
                    ->searchable(),
                IconColumn::make('use_ssl')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmailAccounts::route('/'),
            'create' => Pages\CreateEmailAccount::route('/create'),
            'edit' => Pages\EditEmailAccount::route('/{record}/edit'),
        ];
    }
}
