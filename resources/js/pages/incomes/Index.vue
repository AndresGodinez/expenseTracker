<script setup lang="ts">
import AppShell from '@/components/AppShell.vue';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Link, router } from '@inertiajs/vue3';

type Option = {
    id: number;
    name: string;
};

type IncomeRow = {
    id: number;
    name: string;
    amount: string;
    created_at: string | null;
    category_income: Option | null;
    account: Option | null;
    edit_url: string;
    destroy_url: string;
};

type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

type Paginator<T> = {
    data: T[];
    links: PaginationLink[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
};

type Filters = {
    category_income_id: number | null;
    account_id: number | null;
    per_page: number;
};

const props = defineProps<{
    incomes: Paginator<IncomeRow>;
    create_url: string;
    index_url: string;
    filters: Filters;
    category_incomes: Option[];
    accounts: Option[];
    per_page_options: number[];
    page_total_amount: string;
}>();

function applyFilters(next: Partial<Filters>) {
    router.get(
        props.index_url,
        {
            category_income_id:
                next.category_income_id ?? props.filters.category_income_id,
            account_id: next.account_id ?? props.filters.account_id,
            per_page: next.per_page ?? props.filters.per_page,
        },
        {
            preserveState: true,
            preserveScroll: true,
        },
    );
}
</script>

<template>
    <AppShell>
        <div class="space-y-6">
            <div class="flex items-start justify-between gap-4">
                <Heading title="Incomes" description="Manage your incomes" />

                <Link :href="create_url" as="button">
                    <Button size="sm">Create</Button>
                </Link>
            </div>

            <div class="rounded-lg border bg-card">
                <div class="border-b px-4 py-3 text-sm font-medium">
                    Registered incomes
                </div>

                <div class="border-b px-4 py-4">
                    <div class="grid gap-4 md:grid-cols-3">
                        <div class="grid gap-2">
                            <label
                                class="text-sm font-medium"
                                for="category_income_id"
                                >Category income</label
                            >
                            <select
                                id="category_income_id"
                                class="h-9 rounded-md border bg-background px-3 text-sm"
                                :value="filters.category_income_id ?? ''"
                                @change="
                                    applyFilters({
                                        category_income_id: $event.target.value
                                            ? Number($event.target.value)
                                            : null,
                                    })
                                "
                            >
                                <option value="">All</option>
                                <option
                                    v-for="c in category_incomes"
                                    :key="c.id"
                                    :value="c.id"
                                >
                                    {{ c.name }}
                                </option>
                            </select>
                        </div>

                        <div class="grid gap-2">
                            <label class="text-sm font-medium" for="account_id"
                                >Account</label
                            >
                            <select
                                id="account_id"
                                class="h-9 rounded-md border bg-background px-3 text-sm"
                                :value="filters.account_id ?? ''"
                                @change="
                                    applyFilters({
                                        account_id: $event.target.value
                                            ? Number($event.target.value)
                                            : null,
                                    })
                                "
                            >
                                <option value="">All</option>
                                <option
                                    v-for="a in accounts"
                                    :key="a.id"
                                    :value="a.id"
                                >
                                    {{ a.name }}
                                </option>
                            </select>
                        </div>

                        <div class="grid gap-2">
                            <label class="text-sm font-medium" for="per_page"
                                >Per page</label
                            >
                            <select
                                id="per_page"
                                class="h-9 rounded-md border bg-background px-3 text-sm"
                                :value="filters.per_page"
                                @change="
                                    applyFilters({
                                        per_page: Number($event.target.value),
                                    })
                                "
                            >
                                <option
                                    v-for="o in per_page_options"
                                    :key="o"
                                    :value="o"
                                >
                                    {{ o }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 text-sm text-muted-foreground">
                        Total on this page:
                        <span class="font-medium text-foreground">{{
                            page_total_amount
                        }}</span>
                    </div>
                </div>

                <div
                    v-if="incomes.data.length === 0"
                    class="px-4 py-6 text-sm text-muted-foreground"
                >
                    No incomes yet.
                </div>

                <ul v-else class="divide-y">
                    <li
                        v-for="income in incomes.data"
                        :key="income.id"
                        class="flex items-center justify-between gap-4 px-4 py-3"
                    >
                        <div class="space-y-1">
                            <div class="flex items-center gap-3">
                                <span class="font-medium">{{
                                    income.name
                                }}</span>
                                <span class="text-sm text-muted-foreground">{{
                                    income.amount
                                }}</span>
                            </div>
                            <div class="text-xs text-muted-foreground">
                                <span v-if="income.category_income">{{
                                    income.category_income.name
                                }}</span>
                                <span v-else>-</span>
                                <span class="px-1">·</span>
                                <span v-if="income.account">{{
                                    income.account.name
                                }}</span>
                                <span v-else>-</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <Link :href="income.edit_url" as="button">
                                <Button variant="secondary" size="sm"
                                    >Edit</Button
                                >
                            </Link>

                            <Link
                                :href="income.destroy_url"
                                method="delete"
                                as="button"
                            >
                                <Button variant="destructive" size="sm"
                                    >Delete</Button
                                >
                            </Link>
                        </div>
                    </li>
                </ul>

                <div
                    v-if="incomes.links && incomes.links.length > 0"
                    class="border-t px-4 py-3"
                >
                    <div class="flex flex-wrap gap-2">
                        <Link
                            v-for="link in incomes.links"
                            :key="link.label"
                            :href="link.url ?? ''"
                            as="button"
                            :disabled="link.url === null"
                        >
                            <Button
                                size="sm"
                                variant="secondary"
                                :disabled="link.url === null"
                                :class="
                                    link.active ? 'border border-primary' : ''
                                "
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
