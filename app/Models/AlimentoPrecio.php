<?php

namespace App\Models;

use App\Traits\AplicarSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; 

class AlimentoPrecio extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'alimento_precios';

    // Configuración UUID
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'alimento_id',
        'supermercado_id',
        'marca_id',
        'peso_envase',
        'precio_envase',
        'precio_por_base',
        'descripcion_paquete',
        'codigo_barras',
    ];

    protected function casts(): array
    {
        return [
            'peso_envase'   => 'integer',
            'precio_envase' => 'decimal:2',
            'precio_por_base' => 'decimal:4',
        ];
    }

    /**
     * Lógica automática: Calcular precio por kg antes de guardar
     */
    protected static function booted()
    {
        static::saving(function ($alimentoPrecio) { // En booted es cuando se lanza un evento del modelo, en este caso se actuara cada vwz que se guarde el registro
            if ($alimentoPrecio->peso_envase > 0 && $alimentoPrecio->precio_envase > 0) {
                // Cálculo: (Precio / Peso en gramos) * 1000 x ejemplo
                $alimentoPrecio->precio_por_base = ($alimentoPrecio->precio_envase / $alimentoPrecio->peso_envase) * 1000;
            }
        });
    }

    // RELACIONES

    public function alimento()
    {
        return $this->belongsTo(Alimento::class, 'alimento_id');
    }

    public function supermercado()
    {
        return $this->belongsTo(Supermercado::class, 'supermercado_id');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

    public function imagen()
    {
        return $this->morphOne(Imagen::class, 'imageable');
    }
}
