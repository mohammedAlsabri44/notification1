<?php

namespace App\Filament\Resources\Notification_TypesResource\Pages;

use App\Filament\Resources\Notification_TypesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNotification_Types extends EditRecord
{
    protected static string $resource = Notification_TypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
