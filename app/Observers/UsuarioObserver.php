<?php

namespace App\Observers;

use App\Models\Usuario;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;


class UsuarioObserver
{
    /**
     * Handle the Usuario "created" event.
     * Se ejecuta antes de que el usuario se guarde (por primera vez) cuando el usuario se CREA
     */
    public function created(Usuario $usuario): void
    {
        // Si se crea desde consola (seeders, migrate, tinker), no hacemos nada
        if (App::runningInConsole()) {
            return;
        }
        // Si el usuario no tiene IP, se la asignamos desde la petición
         if (empty($usuario->usuario_ip)) {
            $usuario->usuario_ip = request()->ip() ?? '127.0.0.1';
            $usuario->saveQuietly(); 
        }
        
        // (La MAC Address es difícil de obtener fiablemente en HTTP, 
        // a menudo se deja nula o se obtiene de forma específica, 
        // pero la lógica es similar a la IP si tuvieras el dato).
    }

    /**
     * Handle the Usuario "updated" event.
     * Se ejecuta cuando el usuario se ACTUALIZA
     */
    public function updated(Usuario $usuario): void
    {
        // 
    }

    /**
     * Handle the Usuario "deleted" event.
     */
    public function deleted(Usuario $usuarios): void
    {
        //
    }

    /**
     * Handle the Usuario "restored" event.
     */
    public function restored(Usuario $usuarios): void
    {
        //
    }

    /**
     * Handle the Usuario "force deleted" event.
     */
    public function forceDeleted(Usuario $usuarios): void
    {
        //
    }

    /**
     * Evento custom: login
     * (lo llamaremos manualmente)
     */
    public function login(Usuario $usuario)
    {
        $usuario->updateQuietly([
            'ultimo_login' => now(),
            'usuario_ip'   => Request::ip(),
        ]);
    }
}
