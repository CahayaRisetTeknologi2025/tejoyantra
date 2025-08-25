<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_admin',
        'is_active',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string',
            'is_admin' => 'boolean',
        ];
    }

    public function isps()
    {
        return $this->hasMany(Isp::class);
    }

    public function towers()
    {
        return $this->hasMany(Tower::class);
    }

    public function buildings()
    {
        return $this->hasMany(Building::class);
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

    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isExternal(): bool
    {
        return $this->role === 'external';
    }
}
