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

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make("Information")
                    ->collapsed(false)
                    ->schema([
                        Forms\Components\TextInput::make('username')
                            ->unique(ignoreRecord: true)
                            ->required(),

                        Forms\Components\TextInput::make('display_name')
                            ->required(),

                        Forms\Components\TextInput::make('email')
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('mobile')
                            ->numeric()
                            ->required(),


                        Forms\Components\Toggle::make('show_email')
                            ->onIcon('heroicon-m-hand-thumb-up')
                            ->offIcon('heroicon-m-hand-thumb-down'),

                        Forms\Components\Toggle::make('show_mobile')
                            ->onIcon('heroicon-m-hand-thumb-up')
                            ->offIcon('heroicon-m-hand-thumb-down'),


                        Forms\Components\Textarea::make('bio')
                            ->columnSpanFull()

                    ])->columns(2)->columnSpan(1),
                Forms\Components\Section::make("Password")
                    ->collapsed(false)
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->default('password')
                            ->required(),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->password()
                            ->required()

                    ])->columns(2)->columnSpan(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),

                Tables\Columns\TextColumn::make('display_name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('mobile')
                    ->searchable(),
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
}
