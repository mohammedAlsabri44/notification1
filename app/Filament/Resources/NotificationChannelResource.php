<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotificationChannelResource\Pages;
use App\Filament\Resources\NotificationChannelResource\RelationManagers;
use App\Models\NotificationChannel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;

class NotificationChannelResource extends Resource
{
    protected static ?string $model = NotificationChannel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\Toggle::make('is_enabled'),
                Forms\Components\TextInput::make('priority_order')->numeric()->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               Tables\Columns\TextColumn::make('name'),
               Tables\Columns\IconColumn::make('is_enabled')->boolean(),
               Tables\Columns\TextColumn::make('priority_order'),
               Tables\Columns\TextColumn::make('created_at')
                // ->label('تاريخ الإنشاء')
                ->dateTime('d-m-Y H:i'),
            Tables\Columns\TextColumn::make('updated_at')
                // ->label('آخر تعديل')
                ->since(),

            ])
            ->filters([
                SelectFilter::make('is_enabled')
                ->label('Status')
                ->options([
                    true => 'Enabled',
                    false => 'Disabled',
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
            'index' => Pages\ListNotificationChannels::route('/'),
            'create' => Pages\CreateNotificationChannel::route('/create'),
            'edit' => Pages\EditNotificationChannel::route('/{record}/edit'),
        ];
    }
}
