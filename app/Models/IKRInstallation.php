<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IKRInstallation extends Model
{
    use HasFactory;
    protected $table = 'ikr_installations';
    protected $fillable = [
        'tower_id',
        'isp_id',
        'installation_date',
        'warranty_date',
        'customer_id',
        'wo_id',
        'customer_name',
        'contact_person',
        'floor',
        'unit',
        'status_work',
        'status',
        'team_name',
        'created_by',
        'updated_by',
    ];

    public function tower()
    {
        return $this->belongsTo(Tower::class, 'tower_id');
    }

    public function isp()
    {
        return $this->belongsTo(ISP::class, 'isp_id');
    }

    public function ikrInstallationStbs()
    {
        return $this->hasOne(IKRInstallationSTB::class,'ikr_installation_id');
    }

    public function ikrInstallationOnts()
    {
        return $this->hasOne(IKRInstallationONT::class, 'ikr_installation_id');
    }

    public function ikrInstallationTickets()
    {
        return $this->hasOne(IKRInstallationTicket::class, 'ikr_installation_id');
    }

    public function scopeIkrWarranty($query)
    {
        return $query->whereDate('warranty_date', '>', now()->toDateString());
    }

    public function scopeIkrExpired($query)
    {
        return $query->whereDate('installation_date', '<', now()->toDateString());
    }
}
