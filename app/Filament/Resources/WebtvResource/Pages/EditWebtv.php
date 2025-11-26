<?php

namespace App\Filament\Resources\WebtvResource\Pages;

use App\Filament\Resources\WebtvResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWebtv extends EditRecord
{
    protected static string $resource = WebtvResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
