<?php

namespace App\Filament\Widgets;

use App\Models\IKRInstallation;
use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestInstallationTable extends TableWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => IKRInstallation::query()->latest()->limit(10))
            ->columns([
                TextColumn::make('warranty_date')
                    ->label('Warranty')
                    ->badge()
                    ->color(fn (string $state): string => Carbon::parse($state)->isPast() ? 'danger' :'success')
                    ->formatStateUsing(fn (string $state): string =>
                    Carbon::parse($state)->isPast()
                        ? 'Expired'
                        : 'Warranty'
                    )
                    ->tooltip(fn (string $state): string =>
                        'Garansi sampai: ' . Carbon::parse($state)->format('d F Y')
                    ),
                TextColumn::make('tower.building.name')
                    ->label('Building'),
                TextColumn::make('tower.name')
                    ->label('Tower'),
                TextColumn::make('customer_id')
                    ->label('Customer ID'),
                TextColumn::make('customer_name')
                    ->label('Customer Name'),
                TextColumn::make('floor')
                    ->label('Floor'),
                TextColumn::make('unit')
                    ->label('Unit'),
                TextColumn::make('status_work')
                    ->label('Status Work')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'INSTALASI' => 'success',
                        'MIGRASI' => 'grey',
                        'TROUBLESHOOTING' => 'warning',
                        'RELOKASI' => 'danger',
                    }),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'DONE' => 'success',
                        'PENDING' => 'warning',
                        'CANCEL' => 'danger',
                    }),
            ]);
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }
}
