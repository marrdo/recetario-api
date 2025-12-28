<?php

namespace App\Policies;

use App\Auth\Abilities;
use App\Models\Alimento;
use App\Models\Usuario;
use Illuminate\Auth\Access\Response;
/**
 * Class AlimentoPolicy
 *
 * Esta policy define QUÉ puede hacer un Usuario autenticado
 * sobre el modelo Alimento.
 *
 * Laravel llama automáticamente a estos métodos cuando se usa:
 * $this->authorize('accion', $modelo);
 *
 * La policy NO ejecuta lógica de negocio:
 * - SOLO decide si se permite o no
 * - Devuelve true (permitido) o false (denegado)
 */
class AlimentoPolicy
{
    /**
     * Determina si el usuario puede ver listados de alimentos.
     *
     * Se usa automáticamente en index()
     *
     * @param Usuario $usuario Usuario autenticado
     * @return bool
     */
    public function viewAny(Usuario $usuario): bool
    {
        // Cualquier usuario autenticado puede listar alimentos
        return true;
    }

    /**
     * Determina si el usuario puede ver un alimento concreto.
     *
     * Se usa automáticamente en show()
     *
     * @param Usuario $usuario Usuario autenticado
     * @param Alimento $alimento Modelo solicitado
     * @return bool
     */
    public function view(Usuario $usuario, Alimento $alimento): bool
    {
        return true;
    }

    /**
     * Determina si el usuario puede crear alimentos.
     *
     * Se usa en store()
     *
     * @param Usuario $usuario
     * @return bool
     */
    public function create(Usuario $usuario): bool
    {
        // Solo tokens con la ability MANAGE_ALIMENTOS pueden crear
        return $usuario->tokenCan(Abilities::MANAGE_ALIMENTOS);
    }

    /**
     * Determina si el usuario puede actualizar un alimento.
     *
     * Se usa en update()
     *
     * @param Usuario $usuario
     * @param Alimento $alimento
     * @return bool
     */
    public function update(Usuario $usuario, Alimento $alimento): bool
    {
        return $usuario->tokenCan(Abilities::MANAGE_ALIMENTOS);
    }

    /**
     * Determina si el usuario puede eliminar (soft delete) un alimento.
     *
     * Se usa en destroy()
     *
     * @param Usuario $usuario
     * @param Alimento $alimento
     * @return bool
     */
    public function delete(Usuario $usuario, Alimento $alimento): bool
    {
        return $usuario->tokenCan(Abilities::MANAGE_ALIMENTOS);
    }

    /**
     * Determina si el usuario puede restaurar un alimento eliminado.
     *
     * Se usa con restore()
     * (no lo estás usando todavía)
     *
     * @param Usuario $usuario
     * @param Alimento $alimento
     * @return bool
     */
    public function restore(Usuario $usuario, Alimento $alimento): bool
    {
        return $usuario->tokenCan(Abilities::MANAGE_ALIMENTOS);
    }

    /**
     * Determina si el usuario puede eliminar definitivamente un alimento.
     *
     * Se usa en forceDelete()
     *
     * @param Usuario $usuario
     * @param Alimento $alimento
     * @return bool
     */
    public function forceDelete(Usuario $usuario, Alimento $alimento): bool
    {
        return false;
    }
}
