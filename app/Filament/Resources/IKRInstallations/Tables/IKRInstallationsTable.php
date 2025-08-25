<?php

namespace App\Filament\Resources\IKRInstallations\Tables;

use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class IKRInstallationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('IKR Installation')
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
                    ->label('Customer ID')
                    ->searchable(),
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
            ])
            ->filters([
                SelectFilter::make('isp_id')
                    ->label('ISP')
                    ->relationship('isp', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('tower_id')
                    ->label('Tower')
                    ->relationship('tower', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('status_work')
                    ->label('Status Work')
                    ->options([
                        'MIGRASI' => 'MIGRASI',
                        'INSTALASI' => 'INSTALASI',
                        'TROUBLESHOOTING' => 'TROUBLESHOOTING',
                        'RELOKASI' => 'RELOKASI',
                    ]),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'DONE' => 'DONE',
                        'PENDING' => 'PENDING',
                        'CANCEL' => 'CANCEL',
                    ]),
            ])
            ->recordActions([
//                ViewAction::make(),
//                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
