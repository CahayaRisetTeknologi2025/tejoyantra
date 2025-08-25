<?php

namespace App\Filament\Resources\IKRInstallations\Pages;

use App\Filament\Resources\IKRInstallations\IKRInstallationResource;
use App\Models\IKRInstallationONT;
use Carbon\Carbon;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;

class EditIKRInstallation extends EditRecord
{
    protected static string $resource = IKRInstallationResource::class;

    protected static ?string $title = 'Edit IKR Installation';

    protected function getFormActions(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $ikrInstallationOnt = $this->record->ikrInstallationOnts?->first();
        $ikrInstallationStb = $this->record->ikrInstallationStbs?->first();

        $data['ikr_installation_id'] = $this->record->id;
        $data['fat_code'] = $ikrInstallationOnt?->fat_code;
        $data['port'] = $ikrInstallationOnt?->port;
        $data['drop_wire'] = $ikrInstallationOnt?->drop_wire;
        $data['pigtall'] = $ikrInstallationOnt?->pigtall;
        $data['splicing'] = $ikrInstallationOnt?->splicing;
        $data['ont'] = $ikrInstallationOnt?->ont;
        $data['serial_number'] = $ikrInstallationOnt?->serial_number;
        $data['mac_number'] = $ikrInstallationOnt?->mac_number;

        $data['serial_number_stb'] = $ikrInstallationStb?->serial_number;
        $data['mac_number_stb'] = $ikrInstallationStb?->mac_number;

        return $data;
    }

    public function submit(){
        $id = $this->record->id;
        $data = $this->form->getState();

        $waranty_date = Carbon::parse($data['installation_date'])->addMonths(1)->format('Y-m-d');

        DB::beginTransaction();
        try {
            $ikr_installation_id = DB::table('ikr_installations')->where('id', $id)->update([
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
                'updated_at' => Carbon::now(),
                'updated_by' => auth()->id()
            ]);

            $ikrInstallationOnt = DB::table('ikr_installation_onts')->where('ikr_installation_id', $id);
            if((!empty($data['fat_code']) && $data['fat_code'] != '') && !empty($ikrInstallationOnt->first())){
                $ikrInstallationOnt->update([
                    'fat_code' => $data['fat_code'],
                    'port' => $data['port'],
                    'drop_wire' => $data['drop_wire'],
                    'pigtall' => $data['pigtall'],
                    'splicing' => $data['splicing'],
                    'ont' => $data['ont'],
                    'serial_number' => $data['serial_number'],
                    'mac_number' => $data['mac_number'],
                    'updated_at' => Carbon::now(),
                    'updated_by' => auth()->id()
                ]);
            }else{
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

            $ikrInstallationStb = DB::table('ikr_installation_stbs')->where('ikr_installation_id', $id);
            if((!empty($data['serial_number_stb']) && $data['serial_number_stb'] != '') && !empty($ikrInstallationStb->first())){
                $ikrInstallationStb->update([
                    'serial_number' => $data['serial_number'],
                    'mac_number' => $data['mac_number'],
                    'updated_at' => Carbon::now(),
                    'updated_by' => auth()->id()
                ]);
            }else{
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

            return redirect('/admin/i-k-r-installations');
        }catch (\Exception $exception){
            DB::rollBack();
            dd($e);
            throw $exception;
        }
    }
}
