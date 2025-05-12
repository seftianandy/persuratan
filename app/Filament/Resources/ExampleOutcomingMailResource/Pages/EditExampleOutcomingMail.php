<?php

namespace App\Filament\Resources\ExampleOutcomingMailResource\Pages;

use App\Filament\Resources\ExampleOutcomingMailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExampleOutcomingMail extends EditRecord
{
    protected static string $resource = ExampleOutcomingMailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
