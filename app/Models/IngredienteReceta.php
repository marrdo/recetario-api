<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IngredienteReceta extends Model
{
    // No se si es bueno añadir en ingrediente receta un softdelete, creo que no
    use HasFactory, HasUuids;

     protected $table = 'ingredientes_receta';

    // Configuración UUID
    protected $keyType = 'string';
    public $incrementing = false;


    protected $fillable = [
        'receta_id',
        'alimento_id',
        'cantidad',
        'calorias_totales',
        'grasas_totales',
        'grasas_saturadas',
        'hidratos_totales',
        'azucares_aniadidos',
        'proteinas_totales',
        'fibra',
        'sodio',
        'precio_total',
        'nota'
    ];

    protected function casts(): array
    {
        return [
            'calorias_totales' => 'decimal:2',
            'grasas_totales' => 'decimal:2',
            'grasas_saturadas' => 'decimal:2',
            'hidratos_totales' => 'decimal:2',
            'azucares_aniadidos' => 'decimal:2',
            'proteinas_totales' => 'decimal:2',
            'fibra' => 'decimal:2',
            'sodio' => 'decimal:2',
            'precio_total' => 'decimal:4',
        ];
    }

    // Relaciones

    /**
     * Un Ingrediente pertenece a una Receta
     */
    public function receta()
    {
        // La FK 'receta_id' está en esta tabla
        return $this->belongsTo(Receta::class, 'receta_id');
    }

    /**
     * Un Ingrediente referencia a un Alimento
     */
    public function alimento()
    {
        // La FK 'alimento_id' está en esta tabla
        return $this->belongsTo(Alimento::class, 'alimento_id');
    }
}
