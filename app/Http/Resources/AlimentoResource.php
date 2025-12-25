<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlimentoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'slug' => $this->slug,
            'unidad_base' => $this->unidad_base,
            'cantidad_base' => $this->cantidad_base,
            'macros' => [
                'calorias' => $this->calorias_por_base,
                'proteinas' => $this->proteinas_por_base,
                'grasas' => $this->grasas_por_base,
                'carbohidratos' => $this->carbohidratos_por_base,
            ],
            'categoria' => $this->whenLoaded('categoria', fn () => [
                'id' => $this->categoria?->id,
                'nombre' => $this->categoria?->nombre,
            ]),
            'created_at' => $this->created_at,
        ];
    }
}
