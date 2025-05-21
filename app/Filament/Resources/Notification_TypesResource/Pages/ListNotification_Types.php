<?php

namespace App\Filament\Resources\Notification_TypesResource\Pages;

use App\Filament\Resources\Notification_TypesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNotification_Types extends ListRecords
{
    protected static string $resource = Notification_TypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
