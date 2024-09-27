<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'celular',
        'direccion',
        'id_rol', 
        'password',
        'estado'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Roles::class, 'id_rol');
    }

    public function rol() {
        return $this->belongsTo(Roles::class, 'id_rol'); 
    }
    
    protected function type(): Attribute
    {
        return new Attribute(
            get: fn($value) => ['user', 'admin'][$value] ?? 'unknown',
        );
    }

    public function permisos()
    {
        return $this->hasManyThrough(Permiso::class, 'permisos_rol', 'id_rol', 'id_permiso');
    }

    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'permisos_rol', 'id_rol', 'id_permiso');
    }

    public function scopeSearch($query, $value)
    {
        $query->where('name', 'like', "%{$value}%")
                     ->orWhere('email', 'like', "%{$value}%");
    }
}
