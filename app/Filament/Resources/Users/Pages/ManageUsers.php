<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Filament\Resources\Users\Widgets\UserOverview;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Hash;

class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            UserOverview::class,
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Tambah User')
            ->icon('heroicon-s-plus')
            ->mutateDataUsing(function (array $data): array {
                $data['password'] = Hash::make($data['password']);
                $data['created_by'] = auth()->id();
                $data['created_at'] = now();

                return $data;
            }),
        ];
    }
}
