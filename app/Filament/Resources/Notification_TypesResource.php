<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Notification_TypesResource\Pages;
use App\Filament\Resources\Notification_TypesResource\RelationManagers;
use App\Models\Notification_Types;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;


class Notification_TypesResource extends Resource
{
    protected static ?string $model = Notification_Types::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\Textarea::make('description'),
                Forms\Components\Toggle::make('is_active'),

            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                // ->label('تاريخ الإنشاء')
                ->dateTime('d-m-Y H:i'),
            Tables\Columns\TextColumn::make('updated_at')
                // ->label('آخر تعديل')
                ->since(),

            ])
             ->filters([
            SelectFilter::make('is_active')
                ->label('Status')
                ->options([
                    1 => 'Active',
                    0 => 'Inactive',
                ]),
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
            'index' => Pages\ListNotification_Types::route('/'),
            'create' => Pages\CreateNotification_Types::route('/create'),
            'edit' => Pages\EditNotification_Types::route('/{record}/edit'),
        ];
    }
}


