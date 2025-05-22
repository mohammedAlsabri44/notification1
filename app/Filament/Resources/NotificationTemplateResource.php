<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotificationTemplateResource\Pages;
use App\Filament\Resources\NotificationTemplateResource\RelationManagers;
use App\Models\NotificationTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NotificationTemplateResource extends Resource
{
    protected static ?string $model = NotificationTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('notification_type_id')
                ->relationship('notificationType', 'name')
                ->required()
                ->label('Notification Type'),

            Forms\Components\Select::make('channel')
                ->options([
                    'email' => 'Email',
                    'sms' => 'SMS',
                    'in_app' => 'In App',
                ])
                ->required()
                ->reactive() // ضروري لتحديث القيم بناءً على الاختيار

                ->label('Channel'),

            // يظهر فقط إذا كانت القناة Email
            Forms\Components\TextInput::make('subject')
                ->label('Subject')
                ->nullable()
                ->visible(fn ($get) => $get('channel') === 'email'),

            Forms\Components\Textarea::make('body')
                ->label('Body')
                ->required()
                ->rows(4),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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

                Tables\Columns\TextColumn::make('subject')
                ->label('Subject')
                ->placeholder('-')
                ->limit(50)
                ->searchable(),
                Tables\Columns\TextColumn::make('body')
                ->label('Body')
                ->limit(50)
                ->toggleable()
                ->wrap(),
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
            'index' => Pages\ListNotificationTemplates::route('/'),
            'create' => Pages\CreateNotificationTemplate::route('/create'),
            'edit' => Pages\EditNotificationTemplate::route('/{record}/edit'),
        ];
    }
}
