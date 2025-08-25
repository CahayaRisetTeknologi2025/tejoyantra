<?php

namespace App\Filament\Resources\Buildings\Pages;

use App\Filament\Resources\Buildings\BuildingResource;
use App\Filament\Resources\Buildings\Widgets\BuildingOverview;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageBuildings extends ManageRecords
{
    protected static string $resource = BuildingResource::class;

    protected static ?string $title = 'Building Management';

    protected function getHeaderWidgets(): array
    {
        return [
            BuildingOverview::class
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Tambah Building')
            ->icon('heroicon-s-plus')
            ->mutateDataUsing(function (array $data): array {
                $data['created_by'] = auth()->id();
                $data['created_at'] = now();

                return $data;
            }),
        ];
    }
}
