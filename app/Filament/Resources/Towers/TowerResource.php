<?php

namespace App\Filament\Resources\Towers;

use App\Filament\Resources\Towers\Pages\ManageTowers;
use App\Models\Tower;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TowerResource extends Resource
{
    protected static ?string $model = Tower::class;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Tower Management';
    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): string
    {
        return 'Master Data';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('building_id')
                    ->label('Building')
                    ->relationship('building', 'name')
                    ->searchable()
                    ->loadingMessage('Mencari Building...')
                    ->noSearchResultsMessage('Building Tidak Ditemukan'),
                TextInput::make('name')
                    ->required(),
                Toggle::make('is_active')
                    ->label('Active?')
                    ->required(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('building.name')->label('Building Name'),
                TextEntry::make('name'),
                TextEntry::make('userCreated.name')
                    ->label('Created By'),
                TextEntry::make('userUpdated.name')
                    ->label('Updated By'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                IconEntry::make('is_active')
                    ->boolean(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Tower Management')
            ->columns([
                TextColumn::make('building.name')->label('Building Name'),
                TextColumn::make('name')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                Filter::make('is_active')
                    ->label('Active?')
                    ->query(fn (Builder $query) => $query->where('is_active', '=', true)),
                SelectFilter::make('building_id')
                    ->label('Building')
                    ->relationship('building', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                ->mutateDataUsing(function (array $data): array {
                    $data['updated_by'] = auth()->id();
                    $data['updated_at'] = now();

                    return $data;
                }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageTowers::route('/'),
        ];
    }
}
