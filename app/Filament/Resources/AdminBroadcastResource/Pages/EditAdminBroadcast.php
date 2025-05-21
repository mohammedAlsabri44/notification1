<?php

namespace App\Filament\Resources\AdminBroadcastResource\Pages;

use App\Filament\Resources\AdminBroadcastResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdminBroadcast extends EditRecord
{
    protected static string $resource = AdminBroadcastResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
