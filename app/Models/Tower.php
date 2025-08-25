<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tower extends Model
{
    use HasFactory;
    protected $table = 'towers';
    protected $fillable = [
        'name',
        'building_id',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class,'building_id', 'id');
    }

    public function userCreated()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function userUpdated()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeNotActive($query)
    {
        return $query->where('is_active', 0);
    }
}
