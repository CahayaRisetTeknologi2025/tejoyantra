<?php

namespace App\Filament\Resources\IKRInstallations\Schemas;

use Carbon\Carbon;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class IKRInstallationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // Section IKR INSTALLATION
                Section::make('IKR Installation')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(['default' => 1, 'md' => 2, 'lg' => 4])
                        ->schema([
                            TextEntry::make('isp.name')->label('ISP'),
                            TextEntry::make('customer_id')->label('Customer ID'),
                            TextEntry::make('customer_name')->label('Customer Name'),
                            TextEntry::make('installation_date')->label('Installation Date')->date('l, d F Y'),
                            TextEntry::make('wo_id')->label('WO ID'),
                            TextEntry::make('tower.building.name')->label('Building'),
                            TextEntry::make('tower.name')->label('Tower'),
                            TextEntry::make('floor')->label('Floor'),
                            TextEntry::make('unit')->label('Unit'),
                            TextEntry::make('status_work')
                                ->label('Status Work')
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'INSTALASI' => 'success',
                                    'MIGRASI' => 'grey',
                                    'TROUBLESHOOTING' => 'warning',
                                    'RELOKASI' => 'danger',
                                }),
                            TextEntry::make('status')
                                ->label('Status')
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'DONE' => 'success',
                                    'PENDING' => 'warning',
                                    'CANCEL' => 'danger',
                                }),
                            TextEntry::make('team_name')->label('Team Name'),
                            TextEntry::make('contact_person')->label('Contact Person'),
                            TextEntry::make('warranty_date')
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
                        ])
                    ])
                    ->hidden(fn ($record) => !$record),

                // Section IKR INSTALLATION ONT
                Section::make('IKR Installation ONT')
                    ->schema([
                        Grid::make(['default' => 1, 'md' => 2, 'lg' => 4])
                        ->schema([
                            TextEntry::make('ikrInstallationOnts.fat_code')->label('FAT Code'),
                            TextEntry::make('ikrInstallationOnts.port')->label('Port'),
                            TextEntry::make('ikrInstallationOnts.drop_wire')->label('Drop Wire'),
                            TextEntry::make('ikrInstallationOnts.pigtall')->label('Pigtall'),
                            TextEntry::make('ikrInstallationOnts.splicing')->label('Splicing'),
                            TextEntry::make('ikrInstallationOnts.ont')->label('ONT'),
                            TextEntry::make('ikrInstallationOnts.serial_number')->label('Serial Number'),
                            TextEntry::make('ikrInstallationOnts.mac_number')->label('Mac Number'),
                        ])
                    ])
                    ->hidden(fn ($record) => !$record || !$record->ikrInstallationOnts),

                // Section IKR INSTALLATION STB
                Section::make('IKR Installation STB')
                    ->schema([
                        Grid::make(2)
                        ->schema([
                            TextEntry::make('ikrInstallationStbs.serial_number')->label('Serial Number'),
                            TextEntry::make('ikrInstallationStbs.mac_number')->label('Mac Number'),
                        ])
                    ])
                ->hidden(fn ($record) => !$record || !$record->ikrInstallationStbs),

                // Section IKR INSTALLATION TICKET
                Section::make('IKR Installation Ticket')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('ikrInstallationTickets.issue')->label('Issue'),
                                TextEntry::make('ikrInstallationTickets.solution')->label('Solution'),
                            ])
                    ])
                    ->hidden(fn ($record) => !$record || !$record->ikrInstallationTickets),
            ]);
    }
}
