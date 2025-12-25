<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ListaCompra extends Model
{
    use HasFactory, HasUuids;

     // Configuración UUID
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'listas_compra';
    protected $fillable = [
        'usuario_id', 
        'plan_id', 
        'nombre', 
        'descripcion', 
        'estado'
    ];

    // Relaciones

    /**
     * Usuario dueño de la lista de compra
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    /**
     * Plan del que se genera esta lista (opcional)
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Items (alimentos) que componen la lista
     */
    public function items()
    {
        return $this->hasMany(ItemListaCompra::class, 'lista_compra_id');
    }

    /**
     * Compras asociadas a esta lista (N:M)
     */
    public function compras()
    {
        return $this->belongsToMany(
            Compra::class,
            'compra_lista_compra'
        )->withTimestamps();
    }
}
