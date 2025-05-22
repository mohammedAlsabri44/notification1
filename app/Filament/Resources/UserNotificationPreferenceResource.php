<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserNotificationPreferenceResource\Pages;
use App\Filament\Resources\UserNotificationPreferenceResource\RelationManagers;
use App\Models\UserNotificationPreference;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;

class UserNotificationPreferenceResource extends Resource
{
    protected static ?string $model = UserNotificationPreference::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                     ->relationship('user', 'name')->required(),

                Forms\Components\Select::make('notification_type_id')
                    ->relationship('notificationType', 'name')->required(),

                Forms\Components\Select::make('channel')
                    ->options([
                        'email' => 'Email',
                        'sms' => 'SMS',
                        'in_app' => 'In App',
    ])
                    ->required(),

                Forms\Components\Toggle::make('is_enabled')
    ->label('Enabled')
    ->afterStateUpdated(function ($state, callable $set, callable $get) {
        $channel = $get('channel');

        $isChannelEnabled = \App\Models\NotificationChannel::where('name', $channel)->value('is_enabled');

        if ($state && !$isChannelEnabled) {
            $set('is_enabled', false); // Reset toggle
            throw \Filament\Notifications\Notification::make()
                ->title('This channel is currently disabled.')
                ->danger()
                ->send();
        }
    }),


            ]);
    }
    public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->where('user_id', auth()->id()); // فقط بيانات المستخدم الحالي
}


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                ->label('User')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('notificationType.name')
                ->label('Notification Type')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('channel')
                ->badge()
                ->sortable()
                ->colors([
                    'email' => 'primary',
                    'sms' => 'warning',
                    'in_app' => 'success',
                ]),
                Tables\Columns\IconColumn::make('is_enabled')
                ->boolean()
                ->label('Enabled')
                ->sortable(),
            ])
            ->filters([
    SelectFilter::make('channel')
        ->options([
            'email' => 'Email',
            'sms' => 'SMS',
            'in_app' => 'In App',
        ])
        ->label('Channel'),
        

    SelectFilter::make('notification_type_id')
        ->relationship('notificationType', 'name')
        ->label('Notification Type'),

    SelectFilter::make('user_id')
        ->relationship('user', 'name')
        ->label('User'),
])
            ->actions([
    Tables\Actions\EditAction::make()
        ->visible(fn ($record) => $record->user_id === auth()->id() || auth()->user()->hasRole('admin')),
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
            'index' => Pages\ListUserNotificationPreferences::route('/'),
            'create' => Pages\CreateUserNotificationPreference::route('/create'),
            'edit' => Pages\EditUserNotificationPreference::route('/{record}/edit'),
        ];
    }
}
