<?php

namespace App\Filament\Resources\ReaderResource\Pages;

use App\Filament\Resources\ReaderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReader extends EditRecord
{
    protected static string $resource = ReaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
