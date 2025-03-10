<?php

namespace App\Filament\Resources\ReciverResource\Pages;

use App\Filament\Resources\ReciverResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRecivers extends ListRecords
{
    protected static string $resource = ReciverResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
