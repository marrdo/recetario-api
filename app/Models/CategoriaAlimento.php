<?php

namespace App\Models;

use App\Traits\AplicarSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; 

class CategoriaAlimento extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    use AplicarSlug;

    protected $table = 'categorias_alimentos';

    // Configuración UUID
    protected $keyType = 'string';
    public $incrementing = false;

    protected $campoSlug = 'nombre';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'color',
    ];

    // Relaciones
    
    /**
     * Una Categoría de Alimento tiene muchos Alimentos
     */
    public function alimentos()
    {
        // 'categoria_id' en la tabla 'alimentos'
        return $this->hasMany(Alimento::class, 'categoria_id');
    }
}
