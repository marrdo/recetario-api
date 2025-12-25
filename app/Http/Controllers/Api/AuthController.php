<?php

namespace App\Http\Controllers\Api;

use App\Auth\Abilities;
use App\Http\Controllers\Controller;
use App\Http\Resources\UsuarioResource;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $abilities = [];
        // Buscamos al usuario con sus roles cargados
        $usuario = Usuario::with('roles')->where('email', $credentials['email'])->first();

        // 1. Verificamos existencia y contraseña
        if (! $usuario || ! Hash::check($credentials['password'], $usuario->password)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        // 2. Verificamos si la cuenta está activa
        if (! $usuario->active) {
            return response()->json(['message' => 'Esta cuenta está desactivada'], 403);
        }

        // 3. Auditoría: Actualizamos último login e IP
        $usuario->update([
            'ultimo_login' => now(),
            'usuario_ip' => $request->ip()
        ]);

        // 4. Generamos abilities donde le pondremos abilities al rol.
        if($usuario->roles->contains('nombre', 'admin')) {
            $abilities = [
                Abilities::ADMIN_PANEL,
                Abilities::MANAGE_ALIMENTOS,
            ];
        }

        // 5. Generamos token abilities
        $token = $usuario->createToken('api-token', $abilities)->plainTextToken;

        return response()->json([
            'token' => $token,
            'usuario' => new UsuarioResource($usuario),
            'message' => 'Bienvenido, ' . $usuario->nombre
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout correcto'
        ]);
    }
}
