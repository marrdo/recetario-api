<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

trait AplicarSlug
{
    /**
     * Este método lo ejecuta Laravel automáticamente
     * cuando un modelo que usa este trait se "bootea".
     */
    public static function bootAplicarSlug()
    {
        /**
         * Evento: creating
         * Se ejecuta ANTES de crear el registro.
         */
        static::creating(function ($model) {

            // Campo desde el cual generamos el slug (por defecto 'nombre')
            $campoSlug = $model->campoSlug ?? 'nombre';

            // Si el slug está vacío pero el campo existe, lo generamos
            if (!empty($model->slug) || empty($model->{$campoSlug})) {
                return;
            }

            $baseSlug = Str::of($model->{$campoSlug})
                ->slug('-')
                ->lower();

            $slug = $baseSlug;
            $i = 1;

            // Mientras exista el slug, añadimos sufijo incremental
            while (
                $model->newQuery()
                      ->where('slug', $slug)
                      ->exists()
            ) {
                $slug = "{$baseSlug}-{$i}";
                $i++;
            }

            $model->slug = $slug;;
        });
    }
}
