<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlimentoRequest;
use App\Http\Requests\UpdateAlimentoRequest;
use App\Http\Resources\AlimentoResource;
use App\Models\Alimento;
use Illuminate\Http\Request;

class AlimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        // $alimentos = Alimento::with('categoria')->paginate(15);
        // Crear una query
        $query = Alimento::query()->with('categoria'); 

        // Filtro por soft deletes si no hay filtro, se hace deleted_at IS NULL por defecto
        if ($request->filled('trashed')) {
            // WHERE deleted_at IS NOT NULL
            if ($request->trashed === 'only') {
                $query->onlyTrashed();
            }
            // elimina el filtro automático
            if ($request->trashed === 'with') {
                $query->withTrashed();
            }
        }
        // Generar una busqueda por el campo q, como ejemplo, para buscar filtrando parcialmente.
        if ($request->filled('q')) {
            $query->where( function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->q . '%')
                ->orWhere('slug', 'like', '%' . $request->q . '%');
            });
        }

        // Aplicar filtros a campos concretos.
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }
        if ($request->filled('min_calorias')) {
            $query->where('calorias_por_base', '>=', $request->min_calorias);
        }
        if ($request->filled('unidad_base')) {
            $query->where('unidad_base', $request->unidad_base);
        }

        // Ordenar la query
        $camposPermitidos = [
            'nombre',
            'calorias_por_base',
            'created_at'
        ];

        $order = $request->get('order', 'nombre');
        $direction = 'asc';

        if (str_starts_with($order, '-')) {
            $direction = 'desc';
            $order = ltrim($order, '-');
        }

        if (in_array($order, $camposPermitidos)) {
            $query->orderBy($order, $direction);
        }

        // Ejecutamos la query y sacamos los alimentos paginados
        $alimentos = $query->paginate(15)->withQueryString();

        return AlimentoResource::collection($alimentos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlimentoRequest $request)
    {
        //

        $this->authorize('create', Alimento::class);

        $alimento = Alimento::create($request->validated());

        return new AlimentoResource($alimento->load('categoria'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Alimento $alimento)
    {
        //
        return new AlimentoResource(
            $alimento->load('categoria', 'imagenes')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlimentoRequest $request, Alimento $alimento)
    {
        //
        $this->authorize('update', $alimento);

        $alimento->update($request->validated());

        return new AlimentoResource($alimento);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alimento $alimento)
    {
        $this->authorize('delete', $alimento);

        if ($alimento->delete()) {
            return response(null, 204);
        } else {
            return response(null, 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function forceDestroy(Alimento $alimento)
    {
        $this->authorize('forceDelete', $alimento);
        
        if ($alimento->forceDelete()) {
            return response(null, 204);
        } else {
            return response(null, 404);
        }
    }

    /**
     * Restore a soft deleted resource.
     */
    public function restore(string $id)
    {
        // Buscar incluyendo eliminados
        $alimento = Alimento::withTrashed()->findOrFail($id);

        $this->authorize('restore', $alimento);

        $alimento->restore();

        return new AlimentoResource($alimento);
    }
}
