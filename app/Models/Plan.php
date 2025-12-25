<?php

namespace App\Models;

use App\Traits\AplicarSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    use AplicarSlug;

    protected $table = 'planes';

    // Configuración UUID
    protected $keyType = 'string';
    public $incrementing = false;

    protected $campoSlug = 'nombre';

    protected $fillable = [
        'usuario_id',
        'nombre',
        'slug',
        'fecha_inicio',
        'fecha_fin',
        'calorias_objetivo_diario',
        'estado',
        'descripcion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
            'calorias_objetivo_diario' => 'integer',
        ];
    }

    // RELACIONES

    /**
     * El dueño del plan.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    /**
     * Los items (comidas) que componen este plan.
     */
    public function items()
    {
        return $this->hasMany(PlanItem::class, 'plan_id')->orderBy('fecha')->orderBy('momento_dia');
    }
}
