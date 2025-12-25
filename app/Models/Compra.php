<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Compra extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'compras';

    protected $fillable = [
        'usuario_id',
        'plan_id',
        'total',
        'estado',
        'fecha_compra'
    ];

    protected $casts = [
        'fecha_compra' => 'datetime',
        'total' => 'decimal:4'
    ];

    /**
     * Usuario que realiza la compra
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    /**
     * Plan asociado a la compra (si procede)
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Listas de compra incluidas en esta compra
     */
    public function listas()
    {
        return $this->belongsToMany(
            ListaCompra::class,
            'compra_lista_compra'
        )->withTimestamps();
    }
}