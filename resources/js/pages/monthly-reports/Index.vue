<script setup lang="ts">
import AppShell from '@/components/AppShell.vue'
import Heading from '@/components/Heading.vue'
import { Button } from '@/components/ui/button'
import { Link } from '@inertiajs/vue3'

type ReportRow = {
    id: number
    month_start: string
    month_end: string
    total_expenses_amount: string
    total_incomes_amount: string
    balance_amount: string
    expenses_change_amount: string | null
    expenses_change_percent: string | null
    incomes_change_amount: string | null
    incomes_change_percent: string | null
    balance_change_amount: string | null
    balance_change_percent: string | null
    show_url: string
}

defineProps<{
    reports: ReportRow[]
}>()
</script>

<template>
    <AppShell>
        <div class="space-y-6">
            <div class="flex items-start justify-between gap-4">
                <Heading title="Monthly reports" description="Monthly expenses/incomes snapshots" />
            </div>

            <div class="rounded-lg border bg-card">
                <div class="border-b px-4 py-3 text-sm font-medium">Last 12 months</div>

                <div v-if="reports.length === 0" class="px-4 py-6 text-sm text-muted-foreground">No reports yet.</div>

                <ul v-else class="divide-y">
                    <li v-for="r in reports" :key="r.id" class="flex items-center justify-between gap-4 px-4 py-3">
                        <div class="space-y-1">
                            <div class="font-medium">{{ r.month_start }} → {{ r.month_end }}</div>
                            <div class="text-xs text-muted-foreground">
                                Gastos: {{ r.total_expenses_amount }} · Ingresos: {{ r.total_incomes_amount }} · Balance: {{ r.balance_amount }}
                            </div>
                            <div class="text-xs text-muted-foreground">
                                Δ Gastos: {{ r.expenses_change_amount ?? '—' }} ({{ r.expenses_change_percent ?? '—' }})
                                <span class="px-1">·</span>
                                Δ Ingresos: {{ r.incomes_change_amount ?? '—' }} ({{ r.incomes_change_percent ?? '—' }})
                                <span class="px-1">·</span>
                                Δ Balance: {{ r.balance_change_amount ?? '—' }} ({{ r.balance_change_percent ?? '—' }})
                            </div>
                        </div>

                        <Link :href="r.show_url" as="button">
                            <Button size="sm" variant="secondary">View</Button>
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </AppShell>
</template>
