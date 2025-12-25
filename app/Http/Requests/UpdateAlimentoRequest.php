<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAlimentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'categoria_id' => 'sometimes|nullable|exists:categorias_alimentos,id',
            'nombre' => 'sometimes|string|max:255',
            'unidad_base' => 'sometimes|in:g,ml,unidad',
            'cantidad_base' => 'sometimes|integer|min:1',
            'calorias_por_base' => 'sometimes|numeric|min:0',
            'proteinas_por_base' => 'sometimes|numeric|min:0',
            'grasas_por_base' => 'sometimes|numeric|min:0',
            'carbohidratos_por_base' => 'sometimes|numeric|min:0',
            'notas' => 'sometimes|nullable|string',
        ];
    }
}
