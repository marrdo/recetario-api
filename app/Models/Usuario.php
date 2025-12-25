<?php

namespace App\Models;

use App\Traits\AplicarSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;                

class Usuario extends Authenticatable
{
    // traits necesarios para autenticación y factorías
    use HasApiTokens, HasFactory, Notifiable, HasUuids;
    use AplicarSlug; // Traits personalizados
    

    protected $table = 'usuarios';
    // Campo para generar el slug
    protected $campoSlug = 'nickname';

    // Configuración UUID
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nickname',
        'nombre',
        'apellidos',
        'email',
        'slug',
        'usuario_ip',
        'password',
        'telefono',
        'active',
        'notas',
        'lang',
        'fecha_nacimiento',
        'genero',
        'altura',
        'peso_actual',
        'peso_objetivo',
        'nivel_actividad',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'active' => 'boolean',
            'fecha_nacimiento' => 'date',
            'ultimo_login' => 'datetime',
            'peso_actual' => 'decimal:2',
            'peso_objetivo' => 'decimal:2',
        ];
    }

    // Relaciones
    /**
     * Relación N:M con Roles
     * Se usa la tabla pivot 'role_usuario'
     */
    public function roles()
    {
        // En Eloquent, si el nombre de la tabla pivot no sigue la convención alfabética (rol_usuario), 
        // es mejor especificarlo, aunque en este caso puede que lo deduzca correctamente.
        return $this->belongsToMany(
            Rol::class, 
            'role_usuario', 
            'usuario_id', // Nombre de la FK en la tabla pivot que apunta a este modelo
            'role_id'    // Nombre de la FK en la tabla pivot que apunta al modelo Rol
        )->withTimestamps(); // Incluir created_at y updated_at de la pivot
    }

    /**
     * Relación 1:N con Recetas (El Usuario es el creador)
     */
    public function recetas()
    {
        // Eloquent automáticamente buscará 'usuario_id' en la tabla 'recetas'
        return $this->hasMany(Receta::class, 'usuario_id');
    }
    
    /**
     * Relación 1:N con Planes
     */
    public function planes()
    {
        return $this->hasMany(Plan::class, 'usuario_id');
    }
    
    /**
     * Relación 1:N con Compras
     */
    public function compras()
    {
        return $this->hasMany(Compra::class, 'usuario_id');
    }
    
    /**
     * Relación 1:N con Listas de Compra
     */
    public function listasCompra()
    {
        return $this->hasMany(ListaCompra::class, 'usuario_id');
    }

    /**
     * Relación 1:1 con Imagen (Avatar)
     */
    public function avatar()
    {
        // La clave foránea 'imagen_id' está en la tabla de Usuarios, 
        // y la clave local es 'imagen_id', pero la clave PK del otro lado es 'id'.
        return $this->morphOne(Imagen::class, 'imageable');
    }
}
