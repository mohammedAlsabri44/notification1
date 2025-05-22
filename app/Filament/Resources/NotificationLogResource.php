<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotificationLogResource\Pages;
use App\Filament\Resources\NotificationLogResource\RelationManagers;
use App\Models\NotificationLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\Filter; 
use Filament\Forms\Components\DatePicker; 
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class NotificationLogResource extends Resource
{
    protected static ?string $model = NotificationLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->label('User'),
                // ->disabled(), // read-only
                 Forms\Components\Select::make('notification_type_id')
                ->relationship('notificationType', 'name')
                ->label('Notification Type'),
                // ->disabled()
                 Forms\Components\Select::make('channel')
                ->options([
                    'email' => 'Email',
                    'sms' => 'SMS',
                    'in_app' => 'In App',
                ]),
                // ->disabled()
                Forms\Components\Select::make('status')
                ->options([
                    'sent' => 'Sent',
                    'failed' => 'Failed',
                ]),
                // ->disabled()
                Forms\Components\DateTimePicker::make('sent_at')
                ->label('Sent At'),
                // ->disabled()
                Forms\Components\Textarea::make('response_message')
                ->label('Response Message')
                ->rows(4),
                // ->disabled()
                
            ])->columns(2);
            
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('User'),
                Tables\Columns\TextColumn::make('notificationType.name')->label('Type'),
                Tables\Columns\TextColumn::make('channel'),
                Tables\Columns\TextColumn::make('status')->badge()->colors([
                           'sent' => 'success',
                           'failed' => 'danger',
]),             
                 Tables\Columns\TextColumn::make('sent_at')->dateTime(),
            ])
           
             ->headerActions([
            ExportAction::make()->label('تصدير كـ CSV'),

             ])

            ->filters([
                SelectFilter::make('status')
                ->label('Status')
                ->options([
                    'sent' => 'Sent',
                    'failed' => 'Failed',
                ]),
                TernaryFilter::make('response_message')
                ->label('Has Response?')
                ->trueLabel('Has Response')
                ->falseLabel('No Response')
                ->queries(
                    true: fn ($query) => $query->whereNotNull('response_message')->where('response_message', '!=', ''),
                    false: fn ($query) => $query->whereNull('response_message')->orWhere('response_message', ''),
                ),
                 Filter::make('sent_at')
                ->form([
                    DatePicker::make('from')->label('From'),
                    DatePicker::make('until')->label('To'),
                ])
                ->query(function ($query, array $data) {
                    return $query
                        ->when($data['from'], fn ($q) => $q->whereDate('sent_at', '>=', $data['from']))
                        ->when($data['until'], fn ($q) => $q->whereDate('sent_at', '<=', $data['until']));
                }),
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
            'index' => Pages\ListNotificationLogs::route('/'),
            'create' => Pages\CreateNotificationLog::route('/create'),
            'edit' => Pages\EditNotificationLog::route('/{record}/edit'),
        ];
    }
}
