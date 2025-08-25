<?php

namespace App\Filament\Resources\Towers\Pages;

use App\Filament\Resources\Towers\TowerResource;
use App\Filament\Resources\Towers\Widgets\TowerOverview;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Hash;

class ManageTowers extends ManageRecords
{
    protected static string $resource = TowerResource::class;

    protected static ?string $title = 'Tower Management';

    protected function getHeaderWidgets(): array
    {
        return [
            TowerOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Tower')
                ->icon('heroicon-s-plus')
                ->mutateDataUsing(function (array $data): array {
                    $data['created_by'] = auth()->id();
                    $data['created_at'] = now();

                    return $data;
                }),
        ];
    }
}
