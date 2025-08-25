<?php

namespace App\Filament\Resources\ISPS;

use App\Filament\Resources\ISPS\Pages\ManageISPS;
use App\Filament\Resources\ISPS\Widgets\ISPOverview;
use App\Models\ISP;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
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
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget;

class ISPResource extends Resource
{
    protected static ?string $model = ISP::class;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'ISP Management';
    protected static ?string $navigationLabel = 'ISP';
    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): string
    {
        return 'Master Data';
    }


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
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
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('userCreated.name')
                    ->label('Created By'),
                TextEntry::make('userUpdated.name')
                    ->label('Updated By'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('ISP Management')
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
            'index' => ManageISPS::route('/'),
        ];
    }
}
