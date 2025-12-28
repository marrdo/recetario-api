<?php

namespace App\Models;

use App\Traits\AplicarSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Alimento extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    use AplicarSlug;

    protected $table = 'alimentos';

    // Configuración UUID
    protected $keyType = 'string';
    public $incrementing = false;

    protected $campoSlug = 'nombre';

    protected $fillable = [
        'categoria_id',
        'nombre',
        'slug',
        'unidad_base',
        'cantidad_base',
        'calorias_por_base',
        'proteinas_por_base',
        'grasas_por_base',
        'carbohidratos_por_base',
        'notas',
    ];

    protected function casts(): array
    {
        return [
            'calorias_por_base' => 'decimal:2',
            'proteinas_por_base' => 'decimal:2',
            'grasas_por_base' => 'decimal:2',
            'carbohidratos_por_base' => 'decimal:2',
        ];
    }

    // RELACIONES
    
    /**
     * Un Alimento pertenece a una Categoría (N:1)
     */
    public function categoria()
    {
        // La FK 'categoria_id' está en esta tabla (alimentos)
        return $this->belongsTo(CategoriaAlimento::class, 'categoria_id');
    }
    
    public function imagenes()
    {
        return $this->morphMany(Imagen::class, 'imageable');
    }

    /**
     * Un Alimento tiene muchos Precios/Productos Comerciales (1:N)
     */
    public function preciosComerciales()
    {
        // La FK 'alimento_id' está en la tabla 'alimento_precios'
        return $this->hasMany(AlimentoPrecio::class, 'alimento_id');
    }

    /**
     * Un Alimento puede ser usado en muchos ingredientes de Receta (1:N)
     */
    public function ingredientesReceta()
    {
        // modelo = IngredienteReceta
        return $this->hasMany(IngredienteReceta::class, 'alimento_id');
    }

    /**
     * Un Alimento puede ser añadido directamente a muchos Items de Plan (1:N)
     */
    public function itemsPlan()
    {
        return $this->hasMany(PlanItem::class, 'alimento_id');
    }

    /**
     * Un Alimento puede ser usado en muchos Items de Lista de Compra (1:N)
     */
    public function itemsListaCompra()
    {
        return $this->hasMany(ItemListaCompra::class, 'alimento_id');
    }
}
