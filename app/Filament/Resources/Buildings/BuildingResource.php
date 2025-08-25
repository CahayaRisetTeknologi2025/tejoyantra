<?php

namespace App\Filament\Resources\Buildings;

use App\Filament\Resources\Buildings\Pages\ManageBuildings;
use App\Models\Building;
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
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BuildingResource extends Resource
{
    protected static ?string $model = Building::class;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationGroup(): string
    {
        return 'Master Data';
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Building Management';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
            ->recordTitleAttribute('Building Management')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                Filter::make('is_active')
                    ->label('Active?')
                    ->query(fn (Builder $query) => $query->where('is_active', '=', true)),
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
            'index' => ManageBuildings::route('/'),
        ];
    }
}
