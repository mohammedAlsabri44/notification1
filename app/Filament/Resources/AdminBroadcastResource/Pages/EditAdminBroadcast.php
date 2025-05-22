<?php

namespace App\Filament\Resources\AdminBroadcastResource\Pages;

use App\Filament\Resources\AdminBroadcastResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

use Filament\Actions\Action;
use App\Jobs\SendAdminBroadcast;

class EditAdminBroadcast extends EditRecord
{
    protected static string $resource = AdminBroadcastResource::class;

    protected function getHeaderActions(): array
    {
        // return [
        //     Actions\DeleteAction::make(),
        // ];

         return [
            Actions\DeleteAction::make(),
            Actions\Action::make('sendNow')
                ->label('إرسال الآن')
                ->icon('heroicon-o-paper-airplane')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn () => !$this->record->sent)
                ->action(function () {
                    dispatch(new SendAdminBroadcast($this->record));
                    $this->record->update(['sent' => true]);

                    \Filament\Notifications\Notification::make()
                        ->title('تم الإرسال')
                        ->success()
                        ->send();
                }),
        ];
    }

    // protected function getActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //         Actions\Action::make('sendNow')
    //             ->label('إرسال الآن')
    //             ->icon('heroicon-o-paper-airplane')
    //             ->color('success')
    //             ->requiresConfirmation()
    //             ->visible(fn () => !$this->record->sent)
    //             ->action(function () {
    //                 dispatch(new SendAdminBroadcast($this->record));
    //                 $this->record->update(['sent' => true]);

    //                 \Filament\Notifications\Notification::make()
    //                     ->title('تم الإرسال')
    //                     ->success()
    //                     ->send();
    //             }),
    //     ];
    // }
}
