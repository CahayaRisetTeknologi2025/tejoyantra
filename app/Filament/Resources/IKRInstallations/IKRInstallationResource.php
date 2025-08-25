<?php

namespace App\Filament\Resources\IKRInstallations;

use App\Filament\Resources\IKRInstallations\Pages\CreateIKRInstallation;
use App\Filament\Resources\IKRInstallations\Pages\EditIKRInstallation;
use App\Filament\Resources\IKRInstallations\Pages\ListIKRInstallations;
use App\Filament\Resources\IKRInstallations\Pages\ViewIKRInstallation;
use App\Filament\Resources\IKRInstallations\Schemas\IKRInstallationForm;
use App\Filament\Resources\IKRInstallations\Schemas\IKRInstallationInfolist;
use App\Filament\Resources\IKRInstallations\Tables\IKRInstallationsTable;
use App\Models\IKRInstallation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class IKRInstallationResource extends Resource
{
    protected static ?string $model = IKRInstallation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $breadcrumb = 'IKR Installation';
    protected static ?string $navigationLabel = 'IKR Installation';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'success';
    }

    protected static ?string $recordTitleAttribute = 'IKRInstallation';

    public static function form(Schema $schema): Schema
    {
        return IKRInstallationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return IKRInstallationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IKRInstallationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIKRInstallations::route('/'),
            'create' => CreateIKRInstallation::route('/create'),
            'view' => ViewIKRInstallation::route('/{record}'),
            'edit' => EditIKRInstallation::route('/{record}/edit'),
        ];
    }
}
