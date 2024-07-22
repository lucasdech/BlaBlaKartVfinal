<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TripResource\Pages;
use App\Models\Trip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TripResource extends Resource
{
    protected static ?string $model = Trip::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'email')
                    ->required(),
                Forms\Components\TextInput::make('starting_point')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ending_point')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('starting_at')
                    ->required(),
                Forms\Components\TextInput::make('available_seats')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->minValue(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('starting_point')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('ending_point')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('starting_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('available_seats')->sortable(),
                Tables\Columns\TextColumn::make('price')->money('eur')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user')->relationship('user', 'email'),
                // Tables\Filters\DateFilter::make('starting_at'),
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
            'index' => Pages\ListTrips::route('/'),
            'create' => Pages\CreateTrip::route('/create'),
            'edit' => Pages\EditTrip::route('/{record}/edit'),
        ];
    }
}