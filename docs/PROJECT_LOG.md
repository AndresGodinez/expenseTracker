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
  - Controller: `app/Http/Controllers/CategoryController.php` (`store`)
  - Ruta web: `POST /categories` -> `categories.store` (middleware `auth`)

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
