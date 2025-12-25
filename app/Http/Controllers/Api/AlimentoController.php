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
    public function index()
    {
        //
        $alimentos = Alimento::with('categoria')->paginate(15);

        return AlimentoResource::collection($alimentos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlimentoRequest $request)
    {
        //
        $alimento = Alimento::create($request->validated());

        return new AlimentoResource($alimento);
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
        $alimento->update($request->validated());

        return new AlimentoResource($alimento);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alimento $alimento)
    {
        // $alimento->forceDelete();
        $alimento->delete();
        
        return response()->json([
            'message' => 'Alimento eliminado'
        ], 204);
    }
}
