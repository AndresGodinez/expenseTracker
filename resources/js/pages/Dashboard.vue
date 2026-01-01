<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Bar, Doughnut, Line } from 'vue-chartjs'
import {
    Chart as ChartJS,
    ArcElement,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    BarElement,
    Title,
    Tooltip,
    Legend,
} from 'chart.js'

type Kpis = {
    mtd_expenses: string
    mtd_incomes: string
    mtd_balance: string
    mtd_expenses_change_amount: string | null
    mtd_expenses_change_percent: string | null
    mtd_incomes_change_amount: string | null
    mtd_incomes_change_percent: string | null
    mtd_balance_change_amount: string | null
    mtd_balance_change_percent: string | null
}

type DashboardChart = {
    labels: string[]
    expenses: number[]
    incomes: number[]
}

type CategoryChart = {
    labels: string[]
    totals: number[]
}

type TrendChart = {
    labels: string[]
    expenses: number[]
    incomes: number[]
    balance: number[]
}

type TopCategoryRow = {
    category: string
    total_amount: string
    percent: string | null
}

defineProps<{
    kpis: Kpis
    chart: DashboardChart
    top_expense_categories: TopCategoryRow[]
    top_expense_categories_chart: CategoryChart
    trend_12_months: TrendChart
}>()

ChartJS.register(
    ArcElement,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    BarElement,
    Title,
    Tooltip,
    Legend,
)

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
                    <div
                        v-if="kpis.mtd_expenses_change_percent"
                        class="mt-1 text-xs text-muted-foreground"
                    >
                        vs mes pasado: {{ kpis.mtd_expenses_change_amount ?? '—' }}
                        <span class="px-1">·</span>
                        {{ kpis.mtd_expenses_change_percent }}
                    </div>
                </div>

                <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <div class="text-sm text-muted-foreground">Ingresos del mes</div>
                    <div class="mt-2 text-2xl font-semibold">{{ kpis.mtd_incomes }}</div>
                    <div
                        v-if="kpis.mtd_incomes_change_percent"
                        class="mt-1 text-xs text-muted-foreground"
                    >
                        vs mes pasado: {{ kpis.mtd_incomes_change_amount ?? '—' }}
                        <span class="px-1">·</span>
                        {{ kpis.mtd_incomes_change_percent }}
                    </div>
                </div>

                <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <div class="text-sm text-muted-foreground">Balance del mes</div>
                    <div class="mt-2 text-2xl font-semibold">{{ kpis.mtd_balance }}</div>
                    <div
                        v-if="kpis.mtd_balance_change_percent"
                        class="mt-1 text-xs text-muted-foreground"
                    >
                        vs mes pasado: {{ kpis.mtd_balance_change_amount ?? '—' }}
                        <span class="px-1">·</span>
                        {{ kpis.mtd_balance_change_percent }}
                    </div>
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

            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <div class="mb-3 text-sm font-medium">Top categorías del mes</div>

                    <div class="h-72">
                        <Bar
                            :data="{
                                labels: top_expense_categories_chart.labels,
                                datasets: [
                                    {
                                        label: 'Gastos',
                                        data: top_expense_categories_chart.totals,
                                        backgroundColor: 'rgba(239, 68, 68, 0.25)',
                                        borderColor: 'rgb(239, 68, 68)',
                                        borderWidth: 1,
                                    },
                                ],
                            }"
                            :options="{
                                responsive: true,
                                maintainAspectRatio: false,
                                indexAxis: 'y',
                                plugins: {
                                    legend: { display: false },
                                },
                                scales: {
                                    x: { beginAtZero: true },
                                },
                            }"
                        />
                    </div>

                    <div class="mt-4 rounded-lg border bg-card">
                        <div class="border-b px-4 py-3 text-sm font-medium">Detalle</div>
                        <div
                            v-if="top_expense_categories.length === 0"
                            class="px-4 py-6 text-sm text-muted-foreground"
                        >
                            No data.
                        </div>
                        <ul v-else class="divide-y">
                            <li
                                v-for="row in top_expense_categories"
                                :key="row.category"
                                class="flex items-center justify-between px-4 py-2 text-sm"
                            >
                                <span>{{ row.category }}</span>
                                <span class="text-muted-foreground">{{ row.percent ?? '—' }}</span>
                                <span class="font-medium">{{ row.total_amount }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <div class="mb-3 text-sm font-medium">Distribución de gastos (mes)</div>
                    <div class="h-72">
                        <Doughnut
                            :data="{
                                labels: top_expense_categories_chart.labels,
                                datasets: [
                                    {
                                        data: top_expense_categories_chart.totals,
                                        backgroundColor: [
                                            'rgba(239, 68, 68, 0.35)',
                                            'rgba(59, 130, 246, 0.35)',
                                            'rgba(34, 197, 94, 0.35)',
                                            'rgba(168, 85, 247, 0.35)',
                                            'rgba(234, 179, 8, 0.35)',
                                            'rgba(14, 165, 233, 0.35)',
                                            'rgba(244, 63, 94, 0.35)',
                                            'rgba(20, 184, 166, 0.35)',
                                            'rgba(99, 102, 241, 0.35)',
                                            'rgba(245, 158, 11, 0.35)',
                                        ],
                                        borderWidth: 1,
                                    },
                                ],
                            }"
                            :options="{
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { position: 'bottom' },
                                },
                            }"
                        />
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                <div class="mb-3 text-sm font-medium">Tendencia 12 meses</div>
                <div class="h-72">
                    <Line
                        :data="{
                            labels: trend_12_months.labels,
                            datasets: [
                                {
                                    label: 'Gastos',
                                    data: trend_12_months.expenses,
                                    borderColor: 'rgb(239, 68, 68)',
                                    backgroundColor: 'rgba(239, 68, 68, 0.15)',
                                    tension: 0.3,
                                },
                                {
                                    label: 'Ingresos',
                                    data: trend_12_months.incomes,
                                    borderColor: 'rgb(34, 197, 94)',
                                    backgroundColor: 'rgba(34, 197, 94, 0.15)',
                                    tension: 0.3,
                                },
                                {
                                    label: 'Balance',
                                    data: trend_12_months.balance,
                                    borderColor: 'rgb(59, 130, 246)',
                                    backgroundColor: 'rgba(59, 130, 246, 0.15)',
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
                        }"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
