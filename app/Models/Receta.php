<?php

namespace App\Models;

use App\Traits\AplicarSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; // <-- IMPORTANTE: Trait para Soft Deletes

class Receta extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    use AplicarSlug;

    protected $table = 'recetas';

    // Configuración UUID
    protected $keyType = 'string';
    public $incrementing = false;

    protected $campoSlug = 'titulo';

    protected $fillable = [
            'usuario_id',
            'titulo',
            'slug',
            'external_url',
            'calorias_totales',
            'grasas_totales',
            'hidratos_totales',
            'proteinas_totales',
            'fibra',
            'azucar',
            'sodio',
            'descripcion',
            'instrucciones',
            'tiempo_preparacion',
            'tiempo_coccion',
            'porciones',
            'dificultad',
            'personas',
            'verificado'
    ];

    protected function casts(): array
    {
        return [
            'calorias_totales' => 'decimal:2',
            'grasas_totales' => 'decimal:2',
            'hidratos_totales' => 'decimal:2',
            'proteinas_totales' => 'decimal:2',
            'fibra' => 'decimal:2',
            'azucar' => 'decimal:2',
            'sodio' => 'decimal:2',
            'verificado' => 'boolean',
        ];
    }

    /**
     * Una receta pertenece a un Usuario (el creador)
     */
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'usuario_id', 'id');
    }

    /**
     * Una receta tiene muchos ingredientes.
     */
    public function ingredientes()
    {
        return $this->hasMany(IngredientesReceta::class, 'receta_id');
    }

    /**
     * Una receta tiene muchas Etiquetas (N:M)
     * La tabla pivot es 'receta_etiqueta'.
     */
    public function etiquetas()
    {
        return $this->belongsToMany(Etiqueta::class, 'receta_etiqueta')->withTimestamps();
    }
}
