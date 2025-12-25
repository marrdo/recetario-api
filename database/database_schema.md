# Arquitectura de Base de Datos - Recet_app_rio

Este documento describe el diagrama Entidad-Relación (ERD) y la lógica de negocio detrás de la estructura de datos del proyecto **Recet_app_rio**.

> Convenciones
> - PK: Primary Key (UUID)
> - FK: Foreign Key
> - Pivote: Tabla intermedia para relaciones N:M
> - Nombres en `snake_case`
> - Base de datos objetivo: **MySQL / MariaDB**
> - UUIDs generados por Laravel (`$table->uuid('id')->primary()` y lógica en los models para generar `Str::uuid()`)

---

## 1. Usuarios y Roles
Gestión de acceso y permisos mediante sistema RBAC (Role-Based Access Control).

### tabla: `usuarios`
- **Lógica**: Tabla principal de cuentas del sistema. Contiene la información básica del usuario.
- **Datos:**
    | Campo      | Tipo         | Null | Extra |
    | ---------- | ------------ | ---- | ----- |
    | id         | uuid         | NO   | PK |
    | nombre     | varchar(255) | NO   | |
    | email      | varchar(255) | NO   | unique |
    | password   | varchar(255) | NO   | |
    | telefono   | varchar(50)  | YES  | |
    | active     | boolean      | NO   | default true |
    | notas      | text         | YES  | |
    | created_at | timestamp    | YES  | |
    | updated_at | timestamp    | YES  | |

### tabla: `roles`
- **Lógica**: Definición de perfiles (ej: admin, usuario, nutricionista, entrenador).
- **Datos:**
    | Campo       | Tipo         | Null | Extra |
    | ----------- | ------------ | ---- | ----- |
    | id          | uuid         | NO   | PK |
    | nombre      | varchar(100) | NO   | unique |
    | descripcion | text         | YES  | |
    | created_at  | timestamp    | YES  | |
    | updated_at  | timestamp    | YES  | |

### tabla: `role_usuario` (pivot)
- **Lógica**: Asociación N:M entre usuarios y roles, permite múltiples roles por usuario.
- **Datos:**
    | Campo      | Tipo      | Null | Extra |
    | ---------- | --------- | ---- | ----- |
    | id         | uuid      | NO   | PK |
    | role_id    | uuid      | NO   | FK `roles.id` |
    | usuario_id | uuid      | NO   | FK `usuarios.id` |
    | created_at | timestamp | YES  | |
    | updated_at | timestamp | YES  | |

---

## 2. Catálogo de Alimentos (Core)
Separación entre **nutrición** y **comercial**.

### tabla: `categorias_alimentos`
- **Lógica**: Clasificación nutricional de alimentos (cereales, lácteos, frutas...).
- **Datos:**
    | Campo       | Tipo         | Null |
    | ----------- | ------------ | ---- |
    | id          | uuid         | NO |
    | nombre      | varchar(100) | NO, unique |
    | descripcion | text         | YES |
    | created_at  | timestamp    | YES |
    | updated_at  | timestamp    | YES |

### tabla: `alimentos`
- **Lógica**: Entidad nutricional base. No contiene marcas ni precios.
- **Datos:**
    | Campo                  | Tipo                    | Null | Extra |
    | ---------------------- | ----------------------- | ---- | ----- |
    | id                     | uuid                    | NO   | PK |
    | categoria_id           | uuid                    | YES  | FK `categorias_alimentos.id` |
    | nombre                 | varchar(255)            | NO   | |
    | unidad_base            | enum('g','ml','unidad') | NO   | default 'g' |
    | cantidad_base          | integer                 | NO   | default 100 (ej. por 100g) |
    | calorias_por_base      | decimal(8,2)            | NO   | (por cada cantidad_base) |
    | proteinas_por_base     | decimal(8,2)            | NO   | |
    | grasas_por_base        | decimal(8,2)            | NO   | |
    | carbohidratos_por_base | decimal(8,2)            | NO   | |
    | notas                  | text                    | YES  | |
    | created_at             | timestamp               | YES  | |
    | updated_at             | timestamp               | YES  | |

### tabla: `supermercados`
- **Lógica**: Entidades comerciales (Mercadona, Carrefour, etc).
- **Datos:**
    | Campo      | Tipo         | Null | Extra |
    | ---------- | ------------ | ---- | ----- |
    | id         | uuid         | NO   | PK |
    | nombre     | varchar(255) | NO   | unique |
    | slug       | varchar(255) | NO   | |
    | web        | varchar(255) | YES  | |
    | created_at | timestamp    | YES  | |
    | updated_at | timestamp    | YES  | |

### tabla: `marcas`
- **Lógica**: Lista de marcas comerciales (Hacendado, Eroski, ...) — opcional pero útil para filtrar.
- **Datos:**
    | Campo      | Tipo         | Null |
    | ---------- | ------------ | ---- |
    | id         | uuid         | NO |
    | nombre     | varchar(255) | NO, unique |
    | slug       | varchar(255) | NO |
    | created_at | timestamp    | YES |
    | updated_at | timestamp    | YES |

### tabla: `alimento_precios` (producto comercial)
- **Lógica**: Producto físico en estantería. Se enlaza al alimento genérico y al supermercado; contiene peso/envase y precio. Aquí también referenciamos la marca.
- **Datos:**
    | Campo               | Tipo          | Null | Extra |
    | ------------------- | ------------- | ---- | ----- |
    | id                  | uuid          | NO   | PK |
    | alimento_id         | uuid          | NO   | FK `alimentos.id` |
    | supermercado_id     | uuid          | NO   | FK `supermercados.id` |
    | marca_id            | uuid          | YES  | FK `marcas.id` |
    | peso_envase         | integer       | NO   | Gramos o ml totales del envase |
    | precio_envase       | decimal(10,2) | YES  | Precio total del envase |
    | precio_por_kg       | decimal(10,2) | YES  | Calculado para comparativas |
    | descripcion_paquete | varchar(255)  | YES  | Ej: "Bolsa 1kg" |
    | codigo_barras       | varchar(100)  | YES  | |
    | created_at          | timestamp     | YES  | |
    | updated_at          | timestamp     | YES  | |

---

## 3. Recetario
Sistema de creación de platos basado en alimentos base.

### tabla: `recetas`
- **Lógica**: Cabecera de una receta; contiene datos agregados (campos derivados) para rendimiento de la API.
- **Datos:**
    | Campo              | Tipo                            | Null | Extra |
    | ------------------ | ------------------------------- | ---- | ----- |
    | id                 | uuid                            | NO   | PK |
    | usuario_id         | uuid                            | NO   | FK `usuarios.id` |
    | titulo             | varchar(255)                    | NO   | |
    | descripcion        | text                            | YES  | |
    | instrucciones      | longtext                        | YES  | (markdown / HTML) |
    | external_url       | varchar(255)                    | YES  | (video o fuente) |
    | tiempo_preparacion | integer                         | NO   | segundos |
    | tiempo_coccion     | integer                         | YES  | segundos |
    | porciones          | integer                         | NO   | default 1 |
    | dificultad         | enum('facil','media','dificil') | NO   | default 'media' |
    | personas           | integer                         | NO   | default 1 |
    | calorias_totales   | decimal(10,2)                   | NO   | default 0 (derivado) |
    | grasas_totales     | decimal(10,2)                   | NO   | default 0 (derivado) |
    | hidratos_totales   | decimal(10,2)                   | NO   | default 0 (derivado) |
    | proteinas_totales  | decimal(10,2)                   | NO   | default 0 (derivado) |
    | created_at         | timestamp                       | YES  | |
    | updated_at         | timestamp                       | YES  | |

### tabla: `ingredientes_receta`
- **Lógica**: Pivot entre receta y alimento (cantidad y datos calculados por esa cantidad).
- **Datos:**
    | Campo              | Tipo                     | Null | Extra |
    | ------------------ | ------------------------ | ---- | ----- |
    | id                 | uuid                     | NO   | PK |
    | receta_id          | uuid                     | NO   | FK `recetas.id` |
    | alimento_id        | uuid                     | NO   | FK `alimentos.id` |
    | cantidad           | decimal(10,2)            | NO   | cantidad en `unidad_base` del alimento |
    | calorias_totales   | decimal(10,2)            | NO   | derivado: (calorias_por_base * cantidad / cantidad_base) |
    | grasas_totales     | decimal(10,2)            | NO   | derivado |
    | grasas_saturadas   | decimal(10,2)            | YES  | opcional |
    | hidratos_totales   | decimal(10,2)            | NO   | derivado |
    | azucares_aniadidos | decimal(10,2)            | YES  | opcional |
    | proteinas_totales  | decimal(10,2)            | NO   | derivado |
    | precio_total       | decimal(10,4)            | YES  | calculado si existe alimento_precio seleccionado |
    | nota               | text                     | YES  | |
    | created_at         | timestamp                | YES  | |
    | updated_at         | timestamp                | YES  | |

### tabla: `etiquetas`
- **Lógica**: Clasificaciones para filtrar/etiquetar recetas.
- **Datos:**
    | Campo      | Tipo        | Null |
    | ---------- | ----------- | ---- |
    | id         | uuid        | NO |
    | nombre     | varchar(50) | NO, unique |
    | created_at | timestamp   | YES |
    | updated_at | timestamp   | YES |

### tabla: `receta_etiqueta` (pivot)
- **Lógica**: Asociaciones N:M entre recetas y etiquetas.
- **Datos:**
    | Campo       | Tipo    | Null |
    | ----------- | ------- | ---- |
    | id          | uuid    | NO |
    | receta_id   | uuid FK | NO |
    | etiqueta_id | uuid FK | NO |
    | created_at  | timestamp | YES |
    | updated_at  | timestamp | YES |

---

## 4. Sistema de Planificación
Motor para organizar la ingesta calórica en el tiempo.

### tabla: `planes`
- **Lógica**: Contenedor que define un periodo y objetivo calórico.
- **Datos:**
    | Campo                    | Tipo             | Null |
    | ------------------------ | ---------------- | ---- |
    | id                       | uuid             | NO |
    | usuario_id               | uuid             | NO, FK `usuarios.id` |
    | nombre                   | varchar(255)     | NO |
    | fecha_inicio             | date             | YES |
    | fecha_fin                | date             | YES |
    | calorias_objetivo_diario | integer          | YES |
    | created_at               | timestamp        | YES |
    | updated_at               | timestamp        | YES |

### tabla: `plan_items`
- **Lógica**: Unidad de planificación, permite asignar recetas o alimentos sueltos a un día y momento.
- **Datos:**
    | Campo       | Tipo                                                                     | Null |
    | ----------- | ------------------------------------------------------------------------ | ---- |
    | id          | uuid                                                                     | NO |
    | plan_id     | uuid                                                                     | NO, FK `planes.id` |
    | fecha       | date                                                                     | NO |
    | momento_dia | enum('desayuno','media_manana','comida','merienda','media_tarde','cena') | NO |
    | receta_id   | uuid nullable                                                            | YES, FK `recetas.id` |
    | alimento_id | uuid nullable                                                            | YES, FK `alimentos.id` |
    | cantidad    | decimal(10,2)                                                            | YES, cantidad si se usa alimento suelto |
    | unidad      | enum('g','ml','unidad')                                                  | YES |
    | created_at  | timestamp                                                                | YES |
    | updated_at  | timestamp                                                                | YES |

---

## 5. Compras e Inventario
Gestión de la adquisición de productos. **Una `compra` es un conjunto de `listas_compra`.**  
Cuando un usuario crea una `compra` agrupa varias `listas_compra`; al consolidar, las cantidades de `items` iguales se suman (ej: jamón 120g + 80g → 200g).

### tabla: `compras`
- **Lógica**: Representa un acto de compra que puede agrupar varias listas.
- **Datos:**
    | Campo      | Tipo                                                       | Null |
    | ---------- | ---------------------------------------------------------- | ---- |
    | id         | uuid                                                       | NO |
    | usuario_id | uuid                                                       | NO, FK `usuarios.id` |
    | total      | decimal(12,4) default 0                                    | NO |
    | estado     | enum('pendiente','comprado','cancelado') default 'pendiente' | NO |
    | fecha_compra | timestamp nullable                                        | YES |
    | created_at | timestamp                                                  | YES |
    | updated_at | timestamp                                                  | YES |

### tabla: `compra_lista_compra` (pivot)
- **Lógica**: Asociar varias `listas_compra` a una `compra`.
- **Datos:**
    | Campo           | Tipo      | Null |
    | --------------- | --------- | ---- |
    | id              | uuid      | NO |
    | compra_id       | uuid      | NO, FK `compras.id` |
    | lista_compra_id | uuid      | NO, FK `listas_compra.id` |
    | created_at      | timestamp | YES |
    | updated_at      | timestamp | YES |

### tabla: `listas_compra`
- **Lógica**: Listas de compra (manuales o generadas a partir de recetas).
- **Datos:**
    | Campo       | Tipo                  | Null |
    | ----------- | --------------------- | ---- |
    | id          | uuid                  | NO |
    | usuario_id  | uuid                  | NO, FK `usuarios.id` |
    | nombre      | varchar(255) nullable | YES |
    | descripcion | text nullable         | YES |
    | created_at  | timestamp             | YES |
    | updated_at  | timestamp             | YES |

### tabla: `items_lista_compra`
- **Lógica**: Renglón de una lista; se asocia a `alimentos` y, opcionalmente, a un `alimento_precio` y a `supermercado`.  
  - Si `alimento_precio_id` es null → se usa el alimento genérico y el frontend sugiere el mejor precio.
  - Cuando `compra` consolida varias `listas_compra`, se suman las `cantidad` de items iguales.
- **Datos:**
    | Campo              | Tipo                   | Null |
    | ------------------ | ---------------------- | ---- |
    | id                 | uuid                   | NO |
    | lista_compra_id    | uuid                   | NO, FK `listas_compra.id` |
    | alimento_id        | uuid                   | NO, FK `alimentos.id` |
    | alimento_precio_id | uuid nullable          | YES, FK `alimento_precios.id` |
    | supermercado_id    | uuid nullable          | YES, FK `supermercados.id` |
    | cantidad           | decimal(10,2)          | NO |
    | unidad             | enum('g','ml','unidad')| NO, default 'g' |
    | comprado           | boolean default false  | NO |
    | precio_unitario    | decimal(10,4) nullable | YES |
    | precio_total       | decimal(12,4) nullable | YES |
    | created_at         | timestamp              | YES |
    | updated_at         | timestamp              | YES |

---

## 6. Sistema de Imágenes (Polimórfico)
Repositorio centralizado de imágenes para cualquier entidad.

### tabla: `imagenes`
- **Lógica**: Almacena rutas de imágenes tanto para mobile como desktop. Relación polimórfica mediante `imageable_type` y `imageable_id`.
- **Datos:**
    | Campo         | Tipo        | Null |
    | ------------- | ----------- | ---- |
    | id            | uuid        | NO |
    | imageable_type| varchar(255)| NO  | Ej: App\Models\Receta |
    | imageable_id  | uuid        | NO  | FK (dependiendo del modelo) |
    | path_desktop  | varchar(255)| NO  |
    | path_mobile   | varchar(255)| YES |
    | alt_text      | varchar(255)| YES |
    | created_at    | timestamp   | YES |
    | updated_at    | timestamp   | YES |

---

## Diagrama de Cardinalidad (Resumen)
1. **usuarios** 1 -- N **planes**
2. **planes** 1 -- N **plan_items**
3. **usuarios** 1 -- N **recetas**
4. **recetas** 1 -- N **ingredientes_receta** (-> alimentos)
5. **usuarios** 1 -- N **listas_compra**
6. **listas_compra** 1 -- N **items_lista_compra** (-> alimentos + alimento_precios[nullable])
7. **alimentos** 1 -- N **alimento_precios**
8. **supermercados** 1 -- N **alimento_precios**
9. **compras** N -- M **listas_compra** (pivot `compra_lista_compra`) → luego consolidación de items en `compras`

---

## Notas de diseño y reglas de negocio
- **UUIDs**: todas las PK serán UUID para evitar colisiones y facilitar sincronización entre entornos. Laravel generará los UUIDs en modelos o durante la inserción.
- **Cálculos nutricionales**:
  - `ingredientes_receta.calorias_totales` = `(alimentos.calorias_por_base * ingredientes_receta.cantidad) / alimentos.cantidad_base`
  - Lo mismo para macros (proteínas, grasas, hidratos).
  - `recetas.calorias_totales` = `SUM(ingredientes_receta.calorias_totales)` y se actualiza cada vez que cambie un ingrediente.
- **Precios**:
  - `alimento_precios.precio_por_kg` (o `precio_por_gramo` si lo prefieres) se calcula al insertar/actualizar el `alimento_precio` si `precio_envase` y `peso_envase` existen.
  - `items_lista_compra.precio_total` se calcula como `precio_unitario * cantidad`.
- **Consolidación de compras**:
  - Cuando se crea una `compra` y se asocian varias `listas_compra`, el backend debe agregar cantidades de `items` con el mismo `alimento_id` y unidad para mostrar la cantidad total a comprar (ej: jamón 200g).
- **Imágenes**:
  - La tabla `imagenes` es polimórfica; por ejemplo `imageable_type = App\Models\Receta` y `imageable_id = <uuid_receta>`.
- **Roles**:
  - Usar pivot `role_usuario` permite múltiples roles por usuario y facilita añadir permisos más adelante.
- **Indexado**:
  - Añadir índices en columnas FK (usuario_id, alimento_id, receta_id ...) para optimizar joins.
- **Validaciones**:
  - Todos los endpoints deben validar unidades (si `unidad_base` es `unidad` y `cantidad` decimal no tiene sentido, validar en la capa de aplicación).