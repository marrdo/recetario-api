<?php

namespace App\Models;

use App\Traits\AplicarSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Supermercado extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    use AplicarSlug;

    protected $table = 'supermercados';

    // Configuración UUID
    protected $keyType = 'string';
    public $incrementing = false;

    protected $campoSlug = 'nombre';

    protected $fillable = [
        'nombre',
        'slug',
        'web',
    ];

    // Relaciones
    public function alimentoPrecios()
    {
        return $this->hasMany(AlimentoPrecio::class);
    }

    public function logo()
    {
        return $this->morphOne(Imagen::class, 'imageable');
    }
}
