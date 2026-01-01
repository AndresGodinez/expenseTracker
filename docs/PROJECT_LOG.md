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

- CRUD de métodos de pago (PaymentMethod) siguiendo el mismo estándar de Category:
  - DB/Modelo:
    - Migración: `database/migrations/2025_12_31_000010_create_payment_methods_table.php`
      - `payment_methods`: `id`, `name` (`string(29)`), `unique`, `active` (boolean default true), timestamps
    - Modelo: `app/Models/PaymentMethod.php` (casts: `active` boolean)
  - Validación con FormRequests:
    - `app/Http/Requests/StorePaymentMethodRequest.php`
    - `app/Http/Requests/UpdatePaymentMethodRequest.php` (unique ignorando el registro actual)
  - Controller:
    - `app/Http/Controllers/PaymentMethodController.php` (`index/create/store/edit/update/destroy`)
    - `index()` ordenado por `name`
    - `store/update/destroy` redirigen a `payment-methods.index` (flujo web)
    - URLs para frontend se pasan como props (`*_url`) para evitar `route()` en Vue
  - Rutas web (middleware `auth`) en `routes/web.php`:
    - `payment-methods.index/create/store/edit/update/destroy`
  - UI Inertia (Vue):
    - `resources/js/pages/payment-methods/Index.vue`
    - `resources/js/pages/payment-methods/Create.vue`
    - `resources/js/pages/payment-methods/Edit.vue`
  - Tests (Pest Feature):
    - `tests/Feature/PaymentMethods/ListPaymentMethodsTest.php`
    - `tests/Feature/PaymentMethods/CreatePaymentMethodPageTest.php`
    - `tests/Feature/PaymentMethods/CreatePaymentMethodTest.php`
    - `tests/Feature/PaymentMethods/UpdatePaymentMethodTest.php`
    - `tests/Feature/PaymentMethods/DeletePaymentMethodTest.php`

- CRUD de gastos (Expense) siguiendo el mismo estándar (web + Inertia + Vue + TDD):
  - DB/Modelo:
    - Migración: `database/migrations/2025_12_31_000020_create_expenses_table.php`
      - `expenses`: `id`, `name` (`string(29)` unique), `amount` (`decimal(8,2)`),
        `category_id` nullable (FK categories), `payment_method_id` nullable (FK payment_methods),
        `active` (boolean default true), timestamps
    - Modelo: `app/Models/Expense.php`
      - `amount` casteado a `decimal:2`
      - Relaciones: `category()` y `paymentMethod()`
  - Validación con FormRequests:
    - `app/Http/Requests/StoreExpenseRequest.php`
    - `app/Http/Requests/UpdateExpenseRequest.php` (unique ignorando el registro actual)
  - Controller:
    - `app/Http/Controllers/ExpenseController.php` (`index/create/store/edit/update/destroy`)
    - Listado ordenado por `created_at` DESC (más recientes primero)
    - Paginación configurable con `per_page` (default 15; opciones: 15/30/50/100)
    - Filtros por `category_id` y `payment_method_id`
    - Se calcula y muestra `page_total_amount` (suma de `amount` de los elementos desplegados)
    - `store/update/destroy` redirigen a `expenses.index`
    - URLs para frontend se pasan como props (`*_url`) para evitar `route()` en Vue
    - Nota técnica: `page_total_amount` se serializa como **string con 2 decimales** para evitar mismatches de tipo (int/float) en asserts estrictos de Inertia/Pest.
  - Rutas web (middleware `auth`) en `routes/web.php`:
    - `expenses.index/create/store/edit/update/destroy`
  - UI Inertia (Vue):
    - `resources/js/pages/expenses/Index.vue`
    - `resources/js/pages/expenses/Create.vue`
    - `resources/js/pages/expenses/Edit.vue`
  - Tests (Pest Feature):
    - `tests/Feature/Expenses/ListExpensesTest.php`
    - `tests/Feature/Expenses/CreateExpensePageTest.php`
    - `tests/Feature/Expenses/CreateExpenseTest.php`
    - `tests/Feature/Expenses/UpdateExpenseTest.php`
    - `tests/Feature/Expenses/DeleteExpenseTest.php`

- CRUD de categorías de ingresos (CategoryIncome) siguiendo el mismo estándar de Category:
  - DB/Modelo:
    - Migración: `database/migrations/2025_12_31_000040_create_category_incomes_table.php`
      - `category_incomes`: `id`, `name` (`string(29)`), `unique`, timestamps
    - Modelo: `app/Models/CategoryIncome.php`
  - Validación con FormRequests:
    - `app/Http/Requests/StoreCategoryIncomeRequest.php`
    - `app/Http/Requests/UpdateCategoryIncomeRequest.php` (unique ignorando el registro actual)
  - Controller:
    - `app/Http/Controllers/CategoryIncomeController.php` (`index/create/store/edit/update/destroy`)
    - `index()` ordenado por `name`
    - `store/update/destroy` redirigen a `category-incomes.index`
    - URLs para frontend se pasan como props (`*_url`) para evitar `route()` en Vue
  - Rutas web (middleware `auth`) en `routes/web.php`:
    - `category-incomes.index/create/store/edit/update/destroy`
  - UI Inertia (Vue):
    - `resources/js/pages/category-incomes/Index.vue`
    - `resources/js/pages/category-incomes/Create.vue`
    - `resources/js/pages/category-incomes/Edit.vue`
  - Tests (Pest Feature):
    - `tests/Feature/CategoryIncomes/ListCategoryIncomesTest.php`
    - `tests/Feature/CategoryIncomes/CreateCategoryIncomePageTest.php`
    - `tests/Feature/CategoryIncomes/CreateCategoryIncomeTest.php`
    - `tests/Feature/CategoryIncomes/UpdateCategoryIncomeTest.php`
    - `tests/Feature/CategoryIncomes/DeleteCategoryIncomeTest.php`

- CRUD de cuentas (Account) siguiendo el mismo estándar de Category:
  - DB/Modelo:
    - Migración: `database/migrations/2025_12_31_000050_create_accounts_table.php`
      - `accounts`: `id`, `name` (`string(29)`), `unique`, timestamps
    - Modelo: `app/Models/Account.php`
  - Validación con FormRequests:
    - `app/Http/Requests/StoreAccountRequest.php`
    - `app/Http/Requests/UpdateAccountRequest.php` (unique ignorando el registro actual)
  - Controller:
    - `app/Http/Controllers/AccountController.php` (`index/create/store/edit/update/destroy`)
    - `index()` ordenado por `name`
    - `store/update/destroy` redirigen a `accounts.index`
    - URLs para frontend se pasan como props (`*_url`) para evitar `route()` en Vue
  - Rutas web (middleware `auth`) en `routes/web.php`:
    - `accounts.index/create/store/edit/update/destroy`
  - UI Inertia (Vue):
    - `resources/js/pages/accounts/Index.vue`
    - `resources/js/pages/accounts/Create.vue`
    - `resources/js/pages/accounts/Edit.vue`
  - Tests (Pest Feature):
    - `tests/Feature/Accounts/ListAccountsTest.php`
    - `tests/Feature/Accounts/CreateAccountPageTest.php`
    - `tests/Feature/Accounts/CreateAccountTest.php`
    - `tests/Feature/Accounts/UpdateAccountTest.php`
    - `tests/Feature/Accounts/DeleteAccountTest.php`

- CRUD de ingresos (Income) siguiendo el mismo estándar (web + Inertia + Vue + TDD):
  - DB/Modelo:
    - Migración: `database/migrations/2025_12_31_000030_create_incomes_table.php`
      - `incomes`: `id`, `name` (`string(29)` unique), `category_income_id` (required), `amount` (`decimal(8,2)`), `account_id` (required), timestamps
    - Migración adicional (FKs): `database/migrations/2025_12_31_000060_add_income_foreign_keys.php`
      - Agrega foreign keys a `category_incomes` y `accounts` (por orden de migraciones)
    - Modelo: `app/Models/Income.php`
      - `amount` casteado a `decimal:2`
      - Relaciones: `categoryIncome()` y `account()`
  - Validación con FormRequests:
    - `app/Http/Requests/StoreIncomeRequest.php`
    - `app/Http/Requests/UpdateIncomeRequest.php` (unique ignorando el registro actual)
  - Controller:
    - `app/Http/Controllers/IncomeController.php` (`index/create/store/edit/update/destroy`)
    - Listado ordenado por `created_at` DESC (más recientes primero)
    - Paginación configurable con `per_page` (default 15; opciones: 15/30/50/100)
    - Filtros por `category_income_id` y `account_id`
    - Se calcula y muestra `page_total_amount` (suma de `amount` de los elementos desplegados)
    - `store/update/destroy` redirigen a `incomes.index`
    - URLs para frontend se pasan como props (`*_url`) para evitar `route()` en Vue
  - Rutas web (middleware `auth`) en `routes/web.php`:
    - `incomes.index/create/store/edit/update/destroy`
  - UI Inertia (Vue):
    - `resources/js/pages/incomes/Index.vue`
    - `resources/js/pages/incomes/Create.vue`
    - `resources/js/pages/incomes/Edit.vue`
  - Tests (Pest Feature):
    - `tests/Feature/Incomes/ListIncomesTest.php`
    - `tests/Feature/Incomes/CreateIncomePageTest.php`
    - `tests/Feature/Incomes/CreateIncomeTest.php`
    - `tests/Feature/Incomes/UpdateIncomeTest.php`
    - `tests/Feature/Incomes/DeleteIncomeTest.php`

- Cierre mensual (Monthly Reports) - snapshots + totales por categoría + email (testeado):
  - DB:
    - Migración: `database/migrations/2026_01_01_000070_create_monthly_reports_tables.php`
      - `monthly_reports`: mes (`month_start`, `month_end`), totales (`total_expenses_amount`, `total_incomes_amount`)
      - `monthly_report_expenses`: snapshot de expenses del mes
      - `monthly_report_incomes`: snapshot de incomes del mes
      - `monthly_report_expense_category_totals`: total de gastos por `category_id`
      - `monthly_report_income_category_totals`: total de ingresos por `category_income_id`
  - Job:
    - `app/Jobs/GenerateMonthlyFinancialSummary.php`
    - Se ejecuta el día 1, 00:00 y genera el corte del mes anterior
    - Inserta snapshots + totales por categoría y actualiza `monthly_reports`
  - Email:
    - Mailable: `app/Mail/MonthlyFinancialSummaryMail.php`
    - View: `resources/views/emails/monthly-financial-summary.blade.php`
    - Contenido: "Has gastado ..." + desglose por categorías + total
  - Scheduling:
    - `routes/console.php` agenda el job con `monthlyOn(1, '00:00')`
  - Tests (Pest Feature):
    - `tests/Feature/MonthlyReports/GenerateMonthlyFinancialSummaryTest.php` (usa `Mail::fake()`; no requiere credenciales)

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
