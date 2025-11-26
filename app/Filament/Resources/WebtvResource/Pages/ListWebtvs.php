<?php

namespace App\Filament\Resources\WebtvResource\Pages;

use App\Filament\Resources\WebtvResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWebtvs extends ListRecords
{
    protected static string $resource = WebtvResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
