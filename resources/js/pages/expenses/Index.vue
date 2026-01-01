<script setup lang="ts">
import AppShell from '@/components/AppShell.vue'
import Heading from '@/components/Heading.vue'
import { Button } from '@/components/ui/button'
import { Link, router } from '@inertiajs/vue3'

type Option = {
    id: number
    name: string
}

type ExpenseRow = {
    id: number
    name: string
    amount: string
    active: boolean
    created_at: string | null
    category: Option | null
    payment_method: Option | null
    edit_url: string
    destroy_url: string
}

type PaginationLink = {
    url: string | null
    label: string
    active: boolean
}

type Paginator<T> = {
    data: T[]
    links: PaginationLink[]
    current_page: number
    last_page: number
    per_page: number
    total: number
}

type Filters = {
    category_id: number | null
    payment_method_id: number | null
    per_page: number
}

const props = defineProps<{
    expenses: Paginator<ExpenseRow>
    create_url: string
    index_url: string
    filters: Filters
    categories: Option[]
    payment_methods: Option[]
    per_page_options: number[]
    page_total_amount: string
}>()

function applyFilters(next: Partial<Filters>) {
    router.get(
        props.index_url,
        {
            category_id: next.category_id ?? props.filters.category_id,
            payment_method_id: next.payment_method_id ?? props.filters.payment_method_id,
            per_page: next.per_page ?? props.filters.per_page,
        },
        {
            preserveState: true,
            preserveScroll: true,
        },
    )
}
</script>

<template>
    <AppShell>
        <div class="space-y-6">
            <div class="flex items-start justify-between gap-4">
                <Heading title="Expenses" description="Manage your expenses" />

                <Link :href="create_url" as="button">
                    <Button size="sm">Create</Button>
                </Link>
            </div>

            <div class="rounded-lg border bg-card p-4">
                <div class="grid gap-4 md:grid-cols-3">
                    <div class="grid gap-2">
                        <label class="text-sm font-medium" for="category_id">Category</label>
                        <select
                            id="category_id"
                            class="h-9 rounded-md border bg-background px-3 text-sm"
                            :value="filters.category_id ?? ''"
                            @change="applyFilters({ category_id: $event.target.value ? Number($event.target.value) : null })"
                        >
                            <option value="">All</option>
                            <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                        </select>
                    </div>

                    <div class="grid gap-2">
                        <label class="text-sm font-medium" for="payment_method_id">Payment method</label>
                        <select
                            id="payment_method_id"
                            class="h-9 rounded-md border bg-background px-3 text-sm"
                            :value="filters.payment_method_id ?? ''"
                            @change="applyFilters({ payment_method_id: $event.target.value ? Number($event.target.value) : null })"
                        >
                            <option value="">All</option>
                            <option v-for="pm in payment_methods" :key="pm.id" :value="pm.id">{{ pm.name }}</option>
                        </select>
                    </div>

                    <div class="grid gap-2">
                        <label class="text-sm font-medium" for="per_page">Per page</label>
                        <select
                            id="per_page"
                            class="h-9 rounded-md border bg-background px-3 text-sm"
                            :value="filters.per_page"
                            @change="applyFilters({ per_page: Number($event.target.value) })"
                        >
                            <option v-for="o in per_page_options" :key="o" :value="o">{{ o }}</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 text-sm text-muted-foreground">
                    Total on this page: <span class="font-medium text-foreground">{{ page_total_amount }}</span>
                </div>
            </div>

            <div class="rounded-lg border bg-card">
                <div class="border-b px-4 py-3 text-sm font-medium">Registered expenses</div>

                <div v-if="expenses.data.length === 0" class="px-4 py-6 text-sm text-muted-foreground">
                    No expenses yet.
                </div>

                <ul v-else class="divide-y">
                    <li
                        v-for="expense in expenses.data"
                        :key="expense.id"
                        class="flex items-center justify-between gap-4 px-4 py-3"
                    >
                        <div class="space-y-1">
                            <div class="flex items-center gap-3">
                                <span class="font-medium">{{ expense.name }}</span>
                                <span class="text-sm text-muted-foreground">{{ expense.amount }}</span>
                            </div>
                            <div class="text-xs text-muted-foreground">
                                <span v-if="expense.category">{{ expense.category.name }}</span>
                                <span v-else>Uncategorized</span>
                                <span class="px-1">·</span>
                                <span v-if="expense.payment_method">{{ expense.payment_method.name }}</span>
                                <span v-else>No payment method</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <Link :href="expense.edit_url" as="button">
                                <Button variant="secondary" size="sm">Edit</Button>
                            </Link>

                            <Link :href="expense.destroy_url" method="delete" as="button">
                                <Button variant="destructive" size="sm">Delete</Button>
                            </Link>
                        </div>
                    </li>
                </ul>

                <div v-if="expenses.links && expenses.links.length > 0" class="border-t px-4 py-3">
                    <div class="flex flex-wrap gap-2">
                        <Link
                            v-for="link in expenses.links"
                            :key="link.label"
                            :href="link.url ?? ''"
                            as="button"
                            :disabled="link.url === null"
                        >
                            <Button
                                size="sm"
                                variant="secondary"
                                :disabled="link.url === null"
                                :class="link.active ? 'border border-primary' : ''"
                            >
                                <span v-html="link.label" />
                            </Button>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppShell>
</template>
