<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import BrandLogo from '@/components/BrandLogo.vue';

defineProps<{
    title: string;
    login_url: string;
    register_url: string;
    dashboard_url: string;
    sales_email: string;
    can_register: boolean;
}>();
</script>

<template>
    <Head :title="title" />

    <div class="min-h-screen bg-white text-slate-900">
        <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/80 backdrop-blur">
            <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4">
                <div class="flex items-center gap-3">
                    <BrandLogo class="h-9 w-auto" />
                    <span class="text-sm font-semibold tracking-tight">Carvaz ExpenseTracker</span>
                </div>

                <nav class="hidden items-center gap-6 text-sm text-slate-600 md:flex">
                    <a href="#features" class="hover:text-slate-900">Features</a>
                    <a href="#dashboard" class="hover:text-slate-900">Dashboard</a>
                    <a href="#reports" class="hover:text-slate-900">Reportes</a>
                    <a href="#faqs" class="hover:text-slate-900">FAQs</a>
                </nav>

                <div class="flex items-center gap-2">
                    <Link
                        :href="login_url"
                        class="hidden rounded-md px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 md:inline-flex"
                    >
                        Iniciar sesión
                    </Link>

                    <Link
                        v-if="can_register"
                        :href="register_url"
                        class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700"
                    >
                        Crear cuenta
                    </Link>
                    <Link
                        v-else
                        :href="login_url"
                        class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700"
                    >
                        Entrar
                    </Link>
                </div>
            </div>
        </header>

        <main class="bg-gradient-to-b from-blue-50 via-white to-slate-50">
            <div class="pointer-events-none absolute inset-x-0 -z-10 h-[520px] bg-[radial-gradient(ellipse_at_top,rgba(37,99,235,0.18),transparent_55%)]" />
            <slot />
        </main>

        <footer class="border-t border-slate-200 bg-slate-50">
            <div class="mx-auto grid max-w-6xl grid-cols-1 gap-8 px-4 py-12 md:grid-cols-4">
                <div>
                    <div class="flex items-center gap-2">
                        <BrandLogo class="h-8 w-auto" />
                        <span class="text-sm font-semibold">Carvaz</span>
                    </div>
                    <p class="mt-3 text-sm text-slate-600">
                        Controla tus gastos e ingresos con dashboards claros y reportes mensuales.
                    </p>
                </div>

                <div>
                    <div class="text-sm font-semibold">Producto</div>
                    <ul class="mt-3 space-y-2 text-sm text-slate-600">
                        <li><a href="#dashboard" class="hover:text-slate-900">Dashboard</a></li>
                        <li><a href="#features" class="hover:text-slate-900">Features</a></li>
                        <li><a href="#reports" class="hover:text-slate-900">Reportes</a></li>
                    </ul>
                </div>

                <div>
                    <div class="text-sm font-semibold">Recursos</div>
                    <ul class="mt-3 space-y-2 text-sm text-slate-600">
                        <li><a href="/docs/PROJECT_LOG.md" class="hover:text-slate-900">Documentación</a></li>
                        <li><a href="/features/docs/FEATURE_INVENTORY.md" class="hover:text-slate-900">Feature inventory</a></li>
                    </ul>
                </div>

                <div>
                    <div class="text-sm font-semibold">Contacto</div>
                    <ul class="mt-3 space-y-2 text-sm text-slate-600">
                        <li>
                            <a :href="`mailto:${sales_email}`" class="hover:text-slate-900">{{ sales_email }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t">
                <div class="mx-auto flex max-w-6xl flex-col gap-2 px-4 py-6 text-xs text-slate-500 md:flex-row md:items-center md:justify-between">
                    <div>© {{ new Date().getFullYear() }} Carvaz. Todos los derechos reservados.</div>
                    <div class="flex items-center gap-4">
                        <a href="#" class="hover:text-slate-900">Soporte</a>
                        <a href="#" class="hover:text-slate-900">Redes</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
