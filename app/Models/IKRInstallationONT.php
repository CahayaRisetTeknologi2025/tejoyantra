<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IKRInstallationONT extends Model
{
    use HasFactory;
    protected $table = 'ikr_installation_onts';
    protected $fillable = [
        'ikr_installation_id',
        'fat_code',
        'port',
        'drop_wire',
        'pigtall',
        'splicing',
        'ont',
        'serial_number',
        'mac_number',
        'created_by',
        'updated_by',
    ];

    public function ikrInstallation()
    {
        return $this->belongsTo(IKRInstallation::class, 'ikr_installation_id');
    }
}
