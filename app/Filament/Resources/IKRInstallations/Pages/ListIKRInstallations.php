<?php

namespace App\Filament\Resources\IKRInstallations\Pages;

use App\Filament\Resources\IKRInstallations\IKRInstallationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIKRInstallations extends ListRecords
{
    protected static string $resource = IKRInstallationResource::class;

    protected static ?string $breadcrumb = 'Daftar';

    protected static ?string $title = 'IKR Installation Management';
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Tambah IKR')
            ->icon('heroicon-s-plus')
            ->mutateDataUsing(function (array $data): array {
                $data['created_by'] = auth()->id();
                $data['created_at'] = now();

                return $data;
            }),
        ];
    }
}
