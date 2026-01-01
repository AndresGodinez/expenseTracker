<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Line } from 'vue-chartjs'
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend,
} from 'chart.js'

type Kpis = {
    mtd_expenses: string
    mtd_incomes: string
    mtd_balance: string
    mtd_expenses_change_percent: string | null
    mtd_incomes_change_percent: string | null
}

type DashboardChart = {
    labels: string[]
    expenses: number[]
    incomes: number[]
}

defineProps<{
    kpis: Kpis
    chart: DashboardChart
}>()

ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend)

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid gap-4 md:grid-cols-4">
                <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <div class="text-sm text-muted-foreground">Gastos del mes</div>
                    <div class="mt-2 text-2xl font-semibold">{{ kpis.mtd_expenses }}</div>
                    <div v-if="kpis.mtd_expenses_change_percent" class="mt-1 text-xs text-muted-foreground">
                        vs mes pasado: {{ kpis.mtd_expenses_change_percent }}
                    </div>
                </div>

                <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <div class="text-sm text-muted-foreground">Ingresos del mes</div>
                    <div class="mt-2 text-2xl font-semibold">{{ kpis.mtd_incomes }}</div>
                    <div v-if="kpis.mtd_incomes_change_percent" class="mt-1 text-xs text-muted-foreground">
                        vs mes pasado: {{ kpis.mtd_incomes_change_percent }}
                    </div>
                </div>

                <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <div class="text-sm text-muted-foreground">Balance del mes</div>
                    <div class="mt-2 text-2xl font-semibold">{{ kpis.mtd_balance }}</div>
                </div>

                <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <div class="text-sm text-muted-foreground">Estado</div>
                    <div class="mt-2 text-sm text-muted-foreground">
                        KPIs calculados en tiempo real (MTD)
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                <div class="mb-3 text-sm font-medium">Gastos vs ingresos (mes en curso)</div>
                <div class="h-72">
                    <Line
                        :data="{
                            labels: chart.labels,
                            datasets: [
                                {
                                    label: 'Gastos',
                                    data: chart.expenses,
                                    borderColor: 'rgb(239, 68, 68)',
                                    backgroundColor: 'rgba(239, 68, 68, 0.15)',
                                    tension: 0.3,
                                },
                                {
                                    label: 'Ingresos',
                                    data: chart.incomes,
                                    borderColor: 'rgb(34, 197, 94)',
                                    backgroundColor: 'rgba(34, 197, 94, 0.15)',
                                    tension: 0.3,
                                },
                            ],
                        }"
                        :options="{
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'top' },
                                title: { display: false },
                            },
                            scales: {
                                y: { beginAtZero: true },
                            },
                        }"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
