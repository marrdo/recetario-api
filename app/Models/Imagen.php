<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Imagen extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'imagenes';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'imageable_type',
        'imageable_id',
        'ruta_desktop',
        'ruta_mobile',
        'ruta_thumb',
        'titulo_alt',
        'orden'
    ];

    /**
     * Esta es la relación polimórfica.
     * El nombre 'imageable' es el que busca Laravel por defecto.
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
