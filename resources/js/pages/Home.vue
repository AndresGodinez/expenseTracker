<script setup lang="ts">
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps<{
    can_register: boolean;
    login_url: string;
    register_url: string;
    dashboard_url: string;
    sales_email: string;
}>();
</script>

<template>
    <MarketingLayout
        title="Carvaz ExpenseTracker"
        :can_register="can_register"
        :login_url="login_url"
        :register_url="register_url"
        :dashboard_url="dashboard_url"
        :sales_email="sales_email"
    >
        <section class="">
            <div class="mx-auto grid max-w-6xl grid-cols-1 gap-10 px-4 py-16 md:grid-cols-2 md:items-center md:py-24">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full border bg-slate-50 px-3 py-1 text-xs font-medium text-slate-700">
                        <span class="h-2 w-2 rounded-full bg-green-500" />
                        Dashboards claros. Decisiones rápidas.
                    </div>

                    <h1 class="mt-4 text-4xl font-semibold tracking-tight text-slate-900 md:text-6xl">
                        Haz sentido de tu dinero. Cada mes.
                    </h1>
                    <p class="mt-4 text-lg leading-relaxed text-slate-600">
                        Registra gastos e ingresos, entiende tu balance y toma mejores decisiones con dashboards claros y reportes mensuales.
                    </p>

                    <ul class="mt-6 space-y-2 text-sm text-slate-700">
                        <li class="flex gap-2">
                            <span class="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-blue-600" />
                            Control diario: KPIs MTD y comparativos vs mes anterior.
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-blue-600" />
                            Insights: top categorías, distribución y tendencia 12 meses.
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-blue-600" />
                            Cierre mensual: resumen por categorías + email.
                        </li>
                    </ul>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <Link
                            v-if="can_register"
                            :href="register_url"
                            class="inline-flex items-center justify-center rounded-md bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700"
                        >
                            Crear cuenta gratis
                        </Link>
                        <Link
                            v-else
                            :href="login_url"
                            class="inline-flex items-center justify-center rounded-md bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700"
                        >
                            Entrar
                        </Link>
                        <a
                            href="#shots"
                            class="inline-flex items-center justify-center rounded-md border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-800 shadow-sm hover:bg-slate-50"
                        >
                            Ver el dashboard
                        </a>
                    </div>

                    <p class="mt-3 text-xs text-slate-500">
                        Menos Excel. Más claridad.
                    </p>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-gradient-to-b from-white to-slate-50 p-6 shadow-sm">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="text-sm font-semibold text-slate-900">Resumen del mes (MTD)</div>
                        <div class="mt-4 grid grid-cols-3 gap-3">
                            <div class="rounded-xl border border-slate-200 bg-white p-3">
                                <div class="text-xs text-slate-500">Gastos</div>
                                <div class="mt-1 text-base font-semibold text-red-600">$1,245.00</div>
                                <div class="mt-1 text-[11px] text-slate-500">vs mes pasado: -8.4%</div>
                            </div>
                            <div class="rounded-xl border border-slate-200 bg-white p-3">
                                <div class="text-xs text-slate-500">Ingresos</div>
                                <div class="mt-1 text-base font-semibold text-green-600">$2,340.00</div>
                                <div class="mt-1 text-[11px] text-slate-500">vs mes pasado: +3.1%</div>
                            </div>
                            <div class="rounded-xl border border-slate-200 bg-white p-3">
                                <div class="text-xs text-slate-500">Balance</div>
                                <div class="mt-1 text-base font-semibold text-blue-600">$1,095.00</div>
                                <div class="mt-1 text-[11px] text-slate-500">vs mes pasado: +14.0%</div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <div class="flex items-center justify-between">
                                <div class="text-xs font-medium text-slate-700">Ingresos vs Gastos</div>
                                <div class="text-[11px] text-slate-500">Mes en curso</div>
                            </div>
                            <div class="mt-3 h-28 rounded-xl border border-slate-200 bg-slate-50 p-3">
                                <div class="grid h-full grid-cols-12 items-end gap-1">
                                    <div class="h-6 rounded bg-green-500/50" />
                                    <div class="h-8 rounded bg-green-500/50" />
                                    <div class="h-10 rounded bg-green-500/50" />
                                    <div class="h-9 rounded bg-green-500/50" />
                                    <div class="h-11 rounded bg-green-500/50" />
                                    <div class="h-7 rounded bg-red-500/40" />
                                    <div class="h-6 rounded bg-red-500/40" />
                                    <div class="h-8 rounded bg-red-500/40" />
                                    <div class="h-7 rounded bg-red-500/40" />
                                    <div class="h-9 rounded bg-red-500/40" />
                                    <div class="h-10 rounded bg-blue-500/35" />
                                    <div class="h-12 rounded bg-blue-500/35" />
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 text-xs text-slate-500">
                            Mockup ilustrativo — tus datos reales aparecen al iniciar sesión.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="dashboard" class="bg-slate-50">
            <div class="mx-auto max-w-6xl px-4 py-16">
                <div class="max-w-2xl">
                    <h2 class="text-3xl font-semibold tracking-tight">Tu flujo de dinero, claro y sin ruido</h2>
                    <p class="mt-3 text-slate-600">
                        Visualiza ingresos vs gastos del mes y cómo cambia tu balance con el tiempo. En segundos entiendes qué cambió y dónde actuar.
                    </p>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="text-sm font-semibold">Comparativos MTD</div>
                        <p class="mt-2 text-sm text-slate-600">Mismo rango de días vs mes anterior para comparar justo.</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="text-sm font-semibold">Top categorías</div>
                        <p class="mt-2 text-sm text-slate-600">Detecta rápidamente en qué se está yendo tu dinero.</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="text-sm font-semibold">Tendencia 12 meses</div>
                        <p class="mt-2 text-sm text-slate-600">Patrones claros con datos del cierre mensual (rápido, sin queries pesados).</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="features" class="bg-white">
            <div class="mx-auto max-w-6xl px-4 py-16">
                <div class="max-w-2xl">
                    <h2 class="text-3xl font-semibold tracking-tight">Todo lo que necesitas para controlar tu presupuesto</h2>
                    <p class="mt-3 text-slate-600">
                        Desde el día a día hasta el cierre mensual: datos confiables, visuales claros y comparativos accionables.
                    </p>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold">Control de gastos</div>
                        <p class="mt-2 text-sm text-slate-600">
                            Registra gastos con categoría y método de pago. Filtra, pagina y revisa totales.
                        </p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold">Registro de ingresos</div>
                        <p class="mt-2 text-sm text-slate-600">
                            Registra ingresos por categoría y cuenta. Mantén tu balance al día.
                        </p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold">Dashboards decisionales</div>
                        <p class="mt-2 text-sm text-slate-600">
                            KPIs MTD + comparativos, top categorías, distribución y tendencia.
                        </p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold">Reportes mensuales</div>
                        <p class="mt-2 text-sm text-slate-600">
                            Últimos 12 meses, detalle por mes y variaciones mes contra mes.
                        </p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-2">
                            <div class="text-sm font-semibold">Alertas</div>
                            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-600">Próximamente</span>
                        </div>
                        <p class="mt-2 text-sm text-slate-600">
                            Notificaciones cuando te sales del presupuesto o cuando un gasto se dispara.
                        </p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-2">
                            <div class="text-sm font-semibold">Objetivos y métricas clave</div>
                            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-600">Próximamente</span>
                        </div>
                        <p class="mt-2 text-sm text-slate-600">
                            Define metas (ahorro, gasto por categoría) y sigue tu progreso.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-slate-50">
            <div class="mx-auto max-w-6xl px-4 py-16">
                <div class="max-w-2xl">
                    <h2 class="text-3xl font-semibold tracking-tight">De registrar datos a tomar decisiones</h2>
                    <p class="mt-3 text-slate-600">
                        Insights que se entienden en segundos: qué cambió, por qué cambió y dónde actuar.
                    </p>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-4">
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold">Visibilidad inmediata</div>
                        <p class="mt-2 text-sm text-slate-600">Gastos, ingresos y balance al momento.</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold">Mejores decisiones</div>
                        <p class="mt-2 text-sm text-slate-600">Detecta categorías top y recorta donde impacta.</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold">Menos fricción</div>
                        <p class="mt-2 text-sm text-slate-600">Cierre mensual automático para comparar mes a mes.</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold">Control sostenido</div>
                        <p class="mt-2 text-sm text-slate-600">Tendencia 12 meses para detectar patrones.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="shots" class="bg-white">
            <div class="mx-auto max-w-6xl px-4 py-16">
                <div class="max-w-2xl">
                    <h2 class="text-3xl font-semibold tracking-tight">Capturas del producto</h2>
                    <p class="mt-3 text-slate-600">
                        Un vistazo rápido a las pantallas clave (mockups/ilustraciones listos para reemplazar por screenshots reales).
                    </p>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="aspect-video rounded-xl border border-slate-200 bg-gradient-to-b from-slate-50 to-white" />
                        <div class="mt-3 text-sm font-semibold">Dashboard</div>
                        <p class="mt-1 text-sm text-slate-600">KPIs, comparativos y gráficas decisionales.</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm" id="reports">
                        <div class="aspect-video rounded-xl border border-slate-200 bg-gradient-to-b from-slate-50 to-white" />
                        <div class="mt-3 text-sm font-semibold">Reportes mensuales</div>
                        <p class="mt-1 text-sm text-slate-600">Últimos 12 meses + detalle por categorías.</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="aspect-video rounded-xl border border-slate-200 bg-gradient-to-b from-slate-50 to-white" />
                        <div class="mt-3 text-sm font-semibold">Top categorías</div>
                        <p class="mt-1 text-sm text-slate-600">Bar + doughnut para entender tu gasto.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-slate-50">
            <div class="mx-auto max-w-6xl px-4 py-16">
                <div class="max-w-2xl">
                    <h2 class="text-3xl font-semibold tracking-tight">Casos de uso</h2>
                    <p class="mt-3 text-slate-600">Ejemplos de cómo se usa para tomar decisiones reales.</p>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold">Freelancer</div>
                        <p class="mt-2 text-sm text-slate-600">“Ahora sé exactamente cuánto gano vs cuánto gasto y qué categorías vigilar.”</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold">Familia</div>
                        <p class="mt-2 text-sm text-slate-600">“El cierre mensual y la tendencia 12 meses nos dio claridad para ajustar el presupuesto.”</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold">Negocio pequeño</div>
                        <p class="mt-2 text-sm text-slate-600">“Top categorías y comparativos MTD me ayudan a decidir rápido dónde recortar.”</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="faqs" class="bg-white">
            <div class="mx-auto max-w-6xl px-4 py-16">
                <div class="max-w-2xl">
                    <h2 class="text-3xl font-semibold tracking-tight">FAQs</h2>
                    <p class="mt-3 text-slate-600">Respuestas rápidas a preguntas típicas antes de empezar.</p>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold">¿Necesito conectar mi banco?</div>
                        <p class="mt-2 text-sm text-slate-600">No. Puedes registrar gastos e ingresos manualmente y mantener control total.</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold">¿Cómo compara “este mes vs mes pasado”?</div>
                        <p class="mt-2 text-sm text-slate-600">Comparamos el MTD contra el mismo rango de días del mes anterior.</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold">¿Puedo ver historial?</div>
                        <p class="mt-2 text-sm text-slate-600">Sí. Tendencia 12 meses basada en reportes mensuales para consultas rápidas.</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold">¿Hay reportes automáticos?</div>
                        <p class="mt-2 text-sm text-slate-600">Sí. El cierre mensual genera el resumen del mes anterior y puede enviarse por email.</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold">¿Qué pasa si no tengo categorías?</div>
                        <p class="mt-2 text-sm text-slate-600">Se usa “Uncategorized” y puedes organizarlo después.</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-sm font-semibold">¿Cómo contacto al equipo?</div>
                        <p class="mt-2 text-sm text-slate-600">
                            Escríbenos a <a :href="`mailto:${sales_email}`" class="font-medium text-blue-700 hover:underline">{{ sales_email }}</a>
                        </p>
                    </div>
                </div>

                <div class="mt-10 rounded-3xl border border-slate-200 bg-gradient-to-r from-blue-50 via-white to-slate-50 p-8 shadow-sm">
                    <div class="grid grid-cols-1 items-center gap-6 md:grid-cols-2">
                        <div>
                            <div class="text-xl font-semibold">Empieza hoy con claridad financiera</div>
                            <p class="mt-2 text-sm text-slate-600">Crea tu cuenta y mira tu dashboard en minutos.</p>
                        </div>
                        <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                            <Link
                                v-if="can_register"
                                :href="register_url"
                                class="inline-flex items-center justify-center rounded-md bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700"
                            >
                                Crear cuenta
                            </Link>
                            <Link
                                v-else
                                :href="login_url"
                                class="inline-flex items-center justify-center rounded-md bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700"
                            >
                                Entrar
                            </Link>
                            <Link
                                :href="login_url"
                                class="inline-flex items-center justify-center rounded-md border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-800 shadow-sm hover:bg-slate-50"
                            >
                                Ver demo
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </MarketingLayout>
</template>
