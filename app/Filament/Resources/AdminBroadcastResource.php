<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminBroadcastResource\Pages;
use App\Filament\Resources\AdminBroadcastResource\RelationManagers;
use App\Models\AdminBroadcast;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdminBroadcastResource extends Resource
{
    protected static ?string $model = AdminBroadcast::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\Textarea::make('message')->required(),
                Forms\Components\Select::make('channel')
            ->options([
                      'email' => 'Email',
                      'sms' => 'SMS',
                     'in_app' => 'In App',
    ])
            ->required(),
                Forms\Components\TextInput::make('filter_by_role')
            ->label('Filter by Role (optional)')
            ->placeholder('admin, user, etc.')
            ->helperText('Leave empty to broadcast to all users.'),

        Forms\Components\Toggle::make('schedule')
            ->label('Schedule for later?')
            ->default(false)
            ->reactive(),

       Forms\Components\DateTimePicker::make('scheduled_at')
            ->label('Scheduled At')
            ->visible(fn ($get) => $get('schedule') === true)
            ->required(fn ($get) => $get('schedule') === true)
            ->after(now()),

        Forms\Components\Toggle::make('sent')
            ->label('Mark as Sent') // يُستخدم عادة للعرض فقط وليس للإدخال
            ->disabled(),
    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('channel'),
                Tables\Columns\TextColumn::make('filter_by_role'),
                Tables\Columns\TextColumn::make('sent')->badge()->colors([
                             true => 'success',
                             false => 'danger',
]),
                Tables\Columns\TextColumn::make('scheduled_at')->dateTime(),
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
            'index' => Pages\ListAdminBroadcasts::route('/'),
            'create' => Pages\CreateAdminBroadcast::route('/create'),
            'edit' => Pages\EditAdminBroadcast::route('/{record}/edit'),
        ];
    }
}
