<?php

namespace App\Filament\Resources\ExampleOutcomingMailResource\Pages;

use App\Filament\Resources\ExampleOutcomingMailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExampleOutcomingMails extends ListRecords
{
    protected static string $resource = ExampleOutcomingMailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
