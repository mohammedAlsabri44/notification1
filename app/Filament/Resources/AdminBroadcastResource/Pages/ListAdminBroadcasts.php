<?php

namespace App\Filament\Resources\AdminBroadcastResource\Pages;

use App\Filament\Resources\AdminBroadcastResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdminBroadcasts extends ListRecords
{
    protected static string $resource = AdminBroadcastResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
