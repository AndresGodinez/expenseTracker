<script setup lang="ts">
import AppShell from '@/components/AppShell.vue'
import Heading from '@/components/Heading.vue'
import { Button } from '@/components/ui/button'
import { Link } from '@inertiajs/vue3'

type CategoryIncome = {
    id: number
    name: string
    edit_url: string
    destroy_url: string
}

defineProps<{
    category_incomes: CategoryIncome[]
    create_url: string
}>()
</script>

<template>
    <AppShell>
        <div class="space-y-6">
            <div class="flex items-start justify-between gap-4">
                <Heading title="Income categories" description="Manage your income categories" />

                <Link :href="create_url" as="button">
                    <Button size="sm">Create</Button>
                </Link>
            </div>

            <div class="rounded-lg border bg-card">
                <div class="border-b px-4 py-3 text-sm font-medium">Registered income categories</div>

                <div
                    v-if="category_incomes.length === 0"
                    class="px-4 py-6 text-sm text-muted-foreground"
                >
                    No income categories yet.
                </div>

                <ul v-else class="divide-y">
                    <li
                        v-for="categoryIncome in category_incomes"
                        :key="categoryIncome.id"
                        class="flex items-center justify-between gap-4 px-4 py-3"
                    >
                        <span>{{ categoryIncome.name }}</span>

                        <div class="flex items-center gap-2">
                            <Link :href="categoryIncome.edit_url" as="button">
                                <Button variant="secondary" size="sm">Edit</Button>
                            </Link>

                            <Link :href="categoryIncome.destroy_url" method="delete" as="button">
                                <Button variant="destructive" size="sm">Delete</Button>
                            </Link>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AppShell>
</template>
