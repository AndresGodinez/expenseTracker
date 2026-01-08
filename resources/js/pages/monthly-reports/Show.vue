<script setup lang="ts">
import AppShell from '@/components/AppShell.vue';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/vue3';

type TotalRow = {
    category: string;
    total_amount: string;
};

type SnapshotRow = {
    name: string;
    amount: string;
};

type Report = {
    id: number;
    month_start: string;
    month_end: string;
    total_expenses_amount: string;
    total_incomes_amount: string;
    balance_amount: string;
    expenses_change_amount: string | null;
    expenses_change_percent: string | null;
    incomes_change_amount: string | null;
    incomes_change_percent: string | null;
    balance_change_amount: string | null;
    balance_change_percent: string | null;
};

defineProps<{
    report: Report;
    expense_category_totals: TotalRow[];
    income_category_totals: TotalRow[];
    expense_snapshots: SnapshotRow[];
    income_snapshots: SnapshotRow[];
    index_url: string;
}>();
</script>

<template>
    <AppShell>
        <div class="space-y-6">
            <div class="flex items-start justify-between gap-4">
                <Heading
                    :title="`Monthly report: ${report.month_start} → ${report.month_end}`"
                    description="Totals and breakdown by category"
                />

                <Link :href="index_url" as="button">
                    <Button size="sm" variant="secondary">Back</Button>
                </Link>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                <div class="rounded-lg border bg-card p-4">
                    <div class="text-sm text-muted-foreground">
                        Total gastos
                    </div>
                    <div class="mt-2 text-2xl font-semibold">
                        {{ report.total_expenses_amount }}
                    </div>
                    <div class="mt-1 text-xs text-muted-foreground">
                        Δ vs mes anterior:
                        {{ report.expenses_change_amount ?? '—' }} ({{
                            report.expenses_change_percent ?? '—'
                        }})
                    </div>
                </div>

                <div class="rounded-lg border bg-card p-4">
                    <div class="text-sm text-muted-foreground">
                        Total ingresos
                    </div>
                    <div class="mt-2 text-2xl font-semibold">
                        {{ report.total_incomes_amount }}
                    </div>
                    <div class="mt-1 text-xs text-muted-foreground">
                        Δ vs mes anterior:
                        {{ report.incomes_change_amount ?? '—' }} ({{
                            report.incomes_change_percent ?? '—'
                        }})
                    </div>
                </div>

                <div class="rounded-lg border bg-card p-4">
                    <div class="text-sm text-muted-foreground">Balance</div>
                    <div class="mt-2 text-2xl font-semibold">
                        {{ report.balance_amount }}
                    </div>
                    <div class="mt-1 text-xs text-muted-foreground">
                        Δ vs mes anterior:
                        {{ report.balance_change_amount ?? '—' }} ({{
                            report.balance_change_percent ?? '—'
                        }})
                    </div>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-lg border bg-card">
                    <div class="border-b px-4 py-3 text-sm font-medium">
                        Gastos por categoría
                    </div>
                    <div
                        v-if="expense_category_totals.length === 0"
                        class="px-4 py-6 text-sm text-muted-foreground"
                    >
                        No data.
                    </div>
                    <ul v-else class="divide-y">
                        <li
                            v-for="row in expense_category_totals"
                            :key="row.category"
                            class="flex items-center justify-between px-4 py-3"
                        >
                            <span>{{ row.category }}</span>
                            <span class="font-medium">{{
                                row.total_amount
                            }}</span>
                        </li>
                    </ul>
                </div>

                <div class="rounded-lg border bg-card">
                    <div class="border-b px-4 py-3 text-sm font-medium">
                        Ingresos por categoría
                    </div>
                    <div
                        v-if="income_category_totals.length === 0"
                        class="px-4 py-6 text-sm text-muted-foreground"
                    >
                        No data.
                    </div>
                    <ul v-else class="divide-y">
                        <li
                            v-for="row in income_category_totals"
                            :key="row.category"
                            class="flex items-center justify-between px-4 py-3"
                        >
                            <span>{{ row.category }}</span>
                            <span class="font-medium">{{
                                row.total_amount
                            }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-lg border bg-card">
                    <div class="border-b px-4 py-3 text-sm font-medium">
                        Expenses (snapshot, top 50)
                    </div>
                    <div
                        v-if="expense_snapshots.length === 0"
                        class="px-4 py-6 text-sm text-muted-foreground"
                    >
                        No snapshot rows.
                    </div>
                    <ul v-else class="divide-y">
                        <li
                            v-for="row in expense_snapshots"
                            :key="row.name"
                            class="flex items-center justify-between px-4 py-2 text-sm"
                        >
                            <span>{{ row.name }}</span>
                            <span class="font-medium">{{ row.amount }}</span>
                        </li>
                    </ul>
                </div>

                <div class="rounded-lg border bg-card">
                    <div class="border-b px-4 py-3 text-sm font-medium">
                        Incomes (snapshot, top 50)
                    </div>
                    <div
                        v-if="income_snapshots.length === 0"
                        class="px-4 py-6 text-sm text-muted-foreground"
                    >
                        No snapshot rows.
                    </div>
                    <ul v-else class="divide-y">
                        <li
                            v-for="row in income_snapshots"
                            :key="row.name"
                            class="flex items-center justify-between px-4 py-2 text-sm"
                        >
                            <span>{{ row.name }}</span>
                            <span class="font-medium">{{ row.amount }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </AppShell>
</template>
