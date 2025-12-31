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

### Notas
- Al ejecutar tests, se detectó un bloqueo por versión de PHP:
  - Dependencias del proyecto requieren **PHP >= 8.4**
  - PHP local estaba en **8.3.24**

### Próximos pasos
- Alinear entorno local a PHP 8.4.
- Definir el primer flujo end-to-end:
  - Crear movimiento (gasto/ingreso)
  - Listar movimientos
  - Calcular resumen mensual
- Definir modelo de datos inicial (movimientos, categorías).

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
