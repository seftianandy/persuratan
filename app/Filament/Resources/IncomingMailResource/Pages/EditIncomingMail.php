<?php

namespace App\Filament\Resources\IncomingMailResource\Pages;

use App\Filament\Resources\IncomingMailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIncomingMail extends EditRecord
{
    protected static string $resource = IncomingMailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
