<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlanItem extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'plan_items';

    protected $fillable = [
        'plan_id',
        'fecha',
        'momento_dia',
        'receta_id',
        'alimento_id',
        'cantidad',
        'unidad',
        'calorias_totales',
        'orden'
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'cantidad' => 'decimal:2',
            'calorias_totales' => 'decimal:2',
            'orden' => 'integer'
        ];
    }

    protected static function booted()
    {
        static::saving(function ($item) {
            if (
                ($item->receta_id && $item->alimento_id) ||
                (!$item->receta_id && !$item->alimento_id)
            ) {
                throw new \Exception(
                    'PlanItem debe tener receta_id o alimento_id, pero no ambos.'
                );
            }
        });
    }
    // RELACIONES

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function receta()
    {
        return $this->belongsTo(Receta::class, 'receta_id');
    }

    public function alimento()
    {
        return $this->belongsTo(Alimento::class, 'alimento_id');
    }
}
