<?php

namespace App\Filament\Resources\IKRInstallations\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\Concerns\HasWizard;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class IKRInstallationForm
{
    use HasWizard;

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make()
                    ->columnSpanFull()
                    ->schema([
                            IKRInstallationForm::ikrInstallation(),
                            IKRInstallationForm::ikrInstallationOnt(),
                            IKRInstallationForm::ikrInstallationSTB(),
                        ])
                        ->submitAction(
                            Action::make('simpan')
                                ->label('Simpan')
                                ->action('submit')
                        )
                ]);
    }


    public static function ikrInstallation(): Wizard\Step{
        return  Wizard\Step::make('ikr_installation')
            ->columns(2)
            ->completedIcon(Heroicon::HandThumbUp)
            ->label('IKR Installation')
            ->schema([
                Select::make('isp_id')
                    ->label('ISP')
                    ->relationship('isp', 'name')
                    ->required()
                    ->searchable()
                    ->loadingMessage('Mencari ISP...')
                    ->noSearchResultsMessage('ISP Tidak Ditemukan')
                    ->validationMessages([
                        'required' => 'ISP Harus Di Isi',
                    ]),
                TextInput::make('customer_id')
                    ->label('Customer ID')
                    ->required()
                    ->validationMessages([
                        'required' => 'Customer ID Wajib Di Isi',
                    ]),
                DatePicker::make('installation_date')
                    ->label('Installation Date')
                    ->required()
                    ->validationMessages([
                        'required' => 'Installation Date Wajib Di Isi',
                    ]),
                TextInput::make('wo_id')
                    ->label('Work Order ID'),
                TextInput::make('customer_name')
                    ->label('Customer Name')
                    ->required()
                    ->validationMessages([
                        'required' => 'Customer Name Wajib Di Isi',
                    ]),
                TextInput::make('contact_person')
                    ->label('Contact Person'),
                Select::make('tower_id')
                    ->label('Tower')
                    ->relationship('tower', 'name')
                    ->required()
                    ->searchable()
                    ->loadingMessage('Mencari Tower...')
                    ->noSearchResultsMessage('Tower Tidak Ditemukan')
                    ->validationMessages([
                        'required' => 'Tower Harus Di Isi',
                    ]),
                TextInput::make('floor')
                    ->label('Floor')
                    ->required()
                    ->validationMessages([
                        'required' => 'Floor Wajib Di Isi',
                    ]),
                TextInput::make('unit')
                    ->label('Unit')
                    ->required()
                    ->validationMessages([
                        'required' => 'Unit Wajib Di Isi',
                    ]),
                Select::make('status_work')
                    ->label('Status Work')
                    ->options([
                        'MIGRASI' => 'MIGRASI',
                        'INSTALASI' => 'INSTALASI',
                        'TROUBLESHOOTING' => 'TROUBLESHOOTING',
                        'RELOKASI' => 'RELOKASI',
                    ])
                    ->default('INSTALASI')
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'DONE' => 'DONE',
                        'PENDING' => 'PENDING',
                        'CANCEL' => 'CANCEL',
                    ])
                    ->default('PENDING')
                    ->required(),
                TextInput::make('team_name')
                    ->label('Team Name')
                    ->required()
                    ->validationMessages([
                        'required' => 'Team Name Wajib Di Isi',
                    ]),
            ]);
    }

    public static function ikrInstallationOnt(): Wizard\Step{
        return  Wizard\Step::make('ikr_installation_ont')
            ->columns(2)
            ->completedIcon(Heroicon::HandThumbUp)
            ->label('IKR Installation ONT')
            ->schema([
                TextInput::make('fat_code')
                    ->label('FAT Code'),
                TextInput::make('port')
                    ->label('Port'),
                TextInput::make('drop_wire')
                    ->label('Drop Wire'),
                TextInput::make('pigtall')
                    ->label('Pigtall'),
                TextInput::make('splicing')
                    ->label('Splicing'),
                TextInput::make('ont')
                    ->label('ONT'),
                TextInput::make('serial_number')
                    ->label('Serial Number'),
                TextInput::make('mac_number')
                    ->label('MAC Number'),
            ]);
    }

    public static function ikrInstallationSTB(): Wizard\Step{
        return  Wizard\Step::make('ikr_installation_stb')
            ->columns(2)
            ->completedIcon(Heroicon::HandThumbUp)
            ->label('IKR Installation STB')
            ->schema([
                TextInput::make('serial_number_stb')
                    ->label('Serial Number'),
                TextInput::make('mac_number_stb')
                    ->label('MAC Number'),
            ]);
    }
}
