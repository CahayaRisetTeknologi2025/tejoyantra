<?php

namespace App\Filament\Resources\IKRInstallations\Pages;

use App\Filament\Resources\IKRInstallations\IKRInstallationResource;
use App\Models\IKRInstallation;
use Carbon\Carbon;
use chillerlan\QRCode\Common\Mode;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateIKRInstallation extends CreateRecord
{
    protected static string $resource = IKRInstallationResource::class;

    protected static ?string $title = 'Buat IKR';
    protected static bool $canCreateAnother = false;
    protected function getFormActions(): array
    {
        return [];
    }

    public function submit(){
        $data = $this->form->getState();
        $waranty_date = Carbon::parse($data['installation_date'])->addMonths(1)->format('Y-m-d');

        DB::beginTransaction();
        try {
            $ikr_installation_id = DB::table('ikr_installations')->insertGetId([
                'tower_id' => $data['tower_id'],
                'isp_id' => $data['isp_id'],
                'installation_date' => $data['installation_date'],
                'warranty_date' => $waranty_date,
                'customer_id' => $data['customer_id'],
                'wo_id' => $data['wo_id'],
                'customer_name' => $data['customer_name'],
                'contact_person' => $data['contact_person'],
                'floor' => $data['floor'],
                'unit' => $data['unit'],
                'status_work' => $data['status_work'],
                'status' => $data['status'],
                'team_name' => $data['team_name'],
                'created_at' => Carbon::now(),
                'created_by' => auth()->id()
            ]);

            if(!empty($data['fat_code']) && $data['fat_code'] != ''){
                DB::table('ikr_installation_onts')->insert([
                    'ikr_installation_id' => $ikr_installation_id,
                    'fat_code' => $data['fat_code'],
                    'port' => $data['port'],
                    'drop_wire' => $data['drop_wire'],
                    'pigtall' => $data['pigtall'],
                    'splicing' => $data['splicing'],
                    'ont' => $data['ont'],
                    'serial_number' => $data['serial_number'],
                    'mac_number' => $data['mac_number'],
                    'created_at' => Carbon::now(),
                    'created_by' => auth()->id()
                ]);
            }

            if(!empty($data['serial_number_stb']) && $data['serial_number_stb'] != ''){
                DB::table('ikr_installation_stbs')->insert([
                    'ikr_installation_id' => $ikr_installation_id,
                    'serial_number' => $data['serial_number'],
                    'mac_number' => $data['mac_number'],
                    'created_at' => Carbon::now(),
                    'created_by' => auth()->id()
                ]);
            }

            DB::commit();

            Notification::make()
                ->title('Data berhasil di ubah')
                ->success()
                ->send();

            return redirect('admin/i-k-r-installations');
        }catch (\Exception $exception){
            DB::rollBack();
            throw $exception;
        }
    }
}
