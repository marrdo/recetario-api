<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlimentoRequest extends FormRequest
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
            //
            'categoria_id' => 'nullable|exists:categorias_alimentos,id',
            'nombre' => 'required|string|max:255',
            'unidad_base' => 'required|in:g,ml,unidad',
            'cantidad_base' => 'required|integer|min:1',
            'calorias_por_base' => 'numeric|min:0',
            'proteinas_por_base' => 'numeric|min:0',
            'grasas_por_base' => 'numeric|min:0',
            'carbohidratos_por_base' => 'numeric|min:0',
            'notas' => 'nullable|string',
        ];
    }
}
