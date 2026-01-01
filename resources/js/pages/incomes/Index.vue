<script setup lang="ts">
import AppShell from '@/components/AppShell.vue'
import Heading from '@/components/Heading.vue'
import { Button } from '@/components/ui/button'
import { Link } from '@inertiajs/vue3'

type Income = {
    id: number
    name: string
    edit_url: string
    destroy_url: string
}

defineProps<{
    incomes: Income[]
    create_url: string
}>()
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
                <div class="border-b px-4 py-3 text-sm font-medium">Registered incomes</div>

                <div v-if="incomes.length === 0" class="px-4 py-6 text-sm text-muted-foreground">No incomes yet.</div>

                <ul v-else class="divide-y">
                    <li
                        v-for="income in incomes"
                        :key="income.id"
                        class="flex items-center justify-between gap-4 px-4 py-3"
                    >
                        <span>{{ income.name }}</span>

                        <div class="flex items-center gap-2">
                            <Link :href="income.edit_url" as="button">
                                <Button variant="secondary" size="sm">Edit</Button>
                            </Link>

                            <Link :href="income.destroy_url" method="delete" as="button">
                                <Button variant="destructive" size="sm">Delete</Button>
                            </Link>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AppShell>
</template>
