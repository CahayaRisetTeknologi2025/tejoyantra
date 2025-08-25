<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IKRInstallationTicket extends Model
{
    use HasFactory;
    protected $table = 'ikr_installation_tickets';
    protected $fillable = [
        'ikr_installation_id',
        'issue',
        'solution',
        'created_by',
        'updated_by',
    ];

    public function ikrInstallation()
    {
        return $this->belongsTo(IKRInstallation::class, 'ikr_installation_id');
    }
}
