<?php

namespace App\Filament\Wrh\Resources\MaterialCategoryResource\Pages;

use App\Filament\Wrh\Resources\MaterialCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMaterialCategory extends EditRecord
{
    protected static string $resource = MaterialCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
