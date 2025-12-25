<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Rol extends Model
{
    use HasUuids;

    protected $table = 'roles';

    public function usuarios()
    {
        return $this->belongsToMany(
            Usuarios::class,
            'role_usuario',
            'role_id',
            'usuario_id'
        );
    }
}
