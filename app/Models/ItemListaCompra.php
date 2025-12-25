<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; 

class ItemListaCompra extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'items_lista_compra';

    protected $fillable = [
        'lista_compra_id',
        'alimento_id',
        'alimento_precio_id',
        'supermercado_id',
        'cantidad',
        'unidad',
        'comprado',
        'precio_unitario',
        'precio_total',
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'precio_unitario' => 'decimal:4',
        'precio_total' => 'decimal:4',
        'comprado' => 'boolean',
    ];

    /**
     * Lista de compra a la que pertenece el item
     */
    public function lista()
    {
        return $this->belongsTo(ListaCompra::class, 'lista_compra_id');
    }

    /**
     * Alimento base
     */
    public function alimento()
    {
        return $this->belongsTo(Alimento::class);
    }

    /**
     * Precio concreto del alimento (opcional)
     */
    public function alimentoPrecio()
    {
        return $this->belongsTo(AlimentoPrecio::class);
    }

    /**
     * Supermercado donde se compra
     */
    public function supermercado()
    {
        return $this->belongsTo(Supermercado::class);
    }

    /**
     * Calcula automáticamente el precio total
     */
    protected static function booted()
    {
        static::saving(function ($item) {
            if ($item->cantidad && $item->precio_unitario) {
                $item->precio_total =
                    $item->cantidad * $item->precio_unitario;
            }
        });
    }
}