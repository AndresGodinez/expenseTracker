# ExpenseTracker

Una aplicación web para registrar **gastos** e **ingresos**, generar **reportes mensuales**, y enviar un **resumen por email**.

## Objetivo
Centralizar el control de finanzas personales (o de un negocio pequeño) con:

- Registro simple de movimientos (gastos/ingresos)
- Resúmenes mensuales claros
- Reportes listos para compartir (incluyendo envío por correo)
- Desarrollo guiado por pruebas

## Features (Roadmap)
### Core
- Alta/edición/eliminación de movimientos
- Categorías (por ejemplo: Comida, Transporte, Servicios, Sueldo, etc.)
- Etiquetas/notas opcionales
- Moneda configurable

### Reportes
- Reporte mensual de:
  - Total de gastos
  - Total de ingresos
  - Balance (ingresos - gastos)
  - Desglose por categoría
- Resumen ejecutivo (vista rápida)

### Email
- Envío automático del resumen mensual
- (Opcional) Envío manual bajo demanda

### Calidad
- Suite de **tests** (unit + feature)
- CI (pendiente)

## Stack (actual)
- PHP
- Laravel
- Pest (testing)

> Nota: El stack puede evolucionar conforme avancemos el proyecto.

## Requisitos
- PHP **>= 8.4** (por dependencias actuales del proyecto)
- Composer
- Node.js + npm (para assets)

## Instalación
```bash
composer install
npm install
npm run build
```

Crea `.env` (si no existe) y genera la key:
```bash
cp .env.example .env
php artisan key:generate
```

## Base de datos
Por defecto, para tests se usa SQLite en memoria.

Para desarrollo, configura tu conexión en `.env` y ejecuta migraciones:
```bash
php artisan migrate
```

## Ejecutar en modo desarrollo
```bash
composer run dev
```

Alternativamente (y útil para debug), en dos terminales:

Terminal 1:
```bash
php artisan serve
```

Terminal 2:
```bash
npm run dev
```

## Tests
Ejecutar todos los tests:
```bash
./vendor/bin/pest
```

## Documentación viva / Bitácora
Para un registro incremental de decisiones, cambios y pendientes, revisa:

- `docs/PROJECT_LOG.md`

Ahí iremos documentando:
- Cambios relevantes
- Decisiones técnicas
- Próximos pasos
- Notas para retomar contexto rápidamente

## Convenciones (propuestas)
- Commits pequeños y frecuentes
- PRs con descripción clara (cuando aplique)
- Tests para features críticas

---

Si vas a contribuir o retomar el proyecto después de un tiempo, empieza por `docs/PROJECT_LOG.md`.
