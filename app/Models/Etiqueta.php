<?php

namespace App\Models;

use App\Traits\AplicarSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Etiqueta extends Model
{
    use HasFactory, HasUuids;
    use AplicarSlug;

    protected $table = 'etiquetas';

    // Configuración UUID
    protected $keyType = 'string';
    public $incrementing = false;

    protected $campoSlug = 'nombre';

    protected $fillable = [
        'nombre',
        'slug'
    ];

    // Relaciones

    /**
     * Una receta tiene muchas Etiquetas (N:M)
     * La tabla pivot es 'receta_etiqueta'.
     */
    public function recetas()
    {
        return $this->belongsToMany(Receta::class, 'receta_etiqueta')->withTimestamps();
    }
}
