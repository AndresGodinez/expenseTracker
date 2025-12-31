# Project Log — ExpenseTracker

Este documento sirve como **contexto vivo** del proyecto. La idea es mantener aquí un registro breve y claro de:

- Cambios realizados (qué y por qué)
- Decisiones técnicas
- Pendientes / próximos pasos
- Notas importantes para retomar rápido el contexto

## Cómo usar este archivo
- Agrega una entrada por sesión de trabajo.
- Mantén las entradas cortas: 5–15 líneas normalmente.
- Si una decisión afecta arquitectura o dependencias, documenta el motivo.

---

## 2025-12-31
### Estado
- Proyecto base Laravel + Pest.

### Cambios
- Entorno actualizado a PHP 8.5 (para cumplir dependencias que requieren PHP >= 8.4).
- Feature inicial (modo web) para crear categorías con TDD:
  - Tests de feature: `tests/Feature/Categories/CreateCategoryTest.php`
  - Migración: `database/migrations/2025_12_31_000000_create_categories_table.php`
    - `categories`: `id`, `name` (`string(100)`), `unique`, timestamps
  - Modelo: `app/Models/Category.php`
  - Validación con FormRequest: `app/Http/Requests/StoreCategoryRequest.php`
    - Reglas: `required|string|max:100|unique:categories,name`
  - Controller: `app/Http/Controllers/CategoryController.php`
  - Rutas web (middleware `auth`):
    - `GET /categories` -> `categories.index`
    - `GET /categories/create` -> `categories.create`
    - `POST /categories` -> `categories.store`
    - `GET /categories/{category}/edit` -> `categories.edit`
    - `PUT /categories/{category}` -> `categories.update`
    - `DELETE /categories/{category}` -> `categories.destroy`

- CRUD de categorías (web + UI Inertia + tests):
  - Listado ordenado por nombre:
    - Test: `tests/Feature/Categories/ListCategoriesTest.php`
    - Page: `resources/js/pages/categories/Index.vue`
  - Crear categoría (pantalla + form):
    - Test: `tests/Feature/Categories/CreateCategoryPageTest.php`
    - Page: `resources/js/pages/categories/Create.vue`
    - `store()` redirige a `categories.index` (flujo web)
  - Editar/actualizar categoría:
    - Test: `tests/Feature/Categories/UpdateCategoryTest.php`
    - Request: `app/Http/Requests/UpdateCategoryRequest.php`
    - Page: `resources/js/pages/categories/Edit.vue`
  - Eliminar categoría:
    - Test: `tests/Feature/Categories/DeleteCategoryTest.php`
    - Acción desde el listado (botón Delete en `Index.vue`)

- Notas de entorno (frontend):
  - Fue necesario actualizar Node (Node 14 no soporta sintaxis moderna usada por Vite).
  - Para desarrollo se requiere correr ambos procesos:
    - `php artisan serve`
    - `npm run dev`
  - `@vite` en `resources/views/app.blade.php` debe incluir solo el entry (`resources/js/app.ts`).
  - En páginas Vue de categorías se evitaron llamadas a `route()` del lado del cliente, pasando URLs desde el controller como props (por ejemplo: `create_url`, `index_url`).

### Notas
- Al ejecutar tests, se detectó un bloqueo por versión de PHP:
  - Dependencias del proyecto requieren **PHP >= 8.4**
  - PHP local estaba en **8.3.24**

### Próximos pasos
- Definir el primer flujo end-to-end de movimientos:
  - Crear gasto/ingreso con categoría opcional
  - Listar movimientos
  - Calcular resumen mensual
- Definir estructura de datos de movimientos (amount, date, description, category_id opcional).

---

## Backlog (alto nivel)
### Funcionalidad
- CRUD de movimientos
- Categorías
- Reporte mensual
- Resumen mensual (UI)
- Email del resumen

### Calidad
- Tests unit/feature por cada feature relevante
- CI (GitHub Actions / GitLab CI)

### Diseño
- Vistas de resumen (mensual)
- Visualizaciones (por categoría)
