<?php

namespace App\Filament\Wrh\Resources\UnitResource\Pages;

use App\Filament\Wrh\Resources\UnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUnits extends ListRecords
{
    protected static string $resource = UnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(ucwords('tambah baru')),
        ];
    }
}
