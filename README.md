# Recetario API

API REST desarrollada con **Laravel 12**, orientada a la gestión de recetas, alimentos y planificación nutricional.

El proyecto sigue un enfoque **API-first**, preparado para ser consumido por cualquier frontend (web o móvil) y con control de acceso avanzado mediante autenticación y roles.

---

## Características principales

- Autenticación segura mediante **Laravel Sanctum**
- Control de acceso por **roles y habilidades (abilities)**
- Separación entre:
  - Parte pública (consulta de recetas)
  - Panel privado (gestión interna)
- Gestión de:
  - Usuarios
  - Roles
  - Alimentos
  - Recetas
  - Planificación nutricional
- Código mantenible, escalable y orientado a buenas prácticas

---

## Tecnologías utilizadas

- **PHP 8.3**
- **Laravel 12**
- **Laravel Sanctum**
- **MySQL / MariaDB**
- **Composer**
- **Git & GitHub**

---

## Autenticación y seguridad

La API utiliza **Laravel Sanctum** para la autenticación mediante tokens personales.

- Protección de rutas con middleware `auth:sanctum`
- Control granular de permisos mediante `abilities`
- Preparada para múltiples roles con distintos niveles de acceso

Ejemplo de uso de rutas protegidas:

```php
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
```

---

## Roles previstos
El sistema contempla los siguientes roles iniciales:
- Admin
- Nutricionista
- Entrenador
- Cliente
Cada rol tendrá asociadas habilidades específicas para limitar el acceso a los distintos recursos de la API.

---

## Instalación y configuración

- Clonar el repositorio
```bash
git clone https://github.com/tuusuario/recetario-api.git
cd recetario-api
```
- Instalar dependencias
```bash
composer install
```
- Configurar entorno
```bash
cp .env.example .env
php artisan key:generate
```
Configura los datos de conexión a la base de datos en el archivo .env.

- Ejecutar migraciones
```bash
php artisan migrate
```
- Arranque del servidor de desarrollo
```bash
php artisan serve
```
La API estará disponible en:
```bash
http://localhost:8000/api
```
---

## Estado del proyecto

🟡 En desarrollo activo

- Autenticación base implementada
- Estructura inicial de roles y permisos
- CRUDs en desarrollo
- Planificación nutricional en diseño

---

## Roadmap
- CRUD completo de alimentos
- CRUD de recetas
- Planificación nutricional
- Sistema avanzado de roles y abilities
- Documentación de la API (Swagger / OpenAPI)

---

## Autor
**Manuel Maldonado**
Proyecto de práctica y aprendizaje avanzado en desarrollo de APIs con Laravel.

---

## Licencia
Este proyecto se distribuye bajo licencia MIT.

--- 