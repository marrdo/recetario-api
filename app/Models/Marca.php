<?php

namespace App\Models;

use App\Traits\AplicarSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Marca extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    use AplicarSlug;

    protected $table = 'marcas';

    // Configuración UUID
    protected $keyType = 'string';
    public $incrementing = false;

    protected $campoSlug = 'nombre';

    protected $fillable = [
        'nombre',
        'slug',
    ];

    
    // Relaciones
    // Una marca tiene muchos productos comerciales
    public function alimentoPrecios()
    {
        return $this->hasMany(AlimentoPrecio::class);
    }

    // Imagen polimórfica
    public function logo()
    {
        return $this->morphOne(Imagen::class, 'imageable');
    }
}
