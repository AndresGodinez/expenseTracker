# Brand + UI Guide — Carvaz ExpenseTracker

Esta guía define una paleta y reglas de UI para el sitio de marketing (Home) y pantallas tipo dashboard.

## Objetivo visual
- Moderno, limpio, profesional
- Enfoque “finanzas + claridad de datos” (similar a apps de presupuesto)
- Jerarquía clara, contraste alto, superficies suaves

## Paleta (recomendada)
> Basada en Tailwind (equivalentes aproximados).

### Brand / Primary
- Primary 600: `#2563EB`
- Primary 700 (hover): `#1D4ED8`
- Primary 50 (tints): `#EFF6FF`

### Neutrales
- Text (900): `#0F172A`
- Muted text (600): `#475569`
- Border (200): `#E2E8F0`
- Surface (50): `#F8FAFC`
- Background: `#FFFFFF`

### Semánticos (dashboard)
- Success (incomes): `#16A34A`
- Danger (expenses): `#EF4444`
- Info (balance/neutral highlight): `#0EA5E9`

## Gradientes y fondos (marketing)
- Fondo hero (suave): `from-blue-50 via-white to-slate-50`
- Sección alterna: `bg-slate-50`
- Cards: `bg-white` + borde `border-slate-200` + shadow sutil

## Tipografía
- Headings: `Inter` (ya presente) o `Manrope` si luego quieres diferenciar marca
- Body: `Inter`

### Escala recomendada
- H1: `text-4xl md:text-6xl` + `tracking-tight`
- H2: `text-3xl md:text-4xl`
- Body: `text-base md:text-lg`
- Labels: `text-xs` / `text-sm`

## Componentes (tokens de UI)

### Botones
- Primary:
  - `bg-blue-600 text-white hover:bg-blue-700`
  - `rounded-md px-4 py-2 font-semibold`
- Secondary:
  - `border border-slate-200 bg-white hover:bg-slate-50`

### Cards
- Base:
  - `rounded-2xl border border-slate-200 bg-white`
  - `shadow-sm hover:shadow-md transition`

### Badges
- `bg-slate-100 text-slate-700` (neutral)
- `bg-blue-100 text-blue-800` (brand)

## Charts (consistencia)
- Ingresos: verde
- Gastos: rojo
- Balance: azul/cyan
- Doughnut: máx 8–10 colores suaves, evitar saturación alta

## Accesibilidad
- Contraste mínimo AA en textos principales
- Estados hover/focus visibles

## Notas de implementación
- Usar alternancia de secciones (white / slate-50) para ritmo visual
- Agregar “glow”/radial muy sutil en hero para profundidad sin ruido
