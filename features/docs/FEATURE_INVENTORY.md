# Feature Inventory — ExpenseTracker

Este archivo lista las características actuales del sistema (backend + UI) a alto nivel.

## Autenticación
- Login / sesiones (middleware `auth`)
- Rutas protegidas para las secciones principales

## Catálogos
- Categorías de gasto (Category)
  - CRUD web + Inertia (Vue)
  - Validación con FormRequests
  - Tests Feature con Pest
- Métodos de pago (PaymentMethod)
  - CRUD web + Inertia (Vue)
  - Campo `active`
  - Tests Feature con Pest
- Categorías de ingreso (CategoryIncome)
  - CRUD web + Inertia (Vue)
  - Tests Feature con Pest
- Cuentas (Account)
  - CRUD web + Inertia (Vue)
  - Tests Feature con Pest

## Movimientos
- Gastos (Expense)
  - CRUD web + Inertia (Vue)
  - Filtros (categoría / método de pago)
  - Paginación configurable y total por página
  - Tests Feature con Pest
- Ingresos (Income)
  - CRUD web + Inertia (Vue)
  - Filtros (categoría / cuenta)
  - Paginación configurable y total por página
  - Tests Feature con Pest

## Cierre mensual (Monthly Reports)
- Generación automática del reporte del mes anterior
  - Job `GenerateMonthlyFinancialSummary` ejecutado el día 1 a las 00:00
  - Crea `monthly_reports` con totales de gastos/ingresos y balance
  - Guarda snapshots:
    - `monthly_report_expenses`
    - `monthly_report_incomes`
  - Guarda totales por categoría:
    - `monthly_report_expense_category_totals`
    - `monthly_report_income_category_totals`
  - Calcula variaciones mes contra mes (amount y percent) y las persiste en `monthly_reports`
- Email del cierre mensual
  - Mailable `MonthlyFinancialSummaryMail`
  - Tests con `Mail::fake()` (sin credenciales)
- UI de reportes mensuales
  - Index (últimos 12 meses)
  - Show (detalle por categorías y snapshots)
  - Tests Feature con Pest

## Dashboard
- KPIs MTD (mes en curso)
  - Gastos / ingresos / balance
- Comparativos MTD vs mes anterior (mismo rango de días)
  - Cambio en monto y % para gastos, ingresos y balance
- Gráficas (Chart.js + vue-chartjs)
  - Línea: gastos vs ingresos (MTD)
  - Barras horizontales: top categorías de gasto del mes
  - Doughnut: distribución de gastos por categoría
  - Línea: tendencia 12 meses (gastos / ingresos / balance) basada en `monthly_reports`
- Tests Feature con Pest validando props de Inertia
