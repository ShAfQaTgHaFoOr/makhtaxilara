<?php

namespace App\Filament\Resources\RoutePackageResource\Pages;

use App\Filament\Resources\RoutePackageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRoutePackages extends ListRecords
{
    protected static string $resource = RoutePackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
