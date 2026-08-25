<?php

namespace App\Filament\Resources\RoutePackageResource\Pages;

use App\Filament\Resources\RoutePackageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRoutePackage extends EditRecord
{
    protected static string $resource = RoutePackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
