<?php

namespace App\Filament\Resources\ISPS\Pages;

use App\Filament\Resources\ISPS\ISPResource;
use App\Filament\Resources\ISPS\Widgets\ISPOverview;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageISPS extends ManageRecords
{
    protected static string $resource = ISPResource::class;

    protected static ?string $title = 'ISP Management';
    protected function getHeaderWidgets(): array
    {
        return [
            ISPOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah ISP')
                ->icon('heroicon-s-plus')
                ->mutateDataUsing(function (array $data): array {
                    $data['created_by'] = auth()->id();
                    $data['created_at'] = now();

                    return $data;
                }),
        ];
    }
}
