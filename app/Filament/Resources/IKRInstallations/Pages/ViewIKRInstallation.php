<?php

namespace App\Filament\Resources\IKRInstallations\Pages;

use App\Filament\Resources\IKRInstallations\IKRInstallationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewIKRInstallation extends ViewRecord
{
    protected static string $resource = IKRInstallationResource::class;

    protected static ?string $breadcrumb = 'Detail';

    protected static ?string $title = 'IKR Installation Detail';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
